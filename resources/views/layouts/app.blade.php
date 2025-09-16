<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Datacenter TI')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #0f30c4ff 0%, #472446ff 100%);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(11, 66, 117, 0.63);
            border-radius: 5px;
        }
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
        }
        .stats-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .vm-card {
            transition: transform 0.2s;
        }
        .vm-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            </nav>
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                            <li class="nav-item"></li>
                        <h4 class="text-white">
                            <i class="fas fa-server me-2"></i>
                            Datacenter TI
                        </h4>
                    </div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="{{ route('servers.index') }}">
                                <i class="fas fa-server"></i> Servers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vms.index') }}">
                                <i class="fas fa-desktop"></i> Virtual Machines
                            </a>
                        </li>
                        -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vms.*') ? 'active' : '' }}" 
                               href="{{ route('vms.index') }}">
                                <i class="fas fa-server me-2"></i>
                                Virtual Machines
                            </a>
                        </li>
                    
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}" 
                               href="{{ route('rentals.index') }}">
                                <i class="fas fa-calendar-check me-2"></i>
                                Rentals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                    <!-- Tombol Login / Logout -->
                        @guest
                            <li class="nav-item mt-3">
                                <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item mt-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-danger text-white w-100 text-start">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endauth

                    <div class="mt-auto pt-5">
                        <div class="text-center">
                            <small class="text-white-50">
                                <i class="fas fa-user me-1"></i>
                                Admin Test
                            </small>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    @yield('page-actions')
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

</html>
