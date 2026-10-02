document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('togglePassword')?.addEventListener('click', () => {
        const p = document.getElementById('password');
        p.type = p.type === 'password' ? 'text' : 'password';
        document.getElementById('eyeIcon')?.classList.toggle('hidden');
        document.getElementById('eyeOffIcon')?.classList.toggle('hidden');
    });

    ['Pegawai', 'Admin'].forEach(r => document.getElementById(`role${r}`)?.addEventListener('click', () => {
        document.getElementById('selectedRole').value = r.toLowerCase();
        document.getElementById('rolePegawai').className = `flex-1 py-2 text-sm font-${r==='Pegawai'?'semibold':'medium'} rounded-full ${r==='Pegawai'?'bg-white text-gray-900 shadow-sm':'text-gray-600 hover:text-gray-900'} transition cursor-pointer`;
        document.getElementById('roleAdmin').className = `flex-1 py-2 text-sm font-${r==='Admin'?'semibold':'medium'} rounded-full ${r==='Admin'?'bg-white text-gray-900 shadow-sm':'text-gray-600 hover:text-gray-900'} transition cursor-pointer`;
    }));

    document.getElementById('loginForm')?.addEventListener('submit', (e) => {
        e.preventDefault();
        window.location.href = `${document.getElementById('selectedRole').value}-nav.html`;
    });
});
