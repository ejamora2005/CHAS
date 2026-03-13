<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CHAS') }} | @yield('title', 'Dashboard')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bg-top: #eef8ff;
                --bg-bottom: #eafff2;
                --topbar-start: #1b3f55;
                --topbar-end: #205c6f;
                --topbar-border: rgba(255, 255, 255, 0.18);
                --ink: #183243;
                --muted: #3e6073;
                --card-bg: rgba(255, 255, 255, 0.88);
                --card-border: #bad0dd;
                --chip-bg: #edf6fb;
                --chip-border: #c7dae6;
                --accent: #1f80ad;
                --accent-soft: #e3f6ff;
                --cta-start: #ffcb7a;
                --cta-end: #f3a550;
                --cta-ink: #5f350f;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: "Poppins", sans-serif;
                color: var(--ink);
                background:
                    radial-gradient(circle at 15% 10%, rgba(26, 123, 182, 0.14), transparent 40%),
                    radial-gradient(circle at 85% 15%, rgba(32, 157, 95, 0.16), transparent 34%),
                    linear-gradient(180deg, var(--bg-top) 0%, var(--bg-bottom) 100%);
            }

            .portal-shell {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .topbar {
                background: linear-gradient(140deg, var(--topbar-start) 0%, var(--topbar-end) 100%);
                border-bottom: 1px solid var(--topbar-border);
                box-shadow: 0 10px 22px rgba(14, 46, 62, 0.2);
            }

            .topbar-inner {
                width: min(1300px, calc(100% - 1.7rem));
                margin: 0 auto;
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 0.9rem 0;
            }

            .logo-link {
                display: inline-flex;
                align-items: center;
                gap: 0.62rem;
                flex-shrink: 0;
                text-decoration: none;
            }

            .logo-image {
                width: 3rem;
                height: 3rem;
                object-fit: contain;
                filter: drop-shadow(0 5px 12px rgba(8, 35, 47, 0.38));
            }

            .logo-copy {
                display: grid;
                align-content: center;
                line-height: 1.05;
            }

            .logo-name {
                margin: 0;
                font-size: 0.82rem;
                font-weight: 700;
                letter-spacing: 0.02em;
                color: #ecfaff;
            }

            .logo-sub {
                margin: 0.1rem 0 0;
                font-size: 0.66rem;
                font-weight: 500;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: rgba(229, 249, 255, 0.8);
            }

            .main-nav {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: clamp(0.8rem, 1.9vw, 2.1rem);
                flex-wrap: wrap;
            }

            .nav-link {
                text-decoration: none;
                color: rgba(239, 251, 255, 0.9);
                font-weight: 600;
                font-size: 0.94rem;
                letter-spacing: 0.02em;
                padding: 0.25rem 0.2rem;
                border-bottom: 2px solid transparent;
            }

            .nav-link:hover,
            .nav-link.is-active {
                color: #ffffff;
                border-bottom-color: #9ee1ff;
            }

            .logout-form {
                flex-shrink: 0;
            }

            .logout-btn {
                border: 0;
                border-radius: 0.55rem;
                min-width: 8.3rem;
                padding: 0.68rem 1.08rem;
                font: inherit;
                font-weight: 600;
                color: #28495d;
                background: linear-gradient(145deg, #ffffff 0%, #dbf0fa 100%);
                box-shadow: 0 8px 20px rgba(4, 27, 40, 0.2);
                cursor: pointer;
                transition: transform 0.16s ease;
            }

            .logout-btn:hover {
                transform: translateY(-1px);
            }

            .page-content {
                width: min(1300px, calc(100% - 1.7rem));
                margin: 1.1rem auto 0;
                flex: 1;
                display: grid;
                gap: 1rem;
            }

            .hero-banner {
                position: relative;
                overflow: hidden;
                border-radius: 1rem;
                min-height: 13.5rem;
                background-image: var(--hero-image);
                background-size: cover;
                background-position: center;
                box-shadow: 0 18px 32px rgba(20, 62, 78, 0.18);
            }

            .hero-banner::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(120deg, rgba(17, 54, 73, 0.78), rgba(25, 98, 69, 0.5));
            }

            .hero-content {
                position: relative;
                z-index: 1;
                padding: 1.3rem 1.4rem;
                color: #effdff;
                max-width: 40rem;
            }

            .hero-title {
                margin: 0;
                font-size: clamp(1.3rem, 2.3vw, 2rem);
                line-height: 1.1;
            }

            .hero-sub {
                margin: 0.55rem 0 0;
                font-size: 0.95rem;
                line-height: 1.5;
                color: rgba(233, 255, 248, 0.92);
            }

            .module-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
            }

            .module-card {
                display: block;
                text-decoration: none;
                color: inherit;
                border: 1px solid var(--card-border);
                border-radius: 0.9rem;
                background: var(--card-bg);
                box-shadow: 0 12px 24px rgba(19, 63, 81, 0.12);
                overflow: hidden;
                transition: transform 0.16s ease, box-shadow 0.16s ease;
            }

            .module-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 28px rgba(19, 63, 81, 0.16);
            }

            .module-photo {
                height: 8.9rem;
                background-size: cover;
                background-position: center;
            }

            .module-body {
                padding: 0.85rem 0.95rem 1rem;
            }

            .module-title {
                margin: 0;
                font-size: 1.06rem;
                font-weight: 700;
                color: #15384d;
            }

            .module-features {
                margin: 0.75rem 0 0;
                padding: 0;
                list-style: none;
                display: flex;
                flex-wrap: wrap;
                gap: 0.45rem;
            }

            .module-features li {
                border: 1px solid var(--chip-border);
                border-radius: 999px;
                background: var(--chip-bg);
                color: #2f5368;
                font-size: 0.75rem;
                font-weight: 600;
                padding: 0.28rem 0.55rem;
            }

            .module-link {
                margin-top: 0.78rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 0.83rem;
                font-weight: 700;
                color: var(--cta-ink);
                background: linear-gradient(145deg, var(--cta-start) 0%, var(--cta-end) 100%);
                border-radius: 0.5rem;
                padding: 0.55rem 0.8rem;
            }

            .section-card {
                border: 1px solid var(--card-border);
                border-radius: 0.9rem;
                background: var(--card-bg);
                box-shadow: 0 12px 24px rgba(19, 63, 81, 0.12);
                overflow: hidden;
            }

            .section-head {
                padding: 0.9rem 1rem 0.3rem;
                color: #163b51;
            }

            .section-head h2 {
                margin: 0;
                font-size: 1.18rem;
            }

            .section-head p {
                margin: 0.38rem 0 0;
                color: var(--muted);
                font-size: 0.87rem;
            }

            .feature-only-grid {
                padding: 0.95rem 1rem 1rem;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.7rem;
            }

            .feature-only-card {
                border: 1px solid #bfd4e1;
                border-radius: 0.72rem;
                background: linear-gradient(150deg, #f8fdff 0%, var(--accent-soft) 100%);
                padding: 0.82rem 0.7rem;
                font-size: 0.85rem;
                font-weight: 600;
                color: #264c61;
                text-align: center;
            }

            .photo-strip {
                padding: 0 1rem 1rem;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.65rem;
            }

            .photo-tile {
                min-height: 6.5rem;
                border-radius: 0.7rem;
                background-size: cover;
                background-position: center;
                border: 1px solid #bfd4e1;
            }

            .quick-actions {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.7rem;
                flex-wrap: wrap;
            }

            .quick-actions a {
                text-decoration: none;
                border: 1px solid var(--card-border);
                border-radius: 999px;
                background: linear-gradient(150deg, #ffffff 0%, var(--accent-soft) 100%);
                color: #1d4a62;
                font-size: 0.84rem;
                font-weight: 700;
                padding: 0.52rem 0.88rem;
            }

            .portal-footer {
                width: min(1300px, calc(100% - 1.7rem));
                margin: 0.95rem auto 1.05rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
                color: #3d6174;
                font-size: 0.78rem;
            }

            .footer-icons {
                display: flex;
                gap: 0.5rem;
            }

            .footer-icons span {
                width: 1.9rem;
                height: 1.8rem;
                border-radius: 0.3rem;
                border: 1px solid #c1d5e2;
                background: linear-gradient(145deg, #f4fbff 0%, #deedf6 100%);
            }

            .footer-links {
                display: flex;
                align-items: center;
                gap: 0.55rem;
            }

            .footer-links a {
                color: inherit;
                text-decoration: none;
            }

            .footer-links a:hover {
                text-decoration: underline;
            }

            @media (max-width: 950px) {
                .topbar-inner {
                    flex-wrap: wrap;
                    justify-content: center;
                }

                .logo-copy {
                    text-align: center;
                }

                .main-nav {
                    order: 3;
                    width: 100%;
                }

                .module-grid,
                .feature-only-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 720px) {
                .page-content {
                    width: calc(100% - 1rem);
                }

                .hero-banner {
                    min-height: 11.6rem;
                }

                .module-grid,
                .feature-only-grid,
                .photo-strip {
                    grid-template-columns: 1fr;
                }

                .module-photo {
                    height: 7.3rem;
                }

                .portal-footer {
                    justify-content: center;
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="portal-shell">
            <header class="topbar">
                <div class="topbar-inner">
                    <a href="{{ route('dashboard') }}" class="logo-link" aria-label="Dashboard">
                        <x-application-logo class="logo-image" />
                        <span class="logo-copy">
                            <span class="logo-name">Campus Health</span>
                            <span class="logo-sub">Appointment System</span>
                        </span>
                    </a>

                    <nav class="main-nav" aria-label="Primary">
                        <a href="{{ route('medical-services.index') }}" class="nav-link {{ request()->routeIs('medical-services.*') ? 'is-active' : '' }}">Medical Services</a>
                        <a href="{{ route('booking.index') }}" class="nav-link {{ request()->routeIs('booking.*') ? 'is-active' : '' }}">Booking</a>
                        <a href="{{ route('my-health.index') }}" class="nav-link {{ request()->routeIs('my-health.*') ? 'is-active' : '' }}">My Health</a>
                        <a href="{{ route('emergency-info.index') }}" class="nav-link {{ request()->routeIs('emergency-info.*') ? 'is-active' : '' }}">Emergency Info</a>
                    </nav>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </header>

            <main class="page-content">
                @yield('content')
            </main>

            <footer class="portal-footer">
                <div class="footer-icons" aria-hidden="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav class="footer-links" aria-label="Footer menu">
                    <a href="#">Item 1</a>
                    <span>|</span>
                    <a href="#">Item 2</a>
                    <span>|</span>
                    <a href="#">Item 3</a>
                </nav>
            </footer>
        </div>
    </body>
</html>
