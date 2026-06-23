<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            
            --bg-dark: #0f172a;
            --bg-light: #f8fafc;
            --sidebar-dark: #1e293b;
            --sidebar-hover: #334155;
            
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-light: #94a3b8;
            --text-white: #f1f5f9;
            
            --border: #e2e8f0;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--bg-light);
        }

        /* Layout */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--bg-dark);
            color: var(--text-white);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo i {
            color: var(--primary-light);
        }

        .sidebar-subtitle {
            font-size: 11px;
            color: var(--text-light);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 12px;
            margin-bottom: 4px;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .nav-link.active {
            background: var(--primary);
            color: #fff;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 16px 32px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .header-meta {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-date {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-date i {
            color: var(--primary);
        }

        /* Page Content */
        .page-content {
            flex: 1;
            padding: 32px;
            background: var(--bg-light);
        }

        /* Footer */
        .footer {
            background: #fff;
            padding: 16px 32px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* Cards */
        .card {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            font-weight: 600;
        }

        .card-body {
            padding: 24px;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--bg-light);
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            padding: 14px 16px;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background: var(--bg-light);
        }

        /* Buttons */
        .btn {
            font-weight: 500;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--secondary);
            color: #fff;
        }

        .btn-warning {
            background: var(--warning);
            color: #fff;
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-outline-secondary {
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-secondary);
        }

        .btn-outline-secondary:hover {
            background: var(--bg-light);
            color: var(--text-primary);
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-radius: var(--radius) 0 0 var(--radius);
        }

        .btn-group .btn:last-child {
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #cffafe;
            color: #0e7490;
        }

        .badge-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        /* Forms */
        .form-label {
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .form-select {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 14px;
            font-size: 14px;
        }

        .input-group-text {
            background: var(--bg-light);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 14px 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Pagination */
        .pagination {
            margin: 0;
            gap: 4px;
        }

        .page-link {
            border-radius: var(--radius);
            padding: 8px 14px;
            font-size: 13px;
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .page-link:hover {
            background: var(--bg-light);
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Utilities */
        .text-muted {
            color: var(--text-secondary) !important;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .border-0 {
            border: none !important;
        }

        .shadow-sm {
            box-shadow: var(--shadow) !important;
        }

        /* Product specific */
        .product-icon {
            width: 48px;
            height: 48px;
            background: var(--bg-light);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
        }

        /* Empty state */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <i class="fas fa-cube"></i>
                    <span>{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="sidebar-subtitle">Admin Dashboard</p>
            </div>

            <nav class="sidebar-nav">
                <p class="nav-label">Main Menu</p>
                
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') || request()->routeIs('admin.products.show') ? 'active' : '' }}">
                        <i class="fas fa-boxes-stacked"></i>
                        <span>Products</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('admin.products.trashed') }}" class="nav-link {{ request()->routeIs('admin.products.trashed') ? 'active' : '' }}">
                        <i class="fas fa-trash"></i>
                        <span>Trash</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Transactions</span>
                    </a>
                </div>

                <div style="flex: 1;"></div>

                <p class="nav-label">Account</p>

                <div class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <div style="padding: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px;">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p style="font-weight: 500; font-size: 13px; margin: 0;">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p style="font-size: 11px; color: var(--text-light); margin: 0;">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="header">
                <div>
                    <h1 class="header-title">@yield('title')</h1>
                    <p class="header-meta">@yield('meta', 'Manage your data')</p>
                </div>
                <div class="header-actions">
                    <div class="header-date">
                        <i class="fas fa-calendar"></i>
                        {{ now()->format('l, d M Y') }}
                    </div>
                </div>
            </header>

            <main class="page-content">
                @yield('content')
            </main>

            <footer class="footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Built with Laravel.</p>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
