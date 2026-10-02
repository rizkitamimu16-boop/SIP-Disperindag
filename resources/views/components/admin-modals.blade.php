<!-- Modal 1: Tambah Pegawai Baru (Terhubung ke Database) -->
<div id="modalTambahPegawai" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-gray-900">Tambah Pegawai PPPK Baru</h3>
                <p class="text-[11px] text-gray-500">Mendaftarkan data pegawai baru ke database Disperindag</p>
            </div>
            <button onclick="closeModal('modalTambahPegawai')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.pegawai.store') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nomor Induk Pegawai (NIP) <span class="text-red-500">*</span></label>
                <input type="text" name="nip" placeholder="Contoh: 19950620 202203 2 007" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none font-mono">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                <input type="text" name="nama" placeholder="Nama lengkap pegawai beserta gelar..." required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Bidang Resmi <span class="text-red-500">*</span></label>
                    <select name="bidang" required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                        <option value="Sekretariat">Sekretariat</option>
                        <option value="Perdagangan">Perdagangan</option>
                        <option value="Perindustrian">Perindustrian</option>
                        <option value="Perlindungan Konsumen">Perlindungan Konsumen</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" placeholder="Contoh: Staf Pemantau Pasar..." required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Email Kedinasan <span class="text-red-500">*</span></label>
                    <input type="email" name="email" placeholder="nama@disperindag.gorontalokota.go.id" required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="tel" name="no_hp" placeholder="08xxxxxxxxxx"
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Username Login</label>
                    <input type="text" name="username" placeholder="Otomatis jika kosong..."
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none font-mono">
                    <span class="text-[10px] text-gray-400">Default: diambil dari nama & NIP</span>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Kata Sandi Awal</label>
                    <input type="password" name="password" placeholder="Default: pegawai123"
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                    <span class="text-[10px] text-gray-400">Kosongkan untuk kata sandi bawaan</span>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Alamat Domisili</label>
                <textarea name="alamat" rows="2" placeholder="Alamat tempat tinggal pegawai..."
                    class="w-full p-2.5 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTambahPegawai')"
                    class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
                <button type="submit"
                    class="px-5 py-2 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl font-bold shadow-xs cursor-pointer flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Pegawai ke Database</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 1.5: Edit Pegawai -->
<div id="modalEditPegawai" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-gray-900">Edit Data Pegawai PPPK</h3>
                <p class="text-[11px] text-gray-500">Ubah informasi biodata, bidang, atau status pegawai</p>
            </div>
            <button onclick="closeModal('modalEditPegawai')" type="button"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="formEditPegawai" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nomor Induk Pegawai (NIP) <span class="text-red-500">*</span></label>
                <input type="text" name="nip" id="edit_nip" placeholder="Contoh: 19950620 202203 2 007" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none font-mono">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="edit_nama" placeholder="Nama lengkap pegawai beserta gelar..." required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Bidang Resmi <span class="text-red-500">*</span></label>
                    <select name="bidang" id="edit_bidang" required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                        <option value="Sekretariat">Sekretariat</option>
                        <option value="Perdagangan">Perdagangan</option>
                        <option value="Perindustrian">Perindustrian</option>
                        <option value="Perlindungan Konsumen">Perlindungan Konsumen</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" id="edit_jabatan" placeholder="Contoh: Staf Pemantau Pasar..." required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Email Kedinasan <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="edit_email" placeholder="nama@disperindag.gorontalokota.go.id" required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Status Kepegawaian <span class="text-red-500">*</span></label>
                    <select name="status" id="edit_status" required
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="tel" name="no_hp" id="edit_no_hp" placeholder="08xxxxxxxxxx"
                        class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Alamat Domisili</label>
                <textarea name="alamat" id="edit_alamat" rows="2" placeholder="Alamat tempat tinggal pegawai..."
                    class="w-full p-2.5 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalEditPegawai')"
                    class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
                <button type="submit"
                    class="px-5 py-2 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl font-bold shadow-xs cursor-pointer flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Detail Pegawai -->
