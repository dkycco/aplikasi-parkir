<div class="sidebar-wrapper" id="sidebar">
    <a href="{{ url('/dashboard') }}" class="sidebar-brand">
        <i class="bi bi-asterisk"></i>
        <span>Aplikasi Parkir</span>
    </a>

    <div class="flex-grow-1 overflow-y-auto">
        <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Menu</div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-item">
            <a href="{{ url('/dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('halaman_dashboard') ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-command"></i>
                <span>Dashboard</span>
            </a>
            </li>
            
            <li class="sidebar-menu-item">
            <a href="{{ url('/user') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_user', 'tambah_user', 'edit_user']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-people-fill"></i>
                <span>User</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/area') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_area', 'tambah_area', 'edit_area']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Area Parkir</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/tarif') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_tarif', 'edit_tarif']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-coin"></i>
                <span>Tarif Parkir</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/kendaraan') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_kendaraan', 'tambah_kendaraan', 'edit_kendaraan']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-car-front-fill"></i>
                <span>Kendaraan</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/log') }}" class="sidebar-menu-link {{ request()->routeIs('halaman_log') ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-activity"></i>
                <span>Log Aktifitas</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/transaksi') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_transaksi']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-wallet"></i>
                <span>Transaksi</span>
            </a>
            </li>

            <li class="sidebar-menu-item">
            <a href="{{ url('/rekap') }}" class="sidebar-menu-link {{ request()->routeIs(['halaman_rekap']) ? 'active' : '' }}" id="menu-overview" title="Overview">
                <i class="bi bi-calendar-range-fill"></i>
                <span>Rekap Transaksi</span>
            </a>
            </li>
        </ul>
        </div>
    </div>
</div>