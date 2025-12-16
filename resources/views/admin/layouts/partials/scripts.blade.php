<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('adminLayout', () => ({
            // GANTI DISINI:
            // Jika layar >= 1024px (Laptop) -> True (Buka)
            // Jika layar < 1024px (HP) -> False (Tutup)
            sidebarOpen: window.innerWidth >= 1024,

            // Default ke 'system' kalau tidak ada di storage
            theme: localStorage.getItem('theme') || 'system',

            initTheme() {
                // Terapkan tema saat website dimuat
                this.applyTheme();

                // LISTENER SAKTI:
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (this.theme === 'system') {
                        if (e.matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                });
            },

            setTheme(val) {
                this.theme = val;

                // Logic Penyimpanan:
                if (val === 'system') {
                    localStorage.removeItem('theme');
                } else {
                    localStorage.setItem('theme', val);
                }

                this.applyTheme();
            },

            // Logic Terpisah buat Penerapan Visual
            applyTheme() {
                // 1. Jika User Paksa Dark
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
                // 2. Jika User Paksa Light 
                else if (this.theme === 'light') {
                    document.documentElement.classList.remove('dark');
                }
                // 3. Jika System (Cek settingan Laptop/HP)
                else {
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            },

            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            }
        }))
    })
</script>
