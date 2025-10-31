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

            @php $unread = optional(Auth::user())->unreadNotifications()->count() ?? 0; @endphp
            <li class="nav-item mb-1">
                {{-- Collapsible Reports/Notifications: hidden by default, expands on click or when on related routes --}}
                <a class="nav-link text-white d-flex align-items-center {{ (request()->routeIs('admin.reports.*') || request()->routeIs('admin.notifications.*')) ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#sidebarReports"
                   role="button"
                   aria-expanded="{{ (request()->routeIs('admin.reports.*') || request()->routeIs('admin.notifications.*')) ? 'true' : 'false' }}"
                   aria-controls="sidebarReports"
                   title="Laporan">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span>Reports</span>
                </a>

                <div class="collapse {{ (request()->routeIs('admin.reports.*') || request()->routeIs('admin.notifications.*')) ? 'show' : '' }}" id="sidebarReports">
                    <ul class="nav flex-column ms-3 mt-1">
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }} text-white small" href="{{ route('admin.reports.index') }}">Laporan</a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }} text-white small" href="{{ route('admin.notifications.index') }}">Notifikasi
                                @if($unread > 0)
                                    <span class="badge bg-danger ms-2">{{ $unread }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }} text-white" href="{{ route('admin.settings.index') }}" data-bs-toggle="tooltip" title="Pengaturan"><i class="fas fa-cog me-2"></i> Settings</a>
        </li>
    </ul>

    <div class="mt-1 pt-4 border-top text-white">
        <div class="small mb-2">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
        </form>
    </div>
    
</div>
