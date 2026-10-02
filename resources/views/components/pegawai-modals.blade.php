<!-- ===================================================================
     MODAL 1: PRESENSI KEHADIRAN (ABSEN MASUK & PULANG) - PERSIS GAMBAR 1
     =================================================================== -->
<div id="modalPresensiKehadiran"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div
        class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="p-5 sm:p-6 border-b border-gray-100 flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Kota Gorontalo"
                    class="w-10 h-11 object-contain shrink-0">
                <div>
                    <h3 id="modalPresensiTitle" class="text-base sm:text-lg font-bold text-gray-900 leading-tight">
                        Presensi Kehadiran &mdash; Absen Masuk</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Dinas Perindustrian dan Perdagangan &bull; Verifikasi
                        Kamera &amp; GPS</p>
                </div>
            </div>
            <button type="button" onclick="closePresensiModal()"
                class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-5 sm:p-6 space-y-4 max-h-[78vh] overflow-y-auto">
            <!-- Info Pegawai & Server -->
            <div class="bg-sky-50/40 border border-sky-100 rounded-xl p-3.5 space-y-2 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium">Nama Pegawai:</span>
                    <span class="text-gray-900 font-bold">{{ auth()->user()->pegawai->nama ?? auth()->user()->name }} ({{ auth()->user()->pegawai->jabatan ?? 'Pegawai' }})</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium">Waktu Server:</span>
                    <span id="modalLiveClock" class="text-gray-900 font-bold">03:00:11 WITA</span>
                </div>
            </div>

            <!-- Foto Kehadiran Pegawai Box -->
            <div
                class="border border-dashed border-sky-200 bg-sky-50/20 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div id="fotoPresensiThumb"
                        class="w-12 h-12 rounded-xl bg-slate-100 border border-gray-200 flex items-center justify-center text-slate-400 overflow-hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm font-bold text-gray-900">Foto Kehadiran Pegawai</p>
                        <p id="fotoStatusText" class="text-[11px] font-semibold text-emerald-600">Wajah siap
                            diverifikasi</p>
                    </div>
                </div>
                <input type="file" accept="image/*" capture="user" id="inputFotoPresensi" class="hidden" onchange="handleFotoPresensi(this)">
                <button type="button" onclick="document.getElementById('inputFotoPresensi').click()"
                    class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-800 text-xs font-semibold px-3.5 py-2 rounded-xl shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    <span>Ambil / Unggah Foto</span>
                </button>
            </div>

            <!-- Peta & GPS Koordinat Interaktif (Persis Gambar 1) -->
            <div
                class="relative rounded-2xl border border-gray-200 overflow-hidden bg-[#EDF3F8] h-48 flex items-center justify-center">
                <!-- Subtle Map Grid Pattern -->
                <div
                    class="absolute inset-0 bg-[linear-gradient(to_right,#E2E8F0_1px,transparent_1px),linear-gradient(to_bottom,#E2E8F0_1px,transparent_1px)] bg-[size:24px_24px]">
                </div>

                <!-- White Street Cross Lines -->
                <div
                    class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-5 bg-white/80 border-y border-slate-200 pointer-events-none">
                </div>
                <div
                    class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-5 bg-white/80 border-x border-slate-200 pointer-events-none">
                </div>

                <!-- Radius Lingkaran Hijau Putus-putus -->
                <div
                    class="relative z-10 w-28 h-28 rounded-full border-2 border-dashed border-emerald-500 bg-emerald-500/10 flex items-center justify-center animate-pulse">
                    <!-- User Position Dot -->
                    <div class="relative flex items-center justify-center">
                        <div class="w-4 h-4 rounded-full bg-sky-600 ring-4 ring-sky-300"></div>
                        <div class="w-2 rounded-full bg-white absolute"></div>
                    </div>
                </div>

                <!-- Marker Label Kantor DISPERDAGIN -->
                <div class="absolute z-15 top-1/2 left-1/2 -translate-x-1/2 translate-y-2">
                    <div class="flex flex-col items-center">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0D2240] mb-0.5"></div>
                        <span
                            class="bg-[#0D2240] text-white text-[10px] font-bold px-2.5 py-1 rounded shadow tracking-wide">
                            Kantor DISPERDAGIN
                        </span>
                    </div>
                </div>

                <!-- Bottom Bar Koordinat & Sinkronkan -->
                <div class="absolute bottom-2.5 inset-x-3 z-20 flex items-center justify-between gap-2">
                    <div id="modalKoordinatText"
                        class="bg-slate-900/90 backdrop-blur-xs text-white text-[10px] font-mono px-3 py-1.5 rounded-lg shadow-sm font-semibold flex items-center space-x-1.5">
                        <span>Lat: - &bull; Long: -</span>
                    </div>
                    <button type="button" onclick="syncLocation()"
                        class="bg-white/95 hover:bg-white text-gray-800 text-[11px] font-bold px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm cursor-pointer flex items-center space-x-1.5 transition">
                        <svg id="syncIcon" class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Sinkronkan Lokasi</span>
                    </button>
                </div>
            </div>

            <!-- Radius Lokasi Valid Banner -->
            <div id="modalRadiusBanner"
                class="rounded-xl border border-gray-300 bg-gray-50/70 p-3.5 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div id="modalRadiusIconBox"
                        class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p id="modalRadiusTitle" class="text-xs sm:text-sm font-bold text-gray-900">Lokasi Belum Disinkronkan</p>
                        <p id="modalRadiusSubtitle" class="text-[11px] text-gray-500">Tekan tombol Sinkronkan Lokasi terlebih dahulu</p>
                    </div>
                </div>
                <span id="modalRadiusBadge"
                    class="bg-gray-400 text-white text-xs font-black px-3 py-1 rounded-full shadow-xs tracking-wider hidden">
                    -
                </span>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="p-4 sm:p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-3">
            <button type="button" onclick="closePresensiModal()"
                class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 text-xs sm:text-sm font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="konfirmasiPresensi()"
                class="px-6 py-2.5 rounded-xl bg-[#0D2240] hover:bg-[#163660] text-white text-xs sm:text-sm font-bold shadow-md transition cursor-pointer">
                Konfirmasi Presensi
            </button>
        </div>
    </div>
