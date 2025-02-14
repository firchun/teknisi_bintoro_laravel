<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- logo aplikasi --}}
        <a href="{{ route('home') }}" class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                style="text-transform: uppercase !important;">{{ Auth::user()->role }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ env('APP_NAME') ?? 'Dashboard' }}</span>
        </li>
        <li class="menu-item {{ request()->is('home*') ? 'active' : '' }}">
            <a href="{{ url('/home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Jadwal</span>
        </li>
        <li class="menu-item {{ request()->is('calendar*') ? 'active' : '' }}">
            <a href="{{ url('/calendar') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Analytics">Kalender</div>
            </a>
        </li>
        @if (Auth::user()->role == 'K_teknisi')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengajuan</span>
            </li>
            <li class="menu-item {{ request()->is('service*') ? 'active' : '' }}">
                <a href="{{ url('/service') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                    <div data-i18n="Analytics">Pengajuan</div>
                </a>
            </li>
        @endif
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>
        <li class="menu-item {{ request()->is('report/finished*') ? 'active' : '' }}">
            <a href="{{ url('/report/finished') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div data-i18n="Analytics">Service Selesai</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('report/sparepart*') ? 'active' : '' }}">
            <a href="{{ url('/report/sparepart') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div data-i18n="Analytics">Sparepart</div>
            </a>
        </li>
        {{-- @if (Auth::user()->role == 'K_teknisi')
            <li class="menu-item {{ request()->is('service*') ? 'active' : '' }}">
                <a href="{{ url('/service') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                    <div data-i18n="Analytics">Pengajuan</div>
                </a>
            </li>
        @endif --}}
        @if (Auth::user()->role == 'Admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Service</span>
            </li>
            <li class="menu-item {{ request()->is('service*') ? 'active' : '' }}">
                <a href="{{ url('/service') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                    <div data-i18n="Analytics">Pengajuan</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengguna</span>
            </li>
            <li class="menu-item {{ request()->is('users/admin') ? 'active' : '' }}">
                <a href="{{ url('/users/admin') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Admin</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users/kepala-teknisi') ? 'active' : '' }}">
                <a href="{{ url('/users/kepala-teknisi') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Kepal Teknisi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users/teknisi') ? 'active' : '' }}">
                <a href="{{ url('/users/teknisi') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Teknisi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users/customer') ? 'active' : '' }}">
                <a href="{{ url('/users/customer') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Customer</div>
                </a>
            </li>
        @endif
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun</span>
        </li>
        <li class="menu-item {{ request()->is('profile') ? 'active' : '' }}">
            <a href="{{ url('/profile') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Profile</div>
            </a>
        </li>

    </ul>
</aside>
