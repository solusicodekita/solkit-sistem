<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Nita Jaya Catering</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-circle">
                <img src="{{ asset('images/nitajaya.png') }}" alt="Logo Nita Jaya Catering">
            </div>
            <div class="brand">NITA JAYA CATERING</div>
        </div>
        <nav>
            <a href="#" class="nav-link active">
                <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
            </a>
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-utensils"></i> <span>Menu Item</span>
            </a>
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-cart-shopping"></i> <span>Menu Transaksi</span>
            </a>
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-users"></i> <span>Menu User</span>
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        </form>
        <div class="copyright">
            &copy; {{ date('Y') }} <span style="color:#ffc107;">Nita Jaya Catering</span>
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
