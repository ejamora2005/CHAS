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

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 0.75rem;
            }

            .stat-card {
                border: 1px solid var(--card-border);
                border-radius: 0.85rem;
                padding: 0.85rem 0.9rem;
                background: linear-gradient(150deg, #ffffff 0%, #e8f6ff 100%);
                box-shadow: 0 10px 20px rgba(18, 59, 79, 0.1);
            }

            .stat-label {
                margin: 0;
                font-size: 0.76rem;
                font-weight: 600;
                color: #3d6277;
            }

            .stat-value {
                margin: 0.42rem 0 0;
                font-size: 1.3rem;
                font-weight: 700;
                color: #154761;
                line-height: 1;
            }

            .insight-grid {
                display: grid;
                grid-template-columns: 1.35fr 1fr;
                gap: 1rem;
            }

            .insight-panel {
                border: 1px solid var(--card-border);
                border-radius: 0.9rem;
                background: var(--card-bg);
                box-shadow: 0 12px 24px rgba(19, 63, 81, 0.12);
                padding: 0.95rem 1rem;
            }

            .insight-title {
                margin: 0;
                font-size: 1.05rem;
                color: #173c50;
            }

            .insight-subtitle {
                margin: 0.35rem 0 0.9rem;
                font-size: 0.82rem;
                color: var(--muted);
            }

            .timeline-list {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.65rem;
            }

            .timeline-item {
                display: grid;
                grid-template-columns: 5.1rem 1fr;
                gap: 0.7rem;
                align-items: center;
                border: 1px solid #c9dbe7;
                border-radius: 0.7rem;
                background: #f5fbff;
                padding: 0.58rem 0.65rem;
            }

            .timeline-time {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 0.5rem;
                border: 1px solid #b9d2e1;
                background: #e9f6ff;
                color: #214c63;
                font-size: 0.74rem;
                font-weight: 700;
                padding: 0.34rem 0.45rem;
            }

            .timeline-copy {
                margin: 0;
                font-size: 0.79rem;
                color: #2d556a;
                line-height: 1.35;
            }

            .checklist {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.58rem;
            }

            .checklist li {
                border: 1px solid #c9dbe7;
                border-radius: 0.66rem;
                background: #f5fbff;
                padding: 0.62rem 0.68rem;
                font-size: 0.79rem;
                color: #2d556a;
                font-weight: 600;
                line-height: 1.35;
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

            .module-subtitle {
                margin: 0.34rem 0 0;
                font-size: 0.78rem;
                font-weight: 600;
                color: #3f6377;
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

            .feature-link-card {
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                color: #264c61;
                min-height: 4rem;
            }

            .feature-link-card:hover {
                background: linear-gradient(150deg, #f0fbff 0%, #dff4ff 100%);
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

            .booking-flash {
                border: 1px solid #b8dbbf;
                border-radius: 0.75rem;
                background: #e9fbea;
                color: #1a5b2f;
                font-size: 0.83rem;
                font-weight: 600;
                padding: 0.72rem 0.9rem;
            }

            .booking-layout {
                display: grid;
                grid-template-columns: 0.95fr 1.05fr;
                gap: 1rem;
            }

            .booking-panel {
                border: 1px solid var(--card-border);
                border-radius: 0.9rem;
                background: var(--card-bg);
                box-shadow: 0 12px 24px rgba(19, 63, 81, 0.12);
                overflow: hidden;
            }

            .booking-form {
                padding: 0.9rem 1rem 1rem;
                display: grid;
                gap: 0.78rem;
            }

            .booking-field {
                display: grid;
                gap: 0.28rem;
            }

            .booking-field label {
                font-size: 0.79rem;
                font-weight: 700;
                color: #264a5f;
            }

            .booking-field input,
            .booking-field select,
            .booking-field textarea,
            .reschedule-form input {
                width: 100%;
                border: 1px solid #bed4e1;
                border-radius: 0.62rem;
                background: #f8fdff;
                color: #1f455a;
                font: inherit;
                font-size: 0.86rem;
                padding: 0.62rem 0.68rem;
            }

            .booking-field textarea {
                resize: vertical;
                min-height: 5rem;
            }

            .booking-field input:focus,
            .booking-field select:focus,
            .booking-field textarea:focus,
            .reschedule-form input:focus {
                outline: none;
                border-color: #79bbdc;
                box-shadow: 0 0 0 3px rgba(121, 187, 220, 0.22);
            }

            .booking-input-error {
                border-color: #f3a7a7 !important;
                background: #fff3f3 !important;
            }

            .booking-error {
                margin: 0;
                font-size: 0.75rem;
                font-weight: 600;
                color: #8a2323;
            }

            .booking-field-group {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.7rem;
            }

            .booking-submit {
                border: 0;
                border-radius: 0.6rem;
                background: linear-gradient(145deg, var(--cta-start) 0%, var(--cta-end) 100%);
                color: var(--cta-ink);
                font: inherit;
                font-size: 0.86rem;
                font-weight: 700;
                padding: 0.72rem 0.9rem;
                cursor: pointer;
                box-shadow: 0 10px 16px rgba(109, 69, 20, 0.16);
            }

            .booking-list {
                padding: 0.2rem 1rem 1rem;
                display: grid;
                gap: 0.7rem;
            }

            .booking-item {
                border: 1px solid #c4d7e4;
                border-radius: 0.78rem;
                background: #f8fdff;
                padding: 0.72rem 0.78rem;
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 0.7rem;
                align-items: start;
            }

            .booking-service {
                margin: 0;
                font-size: 0.9rem;
                font-weight: 700;
                color: #19445a;
            }

            .booking-meta {
                margin: 0.28rem 0 0;
                font-size: 0.77rem;
                color: #45677b;
            }

            .booking-tags {
                margin-top: 0.42rem;
                display: flex;
                gap: 0.4rem;
                flex-wrap: wrap;
            }

            .booking-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #bfd4e1;
                border-radius: 999px;
                background: #edf6fb;
                color: #2c5569;
                font-size: 0.7rem;
                font-weight: 700;
                line-height: 1;
                padding: 0.32rem 0.5rem;
            }

            .booking-status-pending {
                border-color: #f0d29d;
                background: #fff7e8;
                color: #8c5d1b;
            }

            .booking-status-confirmed {
                border-color: #9fdfb3;
                background: #effcf3;
                color: #226338;
            }

            .booking-status-cancelled {
                border-color: #f0b2b2;
                background: #fff0f0;
                color: #8b3030;
            }

            .booking-status-in_review {
                border-color: #c6b4ef;
                background: #f3eefe;
                color: #4d3b87;
            }

            .booking-status-scheduled {
                border-color: #9fd8e8;
                background: #eefaff;
                color: #1f5e73;
            }

            .booking-status-completed {
                border-color: #a6ddb1;
                background: #edfdf1;
                color: #23613a;
            }

            .booking-concern {
                margin: 0.48rem 0 0;
                font-size: 0.77rem;
                color: #45677b;
                line-height: 1.4;
            }

            .booking-item-actions {
                display: grid;
                justify-items: end;
                gap: 0.38rem;
            }

            .booking-item-actions form button {
                border: 1px solid #b8cedb;
                border-radius: 0.5rem;
                background: #f1f8fc;
                color: #2a5468;
                font: inherit;
                font-size: 0.74rem;
                font-weight: 700;
                padding: 0.36rem 0.58rem;
                cursor: pointer;
            }

            .booking-reschedule summary {
                list-style: none;
                cursor: pointer;
                font-size: 0.74rem;
                font-weight: 700;
                color: #1f6c91;
            }

            .booking-reschedule summary::-webkit-details-marker {
                display: none;
            }

            .reschedule-form {
                margin-top: 0.38rem;
                display: grid;
                gap: 0.35rem;
                min-width: 12.5rem;
            }

            .reschedule-form button,
            .booking-cancel {
                border: 1px solid #b8cedb;
                border-radius: 0.5rem;
                background: #f1f8fc;
                color: #2a5468;
                font: inherit;
                font-size: 0.74rem;
                font-weight: 700;
                padding: 0.36rem 0.58rem;
                cursor: pointer;
            }

            .booking-cancel {
                border-color: #edb3b3;
                background: #fff0f0;
                color: #8b3030;
            }

            .service-priority {
                border-color: #bdd2df;
                background: #edf6fb;
            }

            .service-priority-low {
                border-color: #b3d9bf;
                background: #eefcf3;
                color: #2a6a3f;
            }

            .service-priority-medium {
                border-color: #9fd8e8;
                background: #edfaff;
                color: #1f5c71;
            }

            .service-priority-high {
                border-color: #f2ce95;
                background: #fff6e8;
                color: #8b5b16;
            }

            .service-priority-urgent {
                border-color: #efaaaa;
                background: #fff1f1;
                color: #8a2e2e;
            }

            .booking-cancelled-note {
                font-size: 0.74rem;
                font-weight: 700;
                color: #8b3030;
            }

            .health-status-form {
                display: grid;
                gap: 0.34rem;
                min-width: 8.6rem;
            }

            .health-status-form select {
                border: 1px solid #bed4e1;
                border-radius: 0.5rem;
                background: #f8fdff;
                color: #1f455a;
                font: inherit;
                font-size: 0.74rem;
                font-weight: 600;
                padding: 0.34rem 0.5rem;
            }

            .health-status-form button {
                border: 1px solid #b8cedb;
                border-radius: 0.5rem;
                background: #f1f8fc;
                color: #2a5468;
                font: inherit;
                font-size: 0.74rem;
                font-weight: 700;
                padding: 0.34rem 0.55rem;
                cursor: pointer;
            }

            .booking-status-resolved {
                border-color: #9fdfb3;
                background: #effcf3;
                color: #226338;
            }

            .booking-status-archived {
                border-color: #b4c7d5;
                background: #edf4f8;
                color: #3b5566;
            }

            .booking-empty {
                margin: 0;
                border: 1px dashed #b8cedb;
                border-radius: 0.75rem;
                background: #f6fbff;
                color: #46697c;
                font-size: 0.82rem;
                font-weight: 600;
                padding: 0.85rem;
                text-align: center;
            }

            .contact-primary-check {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                font-size: 0.78rem;
                font-weight: 600;
                color: #35586c;
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

            .footer-copy {
                font-size: 0.78rem;
                color: #4b6d80;
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
                .feature-only-grid,
                .stats-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .insight-grid {
                    grid-template-columns: 1fr;
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
                .photo-strip,
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .module-photo {
                    height: 7.3rem;
                }

                .booking-layout,
                .booking-field-group,
                .booking-item {
                    grid-template-columns: 1fr;
                }

                .booking-item-actions {
                    justify-items: start;
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
                <nav class="footer-links" aria-label="Footer menu">
                    <a href="{{ route('medical-services.index') }}">Services</a>
                    <span>|</span>
                    <a href="{{ route('booking.index') }}">Booking</a>
                    <span>|</span>
                    <a href="{{ route('emergency-info.index') }}">Emergency</a>
                </nav>
                <span class="footer-copy">&copy; {{ date('Y') }} Campus Health Appointment System</span>
            </footer>
        </div>
    </body>
</html>
