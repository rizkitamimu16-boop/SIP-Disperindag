<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiAbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $employee = Auth::user()->pegawai;
        $today = Carbon::today()->toDateString();
        $todayAttendance = null;
        $attendances = collect();

        if ($employee) {
            $todayAttendance = Presensi::where('pegawai_id', $employee->id)
                ->where('tanggal', $today)
                ->first();

            $query = Presensi::where('pegawai_id', $employee->id)->latest('tanggal');
            
            if ($request->filled('month')) {
                $query->whereMonth('tanggal', Carbon::parse($request->month)->month);
            }
            if ($request->filled('status') && $request->status !== 'semua') {
                if ($request->status === 'hadir') {
                    $query->whereIn('status', ['Hadir', 'Terlambat']);
                } else if (in_array($request->status, ['izin', 'cuti', 'sakit', 'dinas_luar'])) {
                    $query->where('status', 'like', "%{$request->status}%");
                } else {
                    $query->where('status', ucfirst($request->status));
                }
            }

            $attendances = $query->take(30)->get();
        }

        $officeSettings = PengaturanKantor::getPengaturan();

        return view('pegawai.riwayat-absensi', compact('employee', 'todayAttendance', 'attendances', 'officeSettings'));
    }

    /**
     * Rekam presensi datang / pulang via GPS & Foto
     */
    public function record(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type'      => 'required|in:masuk,pulang',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo'     => 'required|string',
        ]);

        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Data pegawai tidak ditemukan.'], 404);
        }

        $office = PengaturanKantor::getPengaturan();
        $coords = explode(',', $office->titik_koordinat ?? '0.5573330,123.0562500');
        $officeLat = trim($coords[0] ?? '0.5573330');
        $officeLng = trim($coords[1] ?? '123.0562500');
        $distance = $this->calculateDistance($validated['latitude'], $validated['longitude'], $officeLat, $officeLng);

        // Validasi radius geofencing
        $now = Carbon::now();
        $isJumat = $now->isFriday();
        
        $bypassRadius = ($isJumat && $office->is_wfh_jumat);

        if (!$bypassRadius && $distance > $office->radius_absensi_meter) {
            return response()->json([
                'success'  => false,
                'message'  => "Anda berada di luar radius kantor! Jarak Anda: " . round($distance) . " meter (Maksimal {$office->radius_absensi_meter} meter dari titik koordinat kantor Disperindag).",
                'distance' => round($distance, 1)
            ], 422);
        }

        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        $attendance = Presensi::where('pegawai_id', $employee->id)
            ->where('tanggal', $today)
            ->first();

        if ($validated['type'] === 'pulang') {
            if (!$attendance || !$attendance->jam_masuk) {
                return response()->json(['success' => false, 'message' => 'Anda belum melakukan absen datang. Silakan absen datang terlebih dahulu.'], 422);
            }
        } else {
            if (!$attendance) {
                $attendance = Presensi::create([
                    'pegawai_id' => $employee->id,
                    'tanggal' => $today,
                    'status' => 'Hadir'
                ]);
            }
        }

        // Process Base64 Photo
        $photoPath = null;
        if (!empty($validated['photo'])) {
            $imageParts = explode(";base64,", $validated['photo']);
            if (count($imageParts) == 2) {
                $imageTypeAux = explode("image/", $imageParts[0]);
                $imageType = $imageTypeAux[1] ?? 'jpg';
                $imageBase64 = base64_decode($imageParts[1]);
                $fileName = 'absensi/' . $employee->id . '_' . time() . '.' . $imageType;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageBase64);
                $photoPath = $fileName;
            }
        }

        if ($validated['type'] === 'masuk') {
            if ($attendance->jam_masuk) {
                return response()->json(['success' => false, 'message' => 'Anda sudah melakukan absen masuk hari ini.'], 422);
            }

            $batasTerlambat = Carbon::createFromTimeString($office->batas_terlambat);
            $batasAkhirMasuk = Carbon::createFromTimeString($office->batas_akhir_masuk);
            $now = Carbon::now();

            if ($now->gt($batasAkhirMasuk)) {
                return response()->json(['success' => false, 'message' => 'Batas waktu absen masuk telah lewat (' . $office->batas_akhir_masuk . '). Anda tidak dapat absen masuk hari ini.'], 422);
            }

            $isLate = $now->gt($batasTerlambat);

            $attendance->update([
                'jam_masuk'    => $nowTime,
                'status_masuk' => $isLate ? 'Terlambat' : 'Tepat Waktu',
                'jarak_masuk'  => $distance,
                'foto_masuk'   => $photoPath,
                'status'       => $isLate ? 'Terlambat' : 'Hadir',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi masuk berhasil dicatat ' . ($isLate ? '(Terlambat)' : '(Tepat Waktu)'),
                'time'    => $nowTime
            ]);
        } else {
            if ($attendance->jam_pulang) {
                return response()->json(['success' => false, 'message' => 'Anda sudah melakukan absen pulang hari ini.'], 422);
            }

            $now = Carbon::now();
            $batasAkhirPulang = Carbon::createFromTimeString($office->batas_akhir_pulang);

            if ($now->gt($batasAkhirPulang)) {
                return response()->json(['success' => false, 'message' => 'Batas waktu absen pulang telah lewat (' . $office->batas_akhir_pulang . '). Anda tidak dapat absen pulang hari ini.'], 422);
            }

            $jamPulangNormal = $now->isFriday() 
                ? Carbon::createFromTimeString($office->jam_pulang_jumat) 
                : Carbon::createFromTimeString($office->jam_pulang);

            $isPulangCepat = $now->lt($jamPulangNormal);

            $attendance->update([
                'jam_pulang'    => $nowTime,
                'status_pulang' => $isPulangCepat ? 'Pulang Cepat' : 'Tepat Waktu',
                'jarak_pulang'  => $distance,
                'foto_pulang'   => $photoPath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi pulang berhasil dicatat ' . ($isPulangCepat ? '(Pulang Cepat)' : '(Tepat Waktu)'),
                'time'    => $nowTime
            ]);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    public function exportPdf(Request $request)
    {
        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $query = Presensi::where('pegawai_id', $employee->id)->latest('tanggal');
        
        if ($request->filled('month')) {
            $query->whereMonth('tanggal', Carbon::parse($request->month)->month);
        }
        if ($request->filled('status') && $request->status !== 'semua') {
            if ($request->status === 'hadir') {
                $query->whereIn('status', ['Hadir', 'Terlambat']);
            } else if (in_array($request->status, ['izin', 'cuti', 'sakit', 'dinas_luar'])) {
                $query->where('status', 'like', "%{$request->status}%");
            } else {
                $query->where('status', ucfirst($request->status));
            }
        }

        $attendances = $query->get();
        $monthLabel = $request->filled('month') ? Carbon::parse($request->month)->translatedFormat('F Y') : 'Keseluruhan';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pegawai.exports.absensi-pdf', compact('employee', 'attendances', 'monthLabel'));
        return $pdf->download('Riwayat_Absensi_' . str_replace(' ', '_', $employee->nama) . '.pdf');
    }
}
