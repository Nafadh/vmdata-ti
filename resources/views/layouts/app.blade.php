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
        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

         main.flex-1.p-6 { padding: 24px 36px; }
    /* profile menu card hover */
    .profile-menu-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.08); transform: translateY(-4px); }
    .sidebar .nav-link .badge { font-size: .7rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            </nav>
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    @include('layouts.partials.sidebar')
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
    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                })
        });
    </script>
    @yield('scripts')

</html>
