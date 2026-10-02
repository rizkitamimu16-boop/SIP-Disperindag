<x-mail::message>
# Halo {{ $user->nama }},

Kami mendeteksi adanya aktivitas pembaruan pada akun **Aplikasi Disperindag** Anda.

**Detail Pembaruan:**
{{ $changesDescription }}

Jika perubahan ini memang dilakukan oleh Anda atau Anda mengetahuinya melalui administrator, silakan abaikan email ini.
Namun jika Anda merasa tidak pernah melakukan perubahan atau meminta perubahan ini, segera hubungi Administrator sistem!

<x-mail::button :url="url('/login')">
Buka Aplikasi
</x-mail::button>

Terima kasih,<br>
Admin Disperindag
</x-mail::message>
