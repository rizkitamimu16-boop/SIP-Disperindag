# [BACKEND] DIREKTORI ROUTING SISTEM

Folder ini adalah **BACK-END ROUTING AREA**:
Berisi definisi seluruh rute URL dan hak akses sistem:
- `web.php` : Rute URL panel Admin (`/admin/...`), panel Pegawai (`/pegawai/...`), dan autentikasi (`/login`, `/logout`). Dilindungi oleh middleware `auth` dan `role:admin` / `role:pegawai`.
