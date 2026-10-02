<x-mail::message>
# Halo {{ $user->nama }},

Akun Anda untuk **Aplikasi Disperindag** telah berhasil dibuat oleh Administrator.

Berikut adalah informasi login sementara Anda:
- **Username:** {{ $user->username }}
- **Email:** {{ $user->email }}
- **Password:** {{ $password }}

Silakan login menggunakan Username atau Email Anda, dan **kami sangat menyarankan Anda untuk segera mengubah password** di menu Profil Anda.

<x-mail::button :url="url('/login')">
Login Sekarang
</x-mail::button>

Terima kasih,<br>
Admin Disperindag
</x-mail::message>
