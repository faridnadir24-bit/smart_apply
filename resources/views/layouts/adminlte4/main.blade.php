<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SmartApply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#171010" media="(prefers-color-scheme: dark)" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print" onload="this.media = 'all'" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc7/dist/css/adminlte.min.css">
    @vite(['resources/css/adminlte-custom.css', 'resources/js/adminlte-custom.js'])
    @stack('css')
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

      {{-- ===== NAVBAR ===== --}}
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}" class="nav-link">Home</a>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto">
            {{-- Notifikasi (hanya user) --}}
            @if(!Auth::user()->hasRole('admin'))
              @php $pendingCount = App\Models\Application::where('user_id', Auth::id())->where('status', 'pending')->count(); @endphp
              <li class="nav-item" style="position:relative">
                <a class="nav-link" href="{{ route('applications.index') }}">
                  <i class="bi bi-bell-fill fs-5"></i>
                  @if($pendingCount > 0)
                    <span class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                      style="position:absolute; top:4px; right:2px; width:18px; height:18px; font-size:10px; font-weight:bold;">
                      {{ $pendingCount }}
                    </span>
                  @endif
                </a>
              </li>
            @endif

            {{-- Fullscreen --}}
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>

            {{-- User Dropdown --}}
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-5 me-1"></i>
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <i class="bi bi-person-circle" style="font-size: 64px;"></i>
                  <p>
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->email }}</small>
                  </p>
                </li>
                <li class="user-footer">
                  @if(Auth::user()->hasRole('user'))
                  <a href="{{ route('applicant.biodata') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-person-lines-fill"></i> Biodata
                  </a>
                  @endif
                  <form method="POST" action="{{ route('logout') }}" class="d-inline float-end">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                      <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      {{-- ===== SIDEBAR ===== --}}
      <aside class="app-sidebar shadow" data-bs-theme="dark"
        style="background: linear-gradient(180deg, #0f2d52 0%, #1a4a7a 50%, #1e3a5f 100%) !important;">

        {{-- Brand / Logo --}}
        <div class="sidebar-brand" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
          <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}"
            class="brand-link"
            style="padding: 1rem 1.2rem; display:flex; align-items:center; gap:0.6rem; text-decoration:none;">
            <div style="
              width: 38px; height: 38px;
              background: linear-gradient(135deg, #3182ce, #63b3ed);
              border-radius: 11px;
              display: flex; align-items: center; justify-content: center;
              box-shadow: 0 4px 15px rgba(66,153,225,0.5);
              flex-shrink: 0;
            ">
              <i class="bi bi-send-fill text-white" style="font-size: 1.05rem;"></i>
            </div>
            <div style="line-height: 1.1;">
              <div style="font-weight: 800; font-size: 1.1rem; letter-spacing: -0.5px; color: white;">
                SmartApply
              </div>
              <div style="font-size: 0.65rem; color: rgba(255,255,255,0.5); font-weight: 500; letter-spacing: 0.5px;">
                AI Job Assistant
              </div>
            </div>
          </a>
        </div>

        {{-- Sidebar Menu --}}
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation">

              {{-- Menu Admin --}}
              @if(Auth::user()->hasRole('admin'))
                <li class="nav-item">
                  <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard Admin</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.pelamar.index') }}" class="nav-link {{ Request::routeIs('admin.pelamar.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-people-fill"></i>
                    <p>Data Pelamar</p>
                  </a>
                </li>

              {{-- Menu User --}}
              @else
                <li class="nav-item">
                  <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('applicant.biodata') }}" class="nav-link {{ Request::routeIs('applicant.biodata') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-person-lines-fill"></i>
                    <p>Biodata</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('jobs.index') }}" class="nav-link {{ Request::routeIs('jobs.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-briefcase-fill"></i>
                    <p>Lowongan Kerja</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('applications.index') }}" class="nav-link {{ Request::routeIs('applications.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                    <p>Lamaran Saya
                      @php $jumlahLamaran = App\Models\Application::where('user_id', Auth::id())->count(); @endphp
                      @if($jumlahLamaran > 0)
                        <span class="badge rounded-pill bg-warning text-dark float-end">{{ $jumlahLamaran }}</span>
                      @endif
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cover-letters.index') }}" class="nav-link {{ Request::routeIs('cover-letters.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-magic"></i>
                    <p>Surat Lamaran AI</p>
                  </a>
                </li>
              @endif
            </ul>
          </nav>
        </div>
      </aside>

      {{-- ===== MAIN CONTENT ===== --}}
      <main class="app-main">

        {{-- Page Header --}}
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">@yield('header')</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item">
                    <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">@yield('header')</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        {{-- Content --}}
        <div class="app-content">
          <div class="container-fluid">
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @yield('content')
          </div>
        </div>
      </main>

      {{-- ===== FOOTER ===== --}}
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">SmartApply v1.0</div>
        <strong>
          Copyright &copy; {{ date('Y') }}&nbsp;
          <a href="#" class="text-decoration-none">SmartApply</a>.
        </strong>
        All rights reserved.
      </footer>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined && !isMobile) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>

    @stack('js')
  </body>
</html>