<div class="px-3">
    <div class="text-center mb-4">
        <h4 class="text-white fw-bold">
            <i class="fas fa-server me-2"></i>
            {{ config('app.name', 'Datacenter TI') }}
        </h4>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-white" href="{{ route('admin.dashboard') }}" data-bs-toggle="tooltip" title="Lihat ringkasan admin">
                <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('vms.*') ? 'active' : '' }} text-white" href="{{ route('vms.index') }}" data-bs-toggle="tooltip" title="Lihat semua VM">
                <i class="fas fa-desktop me-2"></i> Virtual Machines
            </a>
        </li>
        
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }} text-white" href="{{ route('rentals.index') }}" data-bs-toggle="tooltip" title="Kelola semua rental">
                <i class="fas fa-calendar-check me-2"></i> Rentals
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-white" href="#" data-bs-toggle="tooltip" title="Laporan"><i class="fas fa-chart-bar me-2"></i> Reports</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="#" data-bs-toggle="tooltip" title="Pengaturan"><i class="fas fa-cog me-2"></i> Settings</a>
        </li>
    </ul>

    <!--<div class="mt-1 pt-4 border-top text-white">
        <div class="small mb-2">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
        </form>
    </div>-->
    
    <div class="mt-30 pt-4 border-top text-white">
        <div class="small mb-2">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
        </form>
    </div>
</div>
