<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Logistics Master - {{ ucfirst(tenant('id')) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root { --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; }
        body { font-feature-settings: "cv03", "cv04", "cv11"; }
    </style>
</head>
<body>
    <div class="page">
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark pe-md-3">
                    <a href="{{ route('dashboard') }}">Logistics Master</a>
                </h1>
                
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm bg-blue-lt">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="mt-1 small text-muted">{{ ucfirst(tenant('id')) }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profil</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                        <ul class="navbar-nav">
                            <li class="nav-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('vehicles.index') }}">
                                    <span class="nav-link-title">Ma Flotte</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('drivers.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('drivers.index') }}">
                                    <span class="nav-link-title">Chauffeurs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
      
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <div class="container-xl mt-3">
                        {{-- Message de succès (Session) --}}
                        @if(session('success'))
                            <x-alert type="success" :message="session('success')" />
                        @endif

                        {{-- Erreurs de validation --}}
                        @if($errors->any())
                            <x-alert type="danger">
                                <h4 class="alert-title">Erreurs de validation :</h4>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </x-alert>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl text-center">
                    <p class="text-muted small">&copy; {{ date('Y') }} Logistics Master - {{ ucfirst(tenant('id')) }}</p>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
</body>
</html>