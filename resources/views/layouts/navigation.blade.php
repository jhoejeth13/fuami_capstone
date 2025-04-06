<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUAMI SHS Dashboard</title>
    <!-- CDN Links -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (Local) -->
    @include('includes.fontawesome')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1d4ed8;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Sidebar transitions */
        .sidebar {
            width: var(--sidebar-width);
            transition: all 0.3s ease;
            left: 0;
            z-index: 30;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-header-text,
        .sidebar.collapsed .sidebar-section,
        .sidebar.collapsed .sidebar-logo {
            display: none;
        }
        
        .sidebar.collapsed .nav-item {
            justify-content: center;
        }
        
        /* Navbar scrolling */
        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                position: fixed;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 25;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }
        
        /* Main content adjustment */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            width: calc(100% - var(--sidebar-width));
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
            width: calc(100% - var(--sidebar-collapsed));
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
        
        /* Active nav item */
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }
        
        /* Dropdown animation */
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease;
        }
        
        .dropdown-exit {
            opacity: 1;
            transform: translateY(0);
        }
        
        .dropdown-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }
        
        /* Print styles */
        @media print {
            #sidebar, header {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .sidebar.collapsed #toggleSidebar {
            margin-left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed h-full bg-gradient-to-b from-blue-900 to-blue-800 text-white shadow-lg">
            <div class="flex items-center justify-between p-5 border-b border-blue-700">
                <div class="flex items-center">
                    <img src="{{ asset('images/icon.jpg') }}" alt="Logo" class="sidebar-logo h-10 w-10 rounded-lg">
                    <span class="sidebar-header-text ml-3 text-lg font-semibold">FUAMI REPO</span>
                </div>
                <button id="toggleSidebar" class="text-blue-200 hover:text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <nav class="mt-2 flex-1 overflow-y-auto">
                <!-- Dashboard Section -->
                <div class="px-4 py-3">
                    <h3 class="sidebar-section uppercase text-xs font-semibold text-blue-300 tracking-wider sidebar-text">Dashboard</h3>
                    <a href="{{ route('dashboard') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-home text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Dashboard</span>
                    </a>
                </div>
                
                <!-- User Management Section -->
                <div class="px-4 py-3">
                    <h3 class="sidebar-section uppercase text-xs font-semibold text-blue-300 tracking-wider sidebar-text">User Management</h3>
                    <a href="{{ route('users.index') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-users text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Manage Users</span>
                    </a>
                </div>
                
                <!-- Graduate Management Section -->
                <div class="px-4 py-3">
                    <h3 class="sidebar-section uppercase text-xs font-semibold text-blue-300 tracking-wider sidebar-text">Graduate Records</h3>
                    <a href="{{ route('records.create-selection') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-plus-circle text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Create Record</span>
                    </a>
                    <a href="{{ route('students.index') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-user-graduate text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Manage JHS</span>
                    </a>
                    <a href="{{ route('graduates.index') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-user-graduate text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Manage SHS</span>
                    </a>
                </div>
                
                <!-- Tracer Section -->
                <div class="px-4 py-3">
                    <h3 class="sidebar-section uppercase text-xs font-semibold text-blue-300 tracking-wider sidebar-text">Alumni Tracking</h3>
                    <a href="{{ route('tracer-responses.index') }}?type=jhs" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-search text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">JHS Alumni Tracker</span>
                    </a>
                    <a href="{{ route('tracer-responses.index') }}?type=shs" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-search text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">SHS Alumni Tracker</span>
                    </a>
                    <!-- <a href="{{ route('tracer.form') }}" class="nav-item mt-2 flex items-center px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors duration-200">
                        <i class="fas fa-edit text-lg w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Alumni Tracer Form</span>
                    </a> -->
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-blue-700 text-center text-blue-300 text-sm sidebar-text">
                FUAMI JHS and SHS  &copy; {{ date('Y') }}
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col min-h-screen">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <!-- Breadcrumbs would go here -->
                    <div class="flex items-center">
                        <button id="mobileToggle" class="mr-4 text-gray-600 hover:text-blue-600 md:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-lg md:text-xl font-semibold text-gray-800 truncate">@yield('title', 'JHS and SHS Graduates Repository and Alumni Tracer System')</h1>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <div class="relative">
                            <button onclick="toggleProfileDropdown()" class="flex items-center space-x-2 focus:outline-none">
                                <div class="h-8 w-8 md:h-10 md:w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline text-gray-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500 text-xs hidden md:inline"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center">
                                    <i class="fas fa-user-cog mr-2 text-blue-500"></i> Profile Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2 text-blue-500"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 bg-gray-50 overflow-x-auto">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t px-4 md:px-6 py-4 text-center text-sm text-gray-500">
                <p>Fr. Urios Academy of Magallanes, Inc.</p>
            </footer>
        </div>
    </div>

    <script>
        // Toggle sidebar collapse
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebarCollapse() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
        
        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        }
        
        // Initialize sidebar state
        function initSidebar() {
            // For desktop: use collapsed state from localStorage
            if (window.innerWidth > 768) {
                if (localStorage.getItem('sidebarCollapsed') === 'true') {
                    sidebar.classList.add('collapsed');
                }
            } else {
                // For mobile: default to hidden
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('mobile-open');
            }
        }
        
        // Event listeners
        toggleSidebar.addEventListener('click', toggleSidebarCollapse);
        mobileToggle.addEventListener('click', toggleMobileSidebar);
        sidebarOverlay.addEventListener('click', toggleMobileSidebar);
        
        // Profile dropdown toggle
        function toggleProfileDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileButton = document.querySelector('[onclick="toggleProfileDropdown()"]');
            
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
        
        // Update active nav item
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Set active nav item based on current URL
        function setActiveNavItem() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-item').forEach(item => {
                const href = item.getAttribute('href');
                const linkPath = href.split('?')[0]; // Remove query string for comparison
                if (currentPath === linkPath || 
                    (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                    item.classList.add('active');
                }
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                // On desktop
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            }
        });
        
        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            initSidebar();
            setActiveNavItem();
        });
    </script>
</body>
</html>