<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rentals Tacloban')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #14532d;
            --primary-hover: #1a6d3c;
            --secondary: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --error: #dc2626;
            --success: #16a34a;
            --warning: #ca8a04;
            --info: #0891b2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-dark);
            min-height: 100vh;
            line-height: 1.5;
        }

        .header {
            background-color: var(--white);
            padding: 1.25rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .header-nav {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .nav-link:hover {
            color: var(--primary);
            background-color: var(--secondary);
        }

        .main-content {
            padding-top: 5rem;
            min-height: calc(100vh - 5rem);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: var(--success);
        }

        .alert-error {
            background-color: #fee2e2;
            color: var(--error);
        }

        .alert-warning {
            background-color: #fef3c7;
            color: var(--warning);
        }

        .alert-info {
            background-color: #e0f2fe;
            color: var(--info);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--primary);
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .header-nav {
                gap: 1rem;
            }

            .nav-link {
                padding: 0.5rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        .signup-dropdown {
        position: relative;
    }

    .signup-options {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        background: var(--white);
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        padding: 0.75rem;
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .signup-dropdown:hover .signup-options {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .signup-options a {
        display: block;
        padding: 0.75rem 1rem;
        color: var(--text-dark);
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s;
        border-radius: 0.5rem;
        white-space: nowrap;
    }

    .signup-options a:hover {
        background-color: var(--secondary);
        color: var(--primary);
    }

    .signup-options a i {
        margin-right: 0.5rem;
        width: 1.25rem;
    }

    .signup-dropdown .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .signup-dropdown .nav-link i {
        transition: transform 0.2s;
    }

    .signup-dropdown:hover .nav-link i {
        transform: rotate(180deg);
    }
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
    <header class="header">
        <div class="header-content">
            <a href="{{ route('home') }}" class="logo">Rentals Tacloban</a>
            <nav class="header-nav">
                @guest
                    <div class="signup-dropdown">
                        <a href="#" class="nav-link">Register <i class="fas fa-chevron-down"></i></a>
                        <div class="signup-options">
                            <a href="{{ url('/register/tenant') }}"><i class="fas fa-user"></i> As Tenant</a>
                            <a href="{{ url('/register/landlord') }}"><i class="fas fa-home"></i> As Landlord</a>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="nav-link">Login <i class="fas fa-sign-in-alt"></i></a>
                @else
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none;">
                            Logout <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <main class="main-content">
       

        @yield('content')
    </main>

    @yield('scripts')
    <script>
    if (document.querySelector('.toast.show')) {
        setTimeout(() => {
            document.querySelector('.toast.show').style.right = '-100%';
        }, 5000);
    }
</script>
</body>
</html>