<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Error' }} - {{ config('app.name', 'Laravel') }}</title>

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
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg-light: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-page {
            text-align: center;
            padding: 40px;
            max-width: 600px;
        }

        .error-icon {
            font-size: 80px;
            color: var(--primary);
            margin-bottom: 24px;
        }

        .error-icon.danger {
            color: var(--danger);
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 16px;
        }

        .error-code.danger {
            color: var(--danger);
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .btn-outline-secondary {
            border: 1px solid #e2e8f0;
            background: transparent;
            color: var(--text-secondary);
        }

        .btn-outline-secondary:hover {
            background: #f1f5f9;
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-icon {{ $icon ?? '' }}">
            <i class="fas {{ $icon_class ?? 'fa-exclamation-triangle' }}"></i>
        </div>
        
        <div class="error-code {{ $code_class ?? '' }}">
            {{ $code ?? '500' }}
        </div>
        
        <h1 class="error-title">{{ $title ?? 'Something went wrong' }}</h1>
        
        <p class="error-message">
            {{ $message ?? 'We encountered an unexpected error. Please try again later.' }}
        </p>
        
        <div class="error-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Back to Dashboard
            </a>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
        </div>
    </div>
</body>
</html>
