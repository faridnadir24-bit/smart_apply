<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SmartApply</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <!--end::Fonts-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc7/dist/css/adminlte.min.css">
    @vite(['resources/css/adminlte-custom.css', 'resources/js/adminlte-custom.js'])
    @stack('css')
  </head>
  <!--end::Head-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

      <!--begin::Header-->
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
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
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
      <!--end::Header-->

      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}" class="brand-link">
            <i class="bi bi-file-earmark-person-fill brand-image opacity-75 shadow fs-4 ms-2"></i>
            <span class="brand-text fw-light">SmartApply</span>
          </a>
        </div>

        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
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
                    <p>Lamaran Saya</p>
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
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">
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

        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">SmartApply v1.0</div>
        <strong>
          Copyright &copy; {{ date('Y') }}&nbsp;
          <a href="#" class="text-decoration-none">SmartApply</a>.
        </strong>
        All rights reserved.
      </footer>
      <!--end::Footer-->
    </div>

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