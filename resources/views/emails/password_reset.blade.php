<x-mail::message>
# Halo {{ $user->nama }},

Administrator baru saja mereset kata sandi Anda untuk **Aplikasi Disperindag**.

Berikut adalah informasi login Anda yang baru:
- **Username:** {{ $user->username }}
- **Email:** {{ $user->email }}
- **Password Baru:** {{ $password }}

**PENTING:** Demi keamanan, kami sangat menyarankan Anda untuk segera login dan mengganti password *default* ini dengan password rahasia Anda sendiri.

<x-mail::button :url="url('/login')">
Login Sekarang
</x-mail::button>

Terima kasih,<br>
Admin Disperindag
</x-mail::message>
