<script>
    document.getElementById('mobileMenuBtn').onclick = () =>
        document.getElementById('mobileMenu').classList.toggle('hidden');
</script>

<script>
    const accordions = document.querySelectorAll('.mobile-accordion');

    accordions.forEach((btn) => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('.icon');

            accordions.forEach((otherBtn) => {
                const otherContent = otherBtn.nextElementSibling;
                const otherIcon = otherBtn.querySelector('.icon');

                if (otherBtn !== btn) {
                    otherContent.classList.add('hidden');
                    otherIcon.textContent = '+';
                }
            });

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = '–';
            } else {
                content.classList.add('hidden');
                icon.textContent = '+';
            }
        });
    });
</script>

<script>
    document.addEventListener('scroll', () => {
        const header = document.getElementById('mainHeader');

        if (window.scrollY > 10) {
            header.classList.add('header-scrolled');
            header.classList.remove('bg-transparent');
        } else {
            header.classList.remove('header-scrolled');
            header.classList.add('bg-transparent');
        }
    });
</script>
