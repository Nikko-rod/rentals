<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | Rentals Tacloban')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #14532d;
            --primary-light: #166534;
            --primary-dark:rgb(16, 67, 37);
            --secondary: #f8fafc;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --text-dark: #1e293b;
            --text-light: #64748b;
             --error: #dc2626;
            --success: #16a34a;
            --warning: #ca8a04;
            --white: #ffffff;
            --border: #e2e8f0;
            --border-color:rgb(208, 221, 238);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--secondary);
            color: var(--text-dark);
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--white);
            border-right: 1px solid var(--border);
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            height: 40px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-menu {
            padding: 1.5rem 1rem;
            flex: 1;
        }

        .nav-group {
            margin-bottom: 2rem;
        }

        .nav-group-title {
            color: var(--text-light);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 0.75rem;
            margin-bottom: 0.75rem;
        }

        .nav-item {
            list-style: none;
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--secondary);
            color: var(--primary);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary);
            color: var(--white);
        }

        .nav-link i {
            width: 1.25rem;
            text-align: center;
        }

        .logout-section {
            padding: 1rem;
            border-top: 1px solid var(--border);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.5rem;
            background: var(--white);
            color: var(--danger);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: var(--danger-light);
            transform: translateX(5px);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 2rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Content Cards */
        .content-card {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Utility Classes */
        .text-primary { color: var(--primary); }
        .text-light { color: var(--text-light); }
        .font-bold { font-weight: 600; }
         /* Toast Styles */
     /* Toast Styles */
     .toast {
    position: fixed;
    top: 2rem;
    right: -100%;
    background: var(--white);
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    transition: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35);
    z-index: 1001;
}

.toast.success {
    border-left: 4px solid var(--success);
}

.toast.success .toast-content {
    color: var(--success);
}

.toast.success .toast-content i {
    color: var(--success);
}

.toast.error {
    border-left: 4px solid var(--error);
}

.toast.error .toast-content {
    color: var(--error);
}

.toast.error .toast-content i {
    color: var(--error);
}

.toast.show {
    right: 2rem;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toast-content i {
    font-size: 1.25rem;
}
    </style>
    @yield('styles')
</head>
<body>
@include('partials.toast')
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('logo.png') }}" alt="Rentals Tacloban" class="logo">
            </div>
            
            <nav class="nav-menu">
                @yield('sidebar')
            </nav>

            <div class="logout-section">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>
    
    @yield('scripts')
    <script>
    
        if (document.querySelector('.toast.show')) {
            setTimeout(() => {
                const toast = document.querySelector('.toast.show');
                toast.style.right = '-100%';
            }, 5000);
        }
    </script>
</body>
</html>