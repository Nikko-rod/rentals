<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | Rentals Tacloban')</title>
 <!--css didi -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <style>
        @keyframes slide-left {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-left {
            animation: slide-left 0.3s ease-out;
        }
        .toast-success, .toast-error {  
            transition: transform 0.3s ease-in-out;
        }
        .toast-success:hover, .toast-error:hover {
            transform: translateX(-5px);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Loading Indicator -->
    <div id="loading" class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-green-700 border-t-transparent"></div>
    </div>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm border-r border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">@yield('dashboard-title')</h1>
            </div>
            
            <nav class="p-4 space-y-2">
                @yield('sidebar-menu')
            </nav>

            <div class="mt-auto p-4 border-t border-gray-200">
            <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-3 p-3 rounded-lg text-gray-600 w-full
                                   transition-all duration-300 hover:bg-gray-100 hover:shadow-md hover:translate-x-1">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page-title')</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">
                            Welcome, {{ Auth::user()->first_name }}!
                        </span>
                    </div>
                </div>
            </header>

            <!-- Toast Notifications -->
            <div class="fixed top-4 right-4 z-50 space-y-4">
                @if(session('success'))
                <div class="toast-success animate-slide-left">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg
                               transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="toast-error animate-slide-left">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg
                               transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

 <!-- scripts -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <!-- Toast Notifications Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-success, .toast-error');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>