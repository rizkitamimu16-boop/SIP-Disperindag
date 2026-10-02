@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - Panel Administrator')

@section('header_title', 'Pengaturan Konfigurasi Sistem')
@section('header_subtitle', 'Konfigurasi identitas instansi, geofencing GPS, jam kerja, bobot IKP, threshold SP, dan manajemen akun admin')

@section('header_right')

    <div class="flex items-center space-x-3 bg-[#EEF2FF] px-3.5 py-1.5 rounded-2xl border border-emerald-100/80 shadow-2xs">
        <div class="flex flex-col text-right">
            <span class="text-xs font-bold text-[#1E1B4B] leading-tight">{{ auth()->user()->nama ?? 'Administrator' }}</span>
            <span class="text-[11px] text-emerald-600 font-medium">Sekretariat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#4F46E5] text-white font-bold text-xs flex items-center justify-center shadow-xs">
            {{ strtoupper(substr(auth()->user()->nama ?? 'AD', 0, 2)) }}
        </div>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Flash Message Notifikasi -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-emerald-950">Berhasil Disimpan</h4>
            <p class="mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-red-950">Terjadi Kesalahan</h4>
            <ul class="list-disc list-inside mt-1 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- 1. MANAJEMEN AKUN ADMINISTRATOR -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-gray-100">
            <div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">Manajemen Akun Administrator</h2>
                </div>
                <p class="text-xs text-gray-500 mt-1">Kelola petugas personalia yang memiliki hak akses penuh ke panel administrator sistem.</p>
            </div>
            <button type="button" onclick="openModal('modalTambahAdmin')"
                class="h-10 px-4 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center space-x-2 shrink-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Admin Baru</span>
            </button>
        </div>

        <!-- Tabel Daftar Administrator dari Database -->
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3.5">Administrator</th>
                        <th class="py-3 px-3">Username</th>
                        <th class="py-3 px-3">Email Dinas</th>
                        <th class="py-3 px-3 text-center">Peran</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700" id="tabelAdminBody">
                    @forelse($adminUsers ?? [] as $adm)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3.5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-[#0D2240] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                    {{ strtoupper(substr($adm->nama ?? 'AD', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $adm->nama }}</p>
                                    <span class="text-[11px] text-gray-400 font-mono">ID: ADM-{{ str_pad($adm->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 font-mono font-bold text-gray-800">{{ $adm->username }}</td>
                        <td class="py-3.5 px-3 font-mono text-gray-600">{{ $adm->email }}</td>
                        <td class="py-3.5 px-3 text-center">
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-800 text-xs font-semibold">Administrator</span>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">{{ ucfirst($adm->status) }}</span>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            <button type="button" onclick="openEditAdminModal({{ $adm->id }}, '{{ addslashes($adm->username) }}', '{{ addslashes($adm->nama) }}', '{{ addslashes($adm->email) }}', '{{ $adm->status }}', {{ auth()->id() === 1 && $adm->id !== 1 ? 'true' : 'false' }})" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition cursor-pointer" title="Edit Admin">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Belum ada administrator terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. FORM PENGATURAN INSTANSI, LOKASI, JAM KERJA, BOBOT IKP & SP (Terhubung ke Database) -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs max-w-4xl">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Bagian A: Identitas Instansi & Periode Sistem -->
            <div class="border-b border-gray-100 pb-5">
                <div class="mb-3">
                    <h3 class="text-sm font-bold text-gray-900">Identitas Instansi &amp; Kantor</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama SKPD</label>
                        <input type="text" name="nama_skpd" value="{{ $pengaturan->nama_skpd ?? 'Dinas Perindustrian dan Perdagangan Kota Gorontalo' }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Pemerintah / Instansi Induk</label>
                        <input type="text" name="nama_instansi" value="{{ $pengaturan->nama_instansi ?? 'Pemerintah Kota Gorontalo' }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Alamat Kantor</label>
                        <input type="text" name="alamat_kantor" value="{{ $pengaturan->alamat_kantor ?? 'Jl. Jalaluddin Tantu No. 45, Kota Gorontalo' }}"
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Telepon Resmi Kantor</label>
                        <input type="text" name="telepon_kantor" value="{{ $pengaturan->telepon_kantor ?? '(0435) 821xxx' }}"
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                    </div>
                </div>
            </div>

            <!-- Bagian B: Lokasi & Geofencing GPS -->
            <div class="border-b border-gray-100 pb-5">
                <div class="mb-3">
                    <h3 class="text-sm font-bold text-gray-900">Lokasi &amp; Geofencing Presensi GPS</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Titik Koordinat Kantor (Lat, Long)</label>
                        <input type="text" name="titik_koordinat" value="{{ $pengaturan->titik_koordinat ?? '0.5375000,123.0625000' }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-mono text-gray-800" placeholder="-6.12345, 106.12345">
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Radius Toleransi (Meter)</label>
                        <input type="number" name="radius_absensi_meter" min="10" max="500" value="{{ $pengaturan->radius_absensi_meter ?? 50 }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-bold text-[#0D2240]">
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-2 italic">Presensi di luar radius toleransi maksimal otomatis ditolak oleh validasi server GPS.</p>
                <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl flex items-start space-x-3">
                    <div class="flex items-center h-5">
                        <input id="is_wfh_jumat" name="is_wfh_jumat" type="checkbox" value="1" {{ ($pengaturan->is_wfh_jumat ?? false) ? 'checked' : '' }} class="w-4 h-4 text-[#0D2240] bg-white border-gray-300 rounded focus:ring-[#0D2240] focus:ring-2">
                    </div>
                    <div class="text-xs">
                        <label for="is_wfh_jumat" class="font-bold text-gray-900 cursor-pointer">Izinkan WFH di Hari Jumat (Bebas Radius)</label>
                        <p class="text-gray-600 mt-0.5">Jika diaktifkan, pegawai dapat melakukan absen masuk/pulang dari mana saja khusus pada hari Jumat. Validasi radius otomatis dinonaktifkan.</p>
                    </div>
                </div>
            </div>

            <!-- Bagian C: Jadwal Jam Kerja Absensi (WITA) -->
            <div class="border-b border-gray-100 pb-5">
                <div class="mb-3">
                    <h3 class="text-sm font-bold text-gray-900">Jadwal Jam Kerja Absensi (WITA)</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-xs">
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Jam Masuk Normal</label>
                        <input type="time" name="jam_masuk" value="{{ substr($pengaturan->jam_masuk ?? '07:30:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Mulai presensi datang</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Batas Terlambat</label>
                        <input type="time" name="batas_terlambat" value="{{ substr($pengaturan->batas_terlambat ?? '08:00:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Lewat jam ini: Terlambat</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Batas Akhir Masuk</label>
                        <input type="time" name="batas_akhir_masuk" value="{{ substr($pengaturan->batas_akhir_masuk ?? '11:00:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Lewat jam ini: Ditolak / Alpha</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Jam Pulang (Senin-Kamis)</label>
                        <input type="time" name="jam_pulang" value="{{ substr($pengaturan->jam_pulang ?? '16:30:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Sebelum ini: Pulang Cepat</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Jam Pulang (Jumat)</label>
                        <input type="time" name="jam_pulang_jumat" value="{{ substr($pengaturan->jam_pulang_jumat ?? '16:00:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Hari Jumat</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Batas Akhir Pulang</label>
                        <input type="time" name="batas_akhir_pulang" value="{{ substr($pengaturan->batas_akhir_pulang ?? '19:00:00', 0, 5) }}" required
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-medium">
                        <span class="text-[10px] text-gray-400 mt-0.5 block">Batas maksimal absen pulang</span>
                    </div>
                </div>
            </div>

            <!-- Bagian D: Konfigurasi Bobot Indikator IKP -->
            <div class="border-b border-gray-100 pb-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-3">
                    <div>
                            <h3 class="text-sm font-bold text-gray-900">Bobot Indeks Kinerja Pegawai (IKP)</h3>
                    </div>
                    <span id="labelTotalBobot" class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        Total Bobot: 100% (Valid)
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-gray-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-bold text-gray-800">1. Kehadiran &amp; Ketepatan</label>
                            <span class="font-mono font-bold text-[#0D2240]" id="valBobotKehadiran">{{ $pengaturan->bobot_kehadiran ?? 60 }}%</span>
                        </div>
                        <input type="number" name="bobot_kehadiran" id="inputBobotKehadiran" min="0" max="100" value="{{ $pengaturan->bobot_kehadiran ?? 60 }}" oninput="hitungTotalBobot()"
                            class="w-full h-9 px-3 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-900">
                        <span class="text-[10px] text-gray-400 block">Dihitung dari presensi harian</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-gray-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-bold text-gray-800">2. Produktivitas Kerja</label>
                            <span class="font-mono font-bold text-[#0D2240]" id="valBobotProduktivitas">{{ $pengaturan->bobot_produktivitas ?? 25 }}%</span>
                        </div>
                        <input type="number" name="bobot_produktivitas" id="inputBobotProduktivitas" min="0" max="100" value="{{ $pengaturan->bobot_produktivitas ?? 25 }}" oninput="hitungTotalBobot()"
                            class="w-full h-9 px-3 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-900">
                        <span class="text-[10px] text-gray-400 block">Dihitung dari laporan kegiatan</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-gray-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-bold text-gray-800">3. Kualitas Kerja</label>
                            <span class="font-mono font-bold text-[#0D2240]" id="valBobotKualitas">{{ $pengaturan->bobot_kualitas ?? 15 }}%</span>
                        </div>
                        <input type="number" name="bobot_kualitas" id="inputBobotKualitas" min="0" max="100" value="{{ $pengaturan->bobot_kualitas ?? 15 }}" oninput="hitungTotalBobot()"
                            class="w-full h-9 px-3 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-900">
                        <span class="text-[10px] text-gray-400 block">Penilaian mutu atasan/admin</span>
                    </div>
                </div>
            </div>

            <!-- Bagian E: Ambang Pemicu Surat Peringatan (SP) -->
            <div class="border-b border-gray-100 pb-5">
                <div class="mb-3">
                    <h3 class="text-sm font-bold text-gray-900">Ambang Batas Pemicu Surat Peringatan (SP)</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Akumulasi SP-1 (Hari Alpha)</label>
                        <input type="number" name="ambang_sp1" value="{{ $pengaturan->ambang_sp1 ?? 3 }}" min="1" max="30"
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-bold text-amber-700">
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Akumulasi SP-2 (Hari Alpha)</label>
                        <input type="number" name="ambang_sp2" value="{{ $pengaturan->ambang_sp2 ?? 6 }}" min="1" max="30"
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-bold text-orange-700">
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-medium">Akumulasi SP-3 (Hari Alpha)</label>
                        <input type="number" name="ambang_sp3" value="{{ $pengaturan->ambang_sp3 ?? 9 }}" min="1" max="30"
                            class="w-full h-10 px-3 bg-slate-50 border border-gray-200 rounded-xl font-bold text-red-700">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan Konfigurasi ke Database -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan ke Database MySQL</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function hitungTotalBobot() {
    const k = parseFloat(document.getElementById('inputBobotKehadiran').value) || 0;
    const p = parseFloat(document.getElementById('inputBobotProduktivitas').value) || 0;
    const q = parseFloat(document.getElementById('inputBobotKualitas').value) || 0;
    const total = k + p + q;

    document.getElementById('valBobotKehadiran').textContent = `${k}%`;
    document.getElementById('valBobotProduktivitas').textContent = `${p}%`;
    document.getElementById('valBobotKualitas').textContent = `${q}%`;

    const label = document.getElementById('labelTotalBobot');
    if (total === 100) {
        label.className = 'px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800';
        label.textContent = `Total Bobot: ${total}% (Valid)`;
    } else {
        label.className = 'px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800';
        label.textContent = `Total Bobot: ${total}% (Wajib 100%)`;
    }
}
</script>
@endsection
