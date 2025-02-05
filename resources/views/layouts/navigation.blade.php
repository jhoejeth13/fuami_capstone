<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <title>Dashboard</title>
    <style>
        .sidebar-icon-only .sidebar-text {
            display: none;
            height: 100vh;
        z-index: 1000; /* Ensure it's above other content */
        transition: transform 0.3s ease-in-out;
        }
        .sidebar-icon-only .sidebar-header-text {
            display: none;
            
        }
        .sidebar-icon-only {
            width: 64px;
        }
        
        
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-blue-900 text-white flex flex-col fixed h-full transition-all duration-300 ease-in-out transform -translate-x-full md:translate-x-0 md:relative">
            <div class="flex items-center justify-between p-4 border-b border-blue-700">
                <span class="text-lg font-semibold sidebar-header-text">FUAMI SHS REPO</span>
                <button id="burgerMenu" class="text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <button id="closeSidebar" class="text-white md:hidden">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-5 flex-1">
                <h1 class="px-6 py-3 text-sm uppercase text-gray-400 sidebar-text">Dashboard</h1>
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 hover:bg-blue-700 flex items-center">
                    <i class="fas fa-home mr-3"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <h1 class="px-6 py-3 text-sm uppercase text-gray-400 sidebar-text">Personal Information</h1>
                <a href="{{ route('graduates.create') }}" class="block py-3 px-6 hover:bg-blue-700 flex items-center">
                    <i class="fas fa-user-plus mr-3"></i>
                    <span class="sidebar-text">Add New Graduate</span>
                </a>
                <a href="{{ route('graduates.index') }}" class="block py-3 px-6 hover:bg-blue-700 flex items-center">
                    <i class="fas fa-users mr-3"></i>
                    <span class="sidebar-text">Manage SHS Graduates</span>
                </a>
                <h1 class="px-6 py-3 text-sm uppercase text-gray-400 sidebar-text">SHS Alumni Track</h1>
                <a href="{{ route('tracer-responses.index') }}" class="block py-3 px-6 hover:bg-blue-700 flex items-center">
                    <i class="fas fa-search mr-3"></i>
                    <span class="sidebar-text">SHS Alumni Tracer</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-white min-h-screen">
            <!-- Top Bar -->
            <header class="bg-white shadow flex justify-between items-center px-6 py-4">
                <div class="flex items-center">
                <img src="{{ asset('images/icon.jpg') }}" alt="Logo" class="h-10 w-10 ml-3">
                <span class="text-lg font-semibold text-gray-900 ml-3">FR. Urios Academy of Magallanes Inc.</span>
                </div>
                
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center text-gray-900 focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-md rounded-md overflow-hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </header>

    <script>
        function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }

        const sidebar = document.getElementById('sidebar');
        const burgerMenu = document.getElementById('burgerMenu');

        burgerMenu.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('sidebar-icon-only');
        });

        document.getElementById('closeSidebar').addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('sidebar-icon-only');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            if (!sidebar.contains(event.target) && !burgerMenu.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('sidebar-icon-only');
            }
        });
    </script>
</body>
</html>