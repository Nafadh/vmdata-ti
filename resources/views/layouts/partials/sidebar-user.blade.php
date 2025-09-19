<div class="px-1">
    <div class="brand text-center mb-4">
        <h4 class="fw-bold text-white"><i class="fas fa-server me-2"></i> {{ config('app.name', 'VMDATA TI') }}</h4>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}" data-bs-toggle="tooltip" title="Kembali ke dashboard">
                <i class="fas fa-home"></i> <span class="ms-2">Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}" data-bs-toggle="tooltip" title="Lihat dan kelola profil Anda">
                <i class="fas fa-user"></i> <span class="ms-2">Profil</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('vms.*') ? 'active' : '' }}" href="{{ route('vms.index') }}" data-bs-toggle="tooltip" title="Kelola Virtual Machines Anda">
                <i class="fas fa-desktop"></i> <span class="ms-2">Virtual Machines</span>
            </a>
        </li>

        @if(Route::has('vmrentals.index'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vmrentals.*') ? 'active' : '' }}" href="{{ route('vmrentals.index') }}" data-bs-toggle="tooltip" title="Lihat riwayat sewa Anda">
                    <i class="fas fa-file-alt"></i> <span class="ms-2">My Rentals</span>
                </a>
            </li>
        @endif
    </ul>

    <div class="mt-1 pt-4 border-top text-white">
        <div class="small mb-2 text-white">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
        </form>
    </div>
</div>
