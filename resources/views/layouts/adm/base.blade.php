<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Nita Jaya Catering</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/select2/css/select2.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Nunito', sans-serif;
        }
        .sidebar {
            background: #1a237e;
            min-height: 100vh;
            color: #fff;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 8px rgba(26,35,126,0.08);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            max-height: 100vh; /* Membatasi tinggi maksimum */
        }
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
        .sidebar .logo {
            text-align: center;
            padding: 2.5rem 0 1rem 0;
        }
        .sidebar .logo img {
            height: 80px;
            margin-bottom: 0.7rem;
            filter: drop-shadow(0 2px 8px #ffc10788);
            transition: transform 0.2s;
        }
        .sidebar .logo img:hover {
            transform: scale(1.07) rotate(-3deg);
        }
        .sidebar .brand {
            color: #ffc107;
            font-weight: bold;
            font-size: 1.5rem;
            letter-spacing: 2px;
            text-shadow: 0 2px 8px #ffc10755, 0 1px 0 #fff;
            margin-top: 0.5rem;
            font-family: 'Nunito', sans-serif;
        }
        .sidebar nav {
            flex: 1;
            margin-top: 2rem;
            overflow-y: auto; /* Menambahkan scroll pada nav */
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: 0.2s;
            font-size: 1.05rem;
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(255,193,7,0.13);
            color: #ffc107;
            border-left: 4px solid #ffc107;
            text-decoration: none;
        }
        .sidebar .logout-btn {
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            margin: 2rem;
            width: calc(100% - 4rem);
            transition: background 0.2s;
        }
        .sidebar .logout-btn:hover {
            background: #b71c1c;
        }
        .sidebar .copyright {
            color: #fff;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem 2rem 1rem 2rem;
            min-height: 100vh;
        }
        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
            }
            .sidebar .brand, .sidebar .nav-link span, .sidebar .copyright, .sidebar .logout-btn {
                display: none;
            }
            .sidebar .logo img {
                height: 40px;
            }
            .main-content {
                margin-left: 70px;
                padding: 1rem 0.5rem 0.5rem 0.5rem;
            }
        }
        @media (max-width: 600px) {
            .main-content {
                margin-left: 0;
                padding: 0.5rem 0.2rem 0.2rem 0.2rem;
            }
        }
        .logo-circle {
            background: #fff;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            margin: 0 auto 0.7rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 12px #ffc10733, 0 1px 0 #fff;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .logo-circle img {
            height: 60px;
            width: 60px;
            object-fit: contain;
            filter: none;
            transition: transform 0.2s;
        }
        .logo-circle:hover {
            box-shadow: 0 4px 24px #ffc10755, 0 2px 0 #fff;
            transform: scale(1.05);
        }
        /* Menambahkan style untuk submenu */
        .collapse .nav-link {
            padding-left: 3.5rem !important; /* Menambah padding kiri untuk submenu */
        }
        .sidebar-toggle {
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 200;
            background: #1a237e;
            color: #ffc107;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px #1a237e33;
            display: none;
        }
        @media (max-width: 900px) {
            .sidebar-toggle {
                display: block;
            }
            .sidebar {
                left: -250px;
                transition: left 0.3s;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
                transition: filter 0.3s;
            }
            .main-content.sidebar-open {
                filter: blur(2px);
                pointer-events: none;
                user-select: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Hamburger Toggle Button -->
    <button class="sidebar-toggle d-block d-md-none" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
        <i class="fa fa-bars"></i>
    </button>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-circle">
                <img src="{{ asset('images/nitajaya.png') }}" alt="Logo Nita Jaya Catering">
            </div>
            <div class="brand">NITA JAYA CATERING</div>
        </div>
        <nav>
            <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
            </a>
            <div class="nav-item">
                <a href="#" class="nav-link {{ Request::is('admin/category*') ? 'active' : '' }}" onclick="toggleMenu('masterMenu', event)">
                    <i class="fa-solid fa-database"></i>
                    <span>Master &nbsp;</span>
                    <i class="fa-solid fa-angle-down float-right mt-1"></i>
                </a>
                <div id="masterMenu" class="collapse {{ Request::is('admin/category*') || Request::is('admin/items*') || Request::is('admin/warehouse*') ? 'show' : '' }}">
                    <a href="{{ route('admin.category.index') }}" class="nav-link {{ Request::is('admin/category*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tags"></i> <span>Kategori</span>
                    </a>
                    <a href="{{ route('admin.warehouse.index') }}" class="nav-link {{ Request::is('admin/warehouse*') ? 'active' : '' }}">
                        <i class="fa-solid fa-location-dot"></i> <span>Lokasi</span>
                    </a>
                    <a href="{{ route('admin.items.index') }}" class="nav-link {{ Request::is('admin/items*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box"></i> <span>Bahan</span>
                    </a>
                </div>
            </div>

            <div class="nav-item">
                <a href="#" class="nav-link {{ Request::is('admin/transactions*') ? 'active' : '' }}" onclick="toggleMenu('transaksiMenu', event)">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Transaksi&nbsp;</span>
                    <i class="fa-solid fa-angle-down float-right mt-1"></i>
                </a>
                <div id="transaksiMenu" class="collapse {{ Request::is('admin/stock*') || Request::is('admin/in_stock*') || Request::is('admin/live_stock*') || Request::is('admin/out_stock*') ? 'show' : '' }}">
                    <a href="{{ route('admin.live_stock.index') }}" class="nav-link {{ Request::is('admin/live_stock*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Live Stock</span>
                    </a>
                    <a href="{{ route('admin.in_stock.index') }}" class="nav-link {{ Request::is('admin/in_stock*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Stok Masuk</span>
                    </a>
                    <a href="{{ route('admin.out_stock.index') }}" class="nav-link {{ Request::is('admin/out_stock*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Stok Keluar</span>
                    </a>
                    <a href="{{ route('admin.stock.index') }}" class="nav-link {{ Request::is('admin/stock*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Stok Opname</span>
                    </a>
                    {{-- <a href="#" class="nav-link {{ Request::is('admin/transactions/items*') ? 'active' : '' }}">
                        <i class="fa-solid fa-utensils"></i> <span>Menu Item</span>
                    </a> --}}
                    {{-- <a href="#" class="nav-link {{ Request::is('admin/transactions/users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> <span>Menu User</span>
                    </a> --}}
                </div>
            </div>
        </nav>

        <script>
        function toggleMenu(menuId, event) {
            event.preventDefault();
            const allMenus = document.querySelectorAll('.collapse');
            const clickedMenu = document.getElementById(menuId);
            
            // Close all other menus
            allMenus.forEach(menu => {
                if (menu.id !== menuId && menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            });

            // Toggle clicked menu
            if (clickedMenu) {
                clickedMenu.classList.toggle('show');
            }
        }
        </script>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn btn-sm"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        </form>
        <div class="copyright">
            &copy; {{ date('Y') }} <span style="color:#ffc107;">Nita Jaya Catering</span>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/select2/js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('sidebar-open');
        // Optional: close sidebar when clicking outside
        if (sidebar.classList.contains('active')) {
            document.body.addEventListener('click', closeSidebarOnClickOutside, true);
        } else {
            document.body.removeEventListener('click', closeSidebarOnClickOutside, true);
        }
    }
    function closeSidebarOnClickOutside(e) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('active');
            document.querySelector('.main-content').classList.remove('sidebar-open');
            document.body.removeEventListener('click', closeSidebarOnClickOutside, true);
        }
    }
    </script>
    @stack('scripts')
</body>
</html>