<div id="modalDetailPegawai" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Detail Informasi Pegawai</h3>
            <button onclick="closeModal('modalDetailPegawai')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-4 space-y-3 text-xs">
            <div class="flex items-center space-x-3.5 pb-3 border-b border-gray-100">
                <div id="detailAvatar"
                    class="w-12 h-12 rounded-2xl bg-[#0D2240] text-white font-bold text-base flex items-center justify-center">
                    PG
                </div>
                <div>
                    <h4 id="detailNama" class="text-sm font-bold text-gray-900">Nama Pegawai</h4>
                    <p id="detailJabatan" class="text-gray-500">Jabatan</p>
                    <span id="detailId" class="text-[11px] font-mono text-sky-600 font-semibold">NIP</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2.5 pt-1">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100">
                    <span class="text-gray-400 block text-[10px]">NIP</span>
                    <span id="detailNip" class="font-mono font-bold text-gray-800">-</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100">
                    <span class="text-gray-400 block text-[10px]">Bidang</span>
                    <span id="detailBidang" class="font-bold text-gray-800">Sekretariat</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100">
                    <span class="text-gray-400 block text-[10px]">Email Dinas</span>
                    <span id="detailEmail" class="font-bold text-gray-800 truncate block">-</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100">
                    <span class="text-gray-400 block text-[10px]">Status Kepegawaian</span>
                    <span id="detailStatus" class="font-bold text-emerald-700">Aktif</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100">
                    <span class="text-gray-400 block text-[10px]">No. Handphone / WA</span>
                    <span id="detailNoHp" class="font-bold text-gray-800 font-mono">-</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100 col-span-2">
                    <span class="text-gray-400 block text-[10px]">Alamat Domisili</span>
                    <span id="detailAlamat" class="font-bold text-gray-800 block text-xs">-</span>
                </div>
            </div>
            <div class="flex justify-end pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalDetailPegawai')"
                    class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl font-semibold hover:bg-slate-200 cursor-pointer">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Reset Kata Sandi Pegawai -->
<div id="modalResetSandiPegawai" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Reset Kata Sandi</h3>
                    <p class="text-[11px] text-gray-500">Kembalikan ke sandi bawaan</p>
                </div>
            </div>
            <button onclick="closeModal('modalResetSandiPegawai')" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="mt-4 text-xs text-gray-600 space-y-3">
            <p>
                Apakah Anda yakin ingin mereset kata sandi akun untuk pegawai bernama <strong id="resetPegawaiNama" class="text-gray-900"></strong>?
            </p>
            <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-start space-x-2">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-amber-800 leading-relaxed">
                    Kata sandi akan diubah menjadi default: <code class="font-bold text-amber-900 bg-amber-100 px-1.5 py-0.5 rounded">pegawai123</code>
                </p>
            </div>
        </div>

        <form id="formResetSandiPegawai" method="POST" class="mt-5 flex justify-end space-x-2 pt-3 border-t border-gray-100">
            @csrf
            <button type="button" onclick="closeModal('modalResetSandiPegawai')"
                class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl text-xs font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
            <button type="submit"
                class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-xs cursor-pointer">Ya, Reset Sandi</button>
        </form>
    </div>
</div>

<!-- Modal 4: Konfirmasi Hapus Pegawai -->
<div id="modalHapusPegawai" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150">
        <div class="text-center">
            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-700 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900">Hapus Data Pegawai</h3>
            <p class="text-xs text-gray-500 mt-1">
                Data pegawai <strong id="hapusPegawaiNama" class="text-gray-800"></strong> beserta akun login dan seluruh rekap presensinya akan dihapus permanen dari sistem.
            </p>
        </div>

        <form id="formHapusPegawai" method="POST" class="mt-5 flex justify-center space-x-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModal('modalHapusPegawai')"
                class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl text-xs font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
            <button type="submit"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-xs cursor-pointer">Hapus Permanen</button>
        </form>
    </div>
</div>

<!-- Modal 5: Review Pengajuan (Cuti / Izin) -->
<div id="modalReviewPengajuan"
    class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Review Pengajuan Pegawai</h3>
            <button onclick="closeModal('modalReviewPengajuan')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-4 space-y-3 text-xs">
            <div class="p-3 rounded-xl bg-slate-50 border border-gray-100 space-y-1.5">
                <div class="flex justify-between">
                    <span class="text-gray-500">Pegawai Pemohon:</span>
                    <strong id="reviewModalNama" class="text-gray-900">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jenis Pengajuan:</span>
                    <strong id="reviewModalJenis" class="text-emerald-700 font-bold">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Waktu Pelaksanaan:</span>
                    <strong id="reviewModalWaktu" class="text-gray-900">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Keterangan / Alasan:</span>
                    <span id="reviewModalAlasan" class="text-gray-800">-</span>
                </div>
            </div>
            
            <form id="formReviewPengajuan" method="POST" class="space-y-3 pt-2">
                @csrf
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Catatan Verifikator (Opsional)</label>
                    <input type="text" name="catatan_admin" id="reviewCatatanAdmin" placeholder="Catatan persetujuan / alasan penolakan..."
                        class="w-full h-9 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                </div>

                <div class="flex justify-end space-x-2 pt-2 border-t border-gray-100">
                    <button type="submit" name="status" value="Ditolak"
                        class="px-3.5 py-2 bg-red-50 text-red-700 rounded-xl font-bold hover:bg-red-100 cursor-pointer">Tolak</button>
                    <button type="submit" name="status" value="Disetujui"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-xs cursor-pointer">Setujui Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 6: Tambah Akun Administrator Baru -->
