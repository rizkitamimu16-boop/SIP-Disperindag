<!-- ===================================================================
     MODAL PREVIEW DOKUMEN RESMI (SK CUTI / SPT DINAS LUAR / SURAT DOKTER)
     =================================================================== -->
<div id="modalPreviewLampiranDokumen" class="fixed inset-0 bg-slate-900/75 backdrop-blur-xs z-50 hidden flex items-center justify-center p-3 sm:p-4 transition-opacity">
    <div class="bg-white rounded-2xl sm:rounded-3xl max-w-2xl w-full shadow-2xl relative animate-in fade-in zoom-in duration-150 flex flex-col max-h-[92vh] overflow-hidden border border-slate-200">
        
        <!-- Header Bar Modal -->
        <div class="px-5 py-3.5 bg-slate-900 text-white flex items-center justify-between shrink-0 border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-red-500/20 border border-red-400/40 text-red-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h3 id="lampiranModalTitle" class="text-sm sm:text-base font-bold text-white">Preview Dokumen Lampiran Resmi</h3>
                        <span id="lampiranModalBadge" class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">SK Cuti Sah</span>
                    </div>
                    <p id="lampiranModalSubtitle" class="text-[11px] text-slate-400 mt-0.5 font-mono">Berkas Elektronik Terverifikasi • DISPERDAGIN Kota Gorontalo</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <button type="button" onclick="unduhLampiranDokumen()" title="Unduh Berkas PDF" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition cursor-pointer">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span class="hidden sm:inline">Unduh PDF</span>
                </button>
                <button type="button" onclick="cetakLampiranDokumen()" title="Cetak Dokumen" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition cursor-pointer">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Cetak</span>
                </button>
                <button type="button" onclick="closeModal('modalPreviewLampiranDokumen')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Document Canvas View (Kertas Dokumen Resmi) -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-100/90 custom-scrollbar" id="printableLampiranArea">
            <div class="bg-white max-w-xl mx-auto shadow-md border border-slate-300 rounded-xl p-6 sm:p-8 text-gray-900 font-serif leading-relaxed relative">
                
                <!-- Watermark Background -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03] select-none">
                    <span class="text-7xl font-bold font-sans tracking-widest text-slate-900 -rotate-45">DISPERDAGIN</span>
                </div>
                
                <!-- KOP SURAT RESMI -->
                <div class="relative pb-3 mb-4">
                    <div class="flex items-center space-x-3.5 border-b-[2.5px] border-black pb-2">
                        <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Gorontalo" class="w-14 h-16 object-contain shrink-0">
                        <div class="text-center flex-1 pr-4">
                            <h4 class="text-xs sm:text-sm font-extrabold uppercase tracking-wide font-sans text-gray-900 leading-tight">PEMERINTAH KOTA GORONTALO</h4>
                            <h3 class="text-sm sm:text-base font-black uppercase tracking-wider font-sans text-gray-900 leading-tight">DINAS PERDAGANGAN DAN PERINDUSTRIAN</h3>
                            <p class="text-[10px] font-sans text-gray-600 mt-0.5 leading-snug">Jl. Jalaluddin Tantu No. 45, Kota Gorontalo • Pos: 96115 • Telp: (0435) 821xxx</p>
                            <p class="text-[9px] font-sans text-gray-500 leading-none">Laman Resmi: disperindag.gorontalokota.go.id • Pos-el: disperindag@gorontalokota.go.id</p>
                        </div>
                    </div>
                    <div class="border-b border-black mt-0.5"></div>
                </div>
                
                <!-- JUDUL SURAT & NOMOR RESMI -->
                <div class="text-center my-3">
                    <h5 id="lampiranDocJudul" class="font-bold text-xs sm:text-sm uppercase tracking-wider underline text-gray-900">SURAT KEPUTUSAN PEMBERIAN CUTI TAHUNAN</h5>
                    <p id="lampiranDocNomor" class="text-[11px] font-sans text-gray-600 mt-0.5">Nomor: 800/DISPERDAGIN/SK-CUTI/041/IX/2026</p>
                </div>
                
                <!-- DASAR HUKUM -->
                <div class="my-3 text-[11px] font-sans text-gray-700 text-justify leading-relaxed bg-slate-50/70 p-2.5 rounded-lg border border-slate-200/80">
                    <strong class="text-gray-900">Dasar Pertimbangan:</strong>
                    <span id="lampiranDocDasar" class="block mt-0.5 text-gray-600">Surat Permohonan Cuti Tahunan Pegawai tertanggal 05 September 2026 dan Peraturan Walikota Gorontalo tentang Disiplin dan Kehadiran ASN/PPPK.</span>
                </div>
                
                <!-- KEPADA PEGAWAI / ISI PENETAPAN -->
                <div class="my-3 space-y-2">
                    <p id="lampiranDocPernyataan" class="text-[11px] font-bold text-gray-900 font-sans uppercase">MEMBERIKAN IZIN CUTI KEPADA:</p>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-3 text-[11px] font-sans space-y-1.5 shadow-2xs">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Nama Pegawai</span>
                            <span class="col-span-2 font-bold text-gray-900">: <span id="lampiranDocNama">Andi Saputra</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">NIP / Identitas</span>
                            <span class="col-span-2 text-gray-700">: <span id="lampiranDocNip">19880314 201101 1 002</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Pangkat / Golongan</span>
                            <span class="col-span-2 text-gray-700">: <span id="lampiranDocPangkat">Penata Muda / III/a</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Jabatan</span>
                            <span class="col-span-2 text-gray-700">: <span id="lampiranDocJabatan">Analis Perdagangan Ahli Pertama</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Unit Kerja / Bidang</span>
                            <span class="col-span-2 text-gray-700">: <span id="lampiranDocBidang">Perdagangan</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Waktu Pelaksanaan</span>
                            <span class="col-span-2 font-bold text-emerald-800">: <span id="lampiranDocWaktu">10 – 12 September 2026 (3 Hari Kerja)</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2" id="lampiranDocLokasiRow">
                            <span class="text-gray-500 font-medium">Lokasi / Wilayah</span>
                            <span class="col-span-2 text-gray-700">: <span id="lampiranDocLokasi">-</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500 font-medium">Keterangan / Alasan</span>
                            <span class="col-span-2 text-gray-800">: <span id="lampiranDocAlasan">Keperluan keluarga mendesak dan urusan pribadi tahunan.</span></span>
                        </div>
                    </div>
                </div>
                
                <p id="lampiranDocKetentuan" class="text-[10px] font-sans text-gray-600 mt-3 text-justify leading-relaxed">
                    Demikian surat ini diterbitkan untuk dipergunakan sebagaimana mestinya dan setelah berakhirnya masa izin/tugas ini yang bersangkutan wajib kembali melaksanakan tugas sebagaimana biasa.
                </p>
                
                <!-- BAGIAN TANDA TANGAN & STEMPEL DIGITAL & QR CODE -->
                <div class="mt-6 pt-4 border-t border-dashed border-gray-200 grid grid-cols-2 gap-4 font-sans text-[11px] items-end">
                    
                    <!-- Sisi Kiri: BSrE & Barcode Validasi Sah -->
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                        <div class="flex items-center space-x-2">
                            <!-- QR Code Dummy SVG -->
                            <div class="w-12 h-12 bg-white p-1 rounded-md border border-gray-300 shrink-0 flex items-center justify-center">
                                <svg class="w-10 h-10 text-slate-800" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14 2h2v4h-2v-4zm-4-4h2v2h-2v-2zm4 0h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm-4 2h2v2h-2v-2z"/>
                                </svg>
                            </div>
                            <div class="text-[9px] text-gray-500 leading-tight">
                                <span class="font-bold text-emerald-700 block text-[10px]">✓ TERVERIFIKASI BSrE</span>
                                Dokumen resmi DISPERDAGIN telah ditandatangani secara elektronik sah.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sisi Kanan: Penandatangan & Stempel Dinas -->
                    <div class="text-center relative pl-2">
                        <p class="text-[10px] text-gray-600">Ditetapkan di Kota Gorontalo</p>
                        <p id="lampiranDocTanggalPengesahan" class="text-[10px] text-gray-600 font-semibold mb-1">Pada tanggal 08 September 2026</p>
                        <p id="lampiranDocJabatanTtd" class="text-[10px] font-bold text-gray-900 leading-tight">Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo</p>
                        
                        <!-- Box Area Stempel & TTD Digital -->
                        <div class="relative h-16 my-1 flex items-center justify-center">
                            <!-- Stempel Bulat Dinas SVG -->
                            <div class="absolute w-20 h-20 rounded-full border-2 border-dashed border-indigo-700/60 flex items-center justify-center text-center p-1 text-[7px] font-bold text-indigo-800/80 -rotate-12 pointer-events-none select-none bg-indigo-50/20">
                                <div class="rounded-full border border-indigo-600/40 w-full h-full flex flex-col items-center justify-center">
                                    <span>PEMERINTAH KOTA</span>
                                    <span class="text-[6px] tracking-tighter">DISPERDAGIN</span>
                                    <span>GORONTALO</span>
                                </div>
                            </div>
                            
                            <!-- Tanda Tangan Digital Grafis -->
                            <span class="font-serif italic text-base text-blue-900 select-none tracking-widest relative z-10 opacity-85">Dahlan</span>
                        </div>
                        
                        <p id="lampiranDocNamaTtd" class="font-bold text-xs text-gray-900 underline">Drs. H. M. Dahlan, M.Si</p>
                        <p id="lampiranDocNipTtd" class="text-[9px] text-gray-500 font-mono">NIP. 19680512 199403 1 005</p>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Footer Modal -->
        <div class="px-5 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-gray-500 shrink-0">
            <div class="flex items-center space-x-1.5 text-[11px] text-gray-500">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Validitas dokumen elektronik sah sesuai UU ITE Pasal 5 Ayat 1</span>
            </div>
            <button type="button" onclick="closeModal('modalPreviewLampiranDokumen')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-gray-800 font-semibold rounded-xl text-xs transition cursor-pointer">
                Tutup Preview
            </button>
        </div>
        
    </div>
</div>
