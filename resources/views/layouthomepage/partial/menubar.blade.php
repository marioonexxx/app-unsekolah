<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="{{ route('homepage') }}" class="active">Home</a></li>
        <li><a href="{{ route('homepage') }}#features" class="nav-scroll">Panduan</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>

<script>
document.querySelectorAll('.nav-scroll').forEach(link => {
    link.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        const offset = target.getBoundingClientRect().top + window.scrollY - (window.innerHeight / 2 - target.offsetHeight / 2);
        window.scrollTo({ top: offset, behavior: 'smooth' });
    });
});
</script>