<div id="modalTambahAdmin" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-[#0D2240] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    AD
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Tambah Akun Administrator</h3>
                    <p class="text-[11px] text-gray-500">Mendaftarkan petugas personalia / kepegawaian baru</p>
                </div>
            </div>
            <button onclick="closeModal('modalTambahAdmin')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form action="{{ route('admin.pengaturan.admin.store') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                <input type="text" name="username" placeholder="Contoh: admin_kepegawaian" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none font-mono">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap Administrator <span class="text-red-500">*</span></label>
                <input type="text" name="nama" placeholder="Nama lengkap petugas..." required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Email Kedinasan <span class="text-red-500">*</span></label>
                <input type="email" name="email" placeholder="admin@disperindag.gorontalokota.go.id" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" id="tambahAdminPassword" name="password" placeholder="Minimal 6 karakter" required
                        class="w-full h-10 pl-3 pr-10 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                    <button type="button" onclick="togglePasswordVisibility('tambahAdminPassword', this)" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTambahAdmin')"
                    class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl font-bold shadow-xs cursor-pointer">Daftarkan Admin</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 7: Review Laporan Kegiatan -->
<div id="modalReviewKegiatanModalId"
    class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">
                    LK
                </div>
                <h3 class="text-base font-bold text-gray-900">Penilaian Laporan Kegiatan</h3>
            </div>
            <button type="button" onclick="closeModal('modalReviewKegiatanModalId')" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="space-y-3 text-xs">
            <div class="p-3 rounded-xl bg-slate-50 border border-gray-100 space-y-1.5">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Pegawai:</span>
                    <strong id="modalReviewNama" class="text-gray-900">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pelaksanaan:</span>
                    <strong id="modalReviewTanggal" class="text-gray-900 font-mono">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Kegiatan:</span>
                    <strong id="modalReviewKegiatan" class="text-gray-900">-</strong>
                </div>
                <div>
                    <span class="text-gray-500 block mb-1">Uraian / Output Tugas:</span>
                    <div class="text-gray-800 bg-white p-2.5 rounded-lg border border-gray-200 max-h-32 overflow-y-auto whitespace-pre-wrap" id="modalReviewUraian">-</div>
                </div>
                <div id="modalReviewFotoContainer" class="hidden">
                    <span class="text-gray-500 block mb-1">Foto Dokumentasi:</span>
                    <img id="modalReviewFoto" src="" alt="Foto Laporan" class="w-full h-auto max-h-48 object-contain rounded-xl border border-gray-200 bg-slate-50">
                </div>
            </div>

            <form id="formReviewKegiatan" method="POST" class="space-y-3 pt-2">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nilai Kualitas (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" min="0" max="100" name="nilai_kualitas" id="inputKualitas" required oninput="updateKategoriGrade(this.value)" class="w-full h-10 px-3 text-sm bg-slate-50 border border-gray-300 rounded-xl focus:bg-white outline-none" placeholder="Contoh: 90">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Mutu Otomatis</label>
                        <div id="displayKategori" class="w-full h-10 px-3 flex items-center text-sm font-bold bg-gray-100 border border-gray-300 rounded-xl text-gray-500">
                            -
                        </div>
                    </div>
                </div>
                <script>
                    function updateKategoriGrade(val) {
                        const el = document.getElementById('displayKategori');
                        if (!val || val === '') {
                            el.textContent = '-';
                            el.className = 'w-full h-10 px-3 flex items-center text-sm font-bold bg-gray-100 border border-gray-300 rounded-xl text-gray-500';
                            return;
                        }
                        const v = parseFloat(val);
                        if (v >= 90) {
                            el.textContent = 'A (Sangat Baik)';
                            el.className = 'w-full h-10 px-3 flex items-center text-sm font-bold bg-emerald-50 border border-emerald-300 rounded-xl text-emerald-700';
                        } else if (v >= 80) {
                            el.textContent = 'B (Baik)';
                            el.className = 'w-full h-10 px-3 flex items-center text-sm font-bold bg-blue-50 border border-blue-300 rounded-xl text-blue-700';
                        } else if (v >= 70) {
                            el.textContent = 'C (Cukup)';
                            el.className = 'w-full h-10 px-3 flex items-center text-sm font-bold bg-amber-50 border border-amber-300 rounded-xl text-amber-700';
                        } else {
                            el.textContent = 'D (Kurang)';
                            el.className = 'w-full h-10 px-3 flex items-center text-sm font-bold bg-red-50 border border-red-300 rounded-xl text-red-700';
                        }
                    }
                </script>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan Kualitas</label>
                    <textarea rows="2" name="catatan_kualitas" id="inputCatatanKualitas" class="w-full p-2 text-sm bg-slate-50 border border-gray-300 rounded-xl focus:bg-white outline-none" placeholder="Catatan evaluasi mutu hasil kerja..."></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-2 border-t border-gray-100">
                    <button type="submit" name="status_verifikasi" value="Ditolak" class="px-4 py-2 bg-red-50 text-red-700 rounded-xl font-bold hover:bg-red-100 cursor-pointer">Tolak</button>
                    <button type="submit" name="status_verifikasi" value="Disetujui" class="px-5 py-2 bg-[#0D2240] text-white font-bold rounded-xl hover:bg-[#163660] transition shadow-xs cursor-pointer">Setujui & Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>


<form id="formDeleteAdmin" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- Modal 6.5: Edit Akun Administrator -->
<div id="modalEditAdmin" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative animate-in fade-in zoom-in duration-150 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-[#0D2240] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    AD
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Edit Akun Administrator</h3>
                    <p class="text-[11px] text-gray-500">Ubah data petugas personalia</p>
                </div>
            </div>
            <button onclick="closeModal('modalEditAdmin')"
                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="formEditAdmin" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                <input type="text" id="edit_admin_username" name="username" placeholder="Contoh: admin_kepegawaian" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none font-mono">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Nama Lengkap Administrator <span class="text-red-500">*</span></label>
                <input type="text" id="edit_admin_nama" name="nama" placeholder="Nama lengkap petugas..." required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-[#0D2240] outline-none">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Email Kedinasan <span class="text-red-500">*</span></label>
                <input type="email" id="edit_admin_email" name="email" placeholder="admin@disperindag.gorontalokota.go.id" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Status Akun <span class="text-red-500">*</span></label>
                <select id="edit_admin_status" name="status" required
                    class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Kata Sandi Baru (Opsional)</label>
                <div class="relative">
                    <input type="password" id="editAdminPassword" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full h-10 pl-3 pr-10 border border-gray-200 rounded-xl bg-slate-50 focus:bg-white outline-none">
                    <button type="button" onclick="togglePasswordVisibility('editAdminPassword', this)" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-between space-x-2 pt-3 border-t border-gray-100">
                <div>
                    <button type="button" id="btnDeleteAdmin" onclick="if(confirm('Peringatan: Yakin ingin menghapus administrator ini?')) { document.getElementById('formDeleteAdmin').submit(); }"
                        class="px-4 py-2 bg-red-50 text-red-700 rounded-xl font-bold hover:bg-red-100 cursor-pointer hidden">Hapus Akun</button>
                </div>
                <div class="flex space-x-2">
                    <button type="button" onclick="closeModal('modalEditAdmin')"
                        class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl font-semibold hover:bg-slate-200 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl font-bold shadow-xs cursor-pointer">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.97 9.97 0 015.71-2.29c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>';
            btn.classList.add('text-blue-600');
        } else {
            input.type = 'password';
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
            btn.classList.remove('text-blue-600');
        }
    }

    function openEditAdminModal(id, username, nama, email, status, canDelete) {
        document.getElementById('formEditAdmin').action = '/admin/pengaturan-sistem/admin/' + id;
        document.getElementById('formDeleteAdmin').action = '/admin/pengaturan-sistem/admin/' + id;
        document.getElementById('edit_admin_username').value = username;
        document.getElementById('edit_admin_nama').value = nama;
        document.getElementById('edit_admin_email').value = email;
        document.getElementById('edit_admin_status').value = status.toLowerCase();
        
        const deleteBtn = document.getElementById('btnDeleteAdmin');
        if (canDelete) {
            deleteBtn.classList.remove('hidden');
        } else {
            deleteBtn.classList.add('hidden');
        }
        
        openModal('modalEditAdmin');
    }
</script>

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
                <p><span class="font-bold text-gray-500 w-16 inline-block">Pegawai:</span> <span id="fotoModalNama"></span></p>
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
                <p><span class="font-bold text-gray-500 w-16 inline-block">Pegawai:</span> <span id="fotoLaporanModalNama"></span></p>
                <p><span class="font-bold text-gray-500 w-16 inline-block">Kegiatan:</span> <span id="fotoLaporanModalKegiatan"></span></p>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button onclick="closeModal('modalFotoLaporan')" class="px-5 py-2 bg-slate-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-slate-200 w-full cursor-pointer">Tutup</button>
        </div>
    </div>
</div>
