<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Campus Health Appointment System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --bg-top: #eef8ff;
            --bg-bottom: #eafff2;
            --topbar-start: #1b3f55;
            --topbar-end: #205c6f;
            --topbar-border: rgba(255, 255, 255, 0.18);
            --ink: #183243;
            --muted: #3e6073;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: #bad0dd;
            --chip-bg: #edf6fb;
            --chip-border: #c7dae6;
            --accent: #1f80ad;
            --accent-soft: #e3f6ff;
            --cta-start: #ffcb7a;
            --cta-end: #f3a550;
            --cta-ink: #5f350f;
            --success: #206447;
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

        .nav-link:hover {
            color: #ffffff;
            border-bottom-color: #9ee1ff;
        }

        .auth-actions {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .btn {
            text-decoration: none;
            border-radius: 0.55rem;
            padding: 0.62rem 0.98rem;
            font-size: 0.85rem;
            font-weight: 700;
            line-height: 1;
            transition: transform 0.16s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-light {
            color: #28495d;
            background: linear-gradient(145deg, #ffffff 0%, #dbf0fa 100%);
            box-shadow: 0 8px 20px rgba(4, 27, 40, 0.2);
        }

        .btn-warm {
            color: var(--cta-ink);
            background: linear-gradient(145deg, var(--cta-start) 0%, var(--cta-end) 100%);
            box-shadow: 0 10px 16px rgba(109, 69, 20, 0.22);
        }

        .page {
            width: min(1300px, calc(100% - 1.7rem));
            margin: 1.1rem auto 0;
            display: grid;
            gap: 1rem;
        }

        .hero {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            min-height: 16rem;
            background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            box-shadow: 0 18px 32px rgba(20, 62, 78, 0.18);
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(17, 54, 73, 0.8), rgba(20, 95, 71, 0.58));
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            height: 100%;
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
            gap: 1rem;
            padding: 1.3rem 1.4rem;
            color: #effdff;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(1.45rem, 2.5vw, 2.25rem);
            line-height: 1.1;
        }

        .hero-sub {
            margin: 0.55rem 0 0;
            font-size: 0.95rem;
            line-height: 1.55;
            color: rgba(233, 255, 248, 0.92);
            max-width: 60ch;
        }

        .hero-cta {
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .hero-metrics {
            display: grid;
            gap: 0.65rem;
            align-content: start;
        }

        .metric {
            border: 1px solid rgba(214, 238, 250, 0.5);
            border-radius: 0.72rem;
            background: rgba(13, 46, 66, 0.5);
            padding: 0.7rem 0.75rem;
            backdrop-filter: blur(2px);
        }

        .metric h3 {
            margin: 0;
            font-size: 0.86rem;
            color: #d5f1ff;
        }

        .metric p {
            margin: 0.28rem 0 0;
            color: rgba(232, 252, 255, 0.87);
            font-size: 0.78rem;
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
            font-size: 1.08rem;
        }

        .section-head p {
            margin: 0.38rem 0 0;
            color: var(--muted);
            font-size: 0.86rem;
        }

        .module-grid {
            padding: 0.95rem 1rem 1rem;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.78rem;
        }

        .module-card {
            display: block;
            text-decoration: none;
            color: inherit;
            border: 1px solid var(--card-border);
            border-radius: 0.8rem;
            background: linear-gradient(150deg, #ffffff 0%, #eef8ff 100%);
            overflow: hidden;
            transition: transform 0.16s ease, box-shadow 0.16s ease;
        }

        .module-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 22px rgba(19, 63, 81, 0.14);
        }

        .module-photo {
            height: 7.7rem;
            background-size: cover;
            background-position: center;
        }

        .module-body {
            padding: 0.75rem 0.78rem 0.82rem;
        }

        .module-title {
            margin: 0;
            font-size: 1rem;
            color: #15384d;
        }

        .module-copy {
            margin: 0.36rem 0 0;
            font-size: 0.79rem;
            color: #3f6377;
            line-height: 1.45;
        }

        .chips {
            margin: 0.58rem 0 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.38rem;
        }

        .chips li {
            border: 1px solid var(--chip-border);
            border-radius: 999px;
            background: var(--chip-bg);
            color: #2f5368;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.24rem 0.5rem;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .steps {
            padding: 0.95rem 1rem 1rem;
            display: grid;
            gap: 0.6rem;
        }

        .step-item {
            display: grid;
            grid-template-columns: 1.75rem 1fr;
            gap: 0.6rem;
            align-items: start;
            border: 1px solid #c9dbe7;
            border-radius: 0.7rem;
            background: #f5fbff;
            padding: 0.6rem 0.65rem;
        }

        .step-index {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: #ffffff;
            background: var(--accent);
        }

        .step-text {
            margin: 0;
            font-size: 0.82rem;
            color: #2d556a;
            line-height: 1.45;
        }

        .status-list {
            padding: 0.95rem 1rem 1rem;
            margin: 0;
            list-style: none;
            display: grid;
            gap: 0.55rem;
        }

        .status-list li {
            border: 1px solid #c9dbe7;
            border-radius: 0.66rem;
            background: #f5fbff;
            padding: 0.62rem 0.68rem;
            font-size: 0.8rem;
            color: #2d556a;
            font-weight: 600;
            line-height: 1.35;
        }

        .highlight {
            color: var(--success);
            font-weight: 700;
        }

        .landing-footer {
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
            flex-wrap: wrap;
        }

        .footer-links a {
            color: inherit;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 980px) {
            .topbar-inner {
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-nav {
                order: 3;
                width: 100%;
            }

            .hero-grid,
            .two-col,
            .module-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .page,
            .landing-footer {
                width: calc(100% - 1rem);
            }

            .hero {
                min-height: 15rem;
            }

            .module-photo {
                height: 7rem;
            }

            .auth-actions {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a href="{{ url('/') }}" class="logo-link" aria-label="Campus Health home">
                <x-application-logo class="logo-image" />
                <span class="logo-copy">
                    <span class="logo-name">Campus Health</span>
                    <span class="logo-sub">Appointment System</span>
                </span>
            </a>

            <nav class="main-nav" aria-label="Public navigation">
                <a class="nav-link" href="#services">Services</a>
                <a class="nav-link" href="#features">Features</a>
                <a class="nav-link" href="#how-it-works">How It Works</a>
                <a class="nav-link" href="#status">Clinic Status</a>
            </nav>

            <div class="auth-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-warm">Open Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-warm">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="page">
        <section class="hero" id="features">
            <div class="hero-grid">
                <div>
                    <h1 class="hero-title">Student clinic booking and health tracking in one dashboard.</h1>
                    <p class="hero-sub">
                        CHAS streamlines appointments, service requests, records, and emergency contacts so students can
                        focus on care, not paperwork.
                    </p>
                    <div class="hero-cta">
                        <a href="{{ route('login') }}" class="btn btn-warm">Book an Appointment</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light">Join CHAS</a>
                        @endif
                    </div>
                </div>

                <aside class="hero-metrics" aria-label="Highlights">
                    <article class="metric">
                        <h3>Fast Scheduling</h3>
                        <p>Choose your date and preferred time slot in minutes.</p>
                    </article>
                    <article class="metric">
                        <h3>Accurate Records</h3>
                        <p>Keep consultation history, prescriptions, and notes organized.</p>
                    </article>
                    <article class="metric">
                        <h3>Real-time Updates</h3>
                        <p>Track request status without going back to the clinic window.</p>
                    </article>
                </aside>
            </div>
        </section>

        <section class="section-card" id="services">
            <header class="section-head">
                <h2>Core Modules</h2>
                <p>The same modules you use inside the dashboard, presented here for quick entry.</p>
            </header>

            <div class="module-grid">
                <a href="{{ route('login') }}" class="module-card">
                    <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="module-body">
                        <h3 class="module-title">Booking</h3>
                        <p class="module-copy">Schedule and manage your clinic visits.</p>
                        <ul class="chips">
                            <li>Set Appointment</li>
                            <li>Reschedule</li>
                            <li>Track Status</li>
                        </ul>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="module-card">
                    <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="module-body">
                        <h3 class="module-title">Medical Services</h3>
                        <p class="module-copy">Request consultations, lab checks, and vaccinations.</p>
                        <ul class="chips">
                            <li>Consultation</li>
                            <li>Laboratory</li>
                            <li>Vaccination</li>
                        </ul>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="module-card">
                    <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="module-body">
                        <h3 class="module-title">My Health</h3>
                        <p class="module-copy">Maintain personal records and health history.</p>
                        <ul class="chips">
                            <li>Health Records</li>
                            <li>Results</li>
                            <li>Prescriptions</li>
                        </ul>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="module-card">
                    <div class="module-photo" style="background-image: url('https://images.unsplash.com/photo-1516841273335-e39b37888115?auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="module-body">
                        <h3 class="module-title">Emergency Info</h3>
                        <p class="module-copy">Store trusted contacts and urgent care references.</p>
                        <ul class="chips">
                            <li>Emergency Contact</li>
                            <li>Primary Contact</li>
                            <li>Hospital Notes</li>
                        </ul>
                    </div>
                </a>
            </div>
        </section>

        <section class="two-col">
            <section class="section-card" id="how-it-works">
                <header class="section-head">
                    <h2>How It Works</h2>
                    <p>Simple flow from account setup to appointment completion.</p>
                </header>

                <div class="steps">
                    <article class="step-item">
                        <span class="step-index">1</span>
                        <p class="step-text">Login or create an account to access your student health portal.</p>
                    </article>
                    <article class="step-item">
                        <span class="step-index">2</span>
                        <p class="step-text">Choose a service and submit your appointment details.</p>
                    </article>
                    <article class="step-item">
                        <span class="step-index">3</span>
                        <p class="step-text">Monitor updates in your dashboard and prepare for the visit.</p>
                    </article>
                </div>
            </section>

            <section class="section-card" id="status">
                <header class="section-head">
                    <h2>Clinic Status</h2>
                    <p>Quick overview of what students can do right now.</p>
                </header>

                <ul class="status-list">
                    <li><span class="highlight">Booking:</span> Accepting appointment requests.</li>
                    <li><span class="highlight">Records:</span> Personal health data is securely stored per account.</li>
                    <li><span class="highlight">Requests:</span> Medical service tickets are tracked in real time.</li>
                    <li><span class="highlight">Support:</span> Emergency contact management is always available.</li>
                </ul>
            </section>
        </section>
    </main>

    <footer class="landing-footer">
        <nav class="footer-links" aria-label="Footer navigation">
            <a href="{{ route('login') }}">Login</a>
            <span>|</span>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                <span>|</span>
            @endif
            <a href="#services">Services</a>
            <span>|</span>
            <a href="#how-it-works">How It Works</a>
        </nav>
        <span>&copy; {{ date('Y') }} Campus Health Appointment System</span>
    </footer>
</body>
</html>