</div>

<!-- ===================================================================
     MODAL 2: PELAPORAN KEGIATAN KANTOR - PERSIS GAMBAR 2
     =================================================================== -->
<div id="modalPelaporanKegiatan"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div
        class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="p-5 sm:p-6 border-b border-gray-100 flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Kota Gorontalo"
                    class="w-10 h-11 object-contain shrink-0">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 leading-tight">Pelaporan Kegiatan Kantor
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Rekap pekerjaan yang dilakukan di kantor pada jam
                        tertentu</p>
                </div>
            </div>
            <button type="button" onclick="closeKegiatanModal()"
                class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Modal (Terhubung ke Database) -->
        <form id="formModalKegiatan" action="{{ route('pegawai.kegiatan.store') }}" method="POST" enctype="multipart/form-data"
            class="p-5 sm:p-6 space-y-4 max-h-[78vh] overflow-y-auto">
            @csrf
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

            <!-- Nama Pekerjaan / Kegiatan -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5">Nama Pekerjaan /
                    Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" id="kegiatanNama" placeholder="Contoh: Pendataan Harga Pasar Sentral"
                    class="w-full text-xs sm:text-sm bg-white border border-gray-300 rounded-xl p-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#0D2240] focus:outline-none transition"
                    required>
            </div>

            <!-- Deskripsi Hasil Pekerjaan -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5">Deskripsi Hasil
                    Pekerjaan <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="kegiatanDeskripsi" rows="4"
                    placeholder="Jelaskan ringkasan uraian tugas apa saja yang telah dikerjakan secara rinci..."
                    class="w-full text-xs sm:text-sm bg-white border border-gray-300 rounded-xl p-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#0D2240] focus:outline-none transition"
                    required></textarea>
            </div>

            <!-- Foto Dokumentasi Pekerjaan (Opsional) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-900 mb-1.5">Foto Dokumentasi Pekerjaan
                    (Opsional)</label>
                <div
                    class="border border-dashed border-gray-300 bg-slate-50/50 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div id="fotoKegiatanThumb"
                            class="w-12 h-12 rounded-xl bg-slate-100 border border-gray-200 flex items-center justify-center text-slate-400 overflow-hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900">Foto Dokumentasi</p>
                            <p id="fotoKegiatanStatus" class="text-[11px] text-gray-400">Belum ada foto</p>
                        </div>
                    </div>
                    <input type="file" name="foto" id="uploadFotoKegiatan" class="hidden" accept="image/*"
                        onchange="handleFotoKegiatanUploaded(this)">
                    <button type="button" onclick="document.getElementById('uploadFotoKegiatan').click()"
                        class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-800 text-xs font-semibold px-3.5 py-2 rounded-xl shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        </svg>
                        <span>Pilih Foto</span>
                    </button>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <button type="button" onclick="closeKegiatanModal()"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 text-xs sm:text-sm font-semibold transition cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#0D2240] hover:bg-[#163660] text-white text-xs sm:text-sm font-bold shadow-md transition cursor-pointer">
                    Kirim Laporan ke Database
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview Berkas Resmi (SK Cuti / SPT) untuk Pegawai -->
@include('components.modal-preview-lampiran')

<!-- Modal Bukti Foto Presensi -->
<div id="modalBuktiFoto" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-5 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
            <h3 class="text-sm font-bold text-gray-900">Bukti Foto Presensi</h3>
            <button onclick="closeModal('modalBuktiFoto')" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-3">
            <img id="fotoModalImage" src="" alt="Bukti Presensi" class="w-full h-auto max-h-64 object-contain rounded-xl border border-gray-200 bg-slate-50">
            <div class="text-xs space-y-1 text-gray-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <p><span class="font-bold text-gray-500 w-16 inline-block">Waktu:</span> <span id="fotoModalJam"></span></p>
                <p><span class="font-bold text-gray-500 w-16 inline-block">Jarak:</span> <span id="fotoModalJarak"></span></p>
                <p><span class="font-bold text-gray-500 w-16 inline-block">Status:</span> <span id="fotoModalStatus"></span></p>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button onclick="closeModal('modalBuktiFoto')" class="px-5 py-2 bg-slate-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-slate-200 w-full cursor-pointer">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Foto Laporan Kegiatan -->
<div id="modalFotoLaporan" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-5 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
            <h3 class="text-sm font-bold text-gray-900">Foto Dokumentasi Laporan</h3>
            <button onclick="closeModal('modalFotoLaporan')" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-3">
            <img id="fotoLaporanModalImage" src="" alt="Bukti Laporan" class="w-full h-auto max-h-64 object-contain rounded-xl border border-gray-200 bg-slate-50">
            <div class="text-xs space-y-1 text-gray-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <p><span class="font-bold text-gray-500 w-16 inline-block">Kegiatan:</span> <span id="fotoLaporanModalKegiatan"></span></p>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button onclick="closeModal('modalFotoLaporan')" class="px-5 py-2 bg-slate-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-slate-200 w-full cursor-pointer">Tutup</button>
        </div>
    </div>
</div>

