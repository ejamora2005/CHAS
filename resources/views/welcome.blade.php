<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Health Appointment System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-top: #e8fbf4;
            --bg-mid: #d0f1ff;
            --ink: #123130;
            --muted: #3b6462;
            --line: #c6e7e2;
            --card: #ffffff;
            --accent: #16785f;
            --accent-strong: #0d5f4c;
            --soft-accent: #e3f7ee;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Space Grotesk", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 15%, rgba(22, 120, 95, 0.2), transparent 40%),
                radial-gradient(circle at 90% 12%, rgba(18, 92, 115, 0.18), transparent 44%),
                linear-gradient(180deg, var(--bg-top) 0%, var(--bg-mid) 100%);
        }

        .shell {
            width: min(1120px, calc(100% - 2rem));
            margin: 1.2rem auto 1.8rem;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border: 1px solid rgba(198, 231, 226, 0.7);
            border-radius: 18px;
            padding: 0.8rem 1rem;
            backdrop-filter: blur(6px);
            background: rgba(255, 255, 255, 0.72);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 0;
        }

        .brand-logo {
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 0.8rem;
            object-fit: cover;
            flex-shrink: 0;
        }

        .brand-name {
            margin: 0;
            font-family: "Manrope", sans-serif;
            font-size: 0.98rem;
            font-weight: 800;
            line-height: 1.15;
        }

        .brand-sub {
            margin: 0.14rem 0 0;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn {
            text-decoration: none;
            border-radius: 999px;
            padding: 0.58rem 1rem;
            font-weight: 700;
            font-size: 0.88rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-outline {
            color: var(--accent-strong);
            border: 1px solid #95cec3;
            background: rgba(255, 255, 255, 0.85);
        }

        .btn-solid {
            color: #ffffff;
            background: linear-gradient(130deg, var(--accent) 0%, #1c8f70 100%);
            box-shadow: 0 10px 20px rgba(13, 95, 76, 0.22);
        }

        .hero {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: 1.25fr 0.95fr;
            gap: 1rem;
        }

        .hero-main,
        .hero-side,
        .feature,
        .steps {
            border: 1px solid var(--line);
            border-radius: 22px;
            background: var(--card);
            box-shadow: 0 12px 28px rgba(18, 49, 48, 0.08);
        }

        .hero-main {
            padding: 2.2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-main::after {
            content: "";
            position: absolute;
            right: -65px;
            top: -80px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(22, 120, 95, 0.2), transparent 67%);
            pointer-events: none;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            font-size: 0.73rem;
            letter-spacing: 0.08em;
            font-weight: 700;
            text-transform: uppercase;
            background: var(--soft-accent);
            color: var(--accent-strong);
        }

        h1 {
            margin: 0.95rem 0 0.85rem;
            font-family: "Manrope", sans-serif;
            font-size: clamp(1.95rem, 5vw, 3.2rem);
            line-height: 1.05;
            letter-spacing: -0.02em;
        }

        .lead {
            margin: 0;
            max-width: 60ch;
            color: var(--muted);
            line-height: 1.6;
        }

        .hero-cta {
            margin-top: 1.4rem;
            display: flex;
            gap: 0.7rem;
            flex-wrap: wrap;
        }

        .hero-side {
            padding: 1.4rem 1.2rem;
            display: grid;
            gap: 0.75rem;
            align-content: start;
        }

        .metric {
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 0.95rem;
            background: linear-gradient(180deg, #f6fffb 0%, #effaf6 100%);
        }

        .metric h3 {
            margin: 0;
            font-family: "Manrope", sans-serif;
            font-size: 1.35rem;
            letter-spacing: -0.015em;
            color: var(--accent-strong);
        }

        .metric p {
            margin: 0.35rem 0 0;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .grid-lower {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 1rem;
        }

        .feature-wrap {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .feature {
            padding: 1rem;
        }

        .feature-id {
            width: 2rem;
            height: 2rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.84rem;
            font-weight: 700;
            background: #e2f6ef;
            color: var(--accent-strong);
        }

        .feature h3 {
            margin: 0.8rem 0 0.45rem;
            font-family: "Manrope", sans-serif;
            font-size: 1.03rem;
        }

        .feature p {
            margin: 0;
            color: var(--muted);
            line-height: 1.45;
            font-size: 0.9rem;
        }

        .steps {
            padding: 1.1rem 1rem;
            background: linear-gradient(180deg, #fff 0%, #f3fbff 100%);
        }

        .steps h2 {
            margin: 0 0 0.7rem;
            font-family: "Manrope", sans-serif;
            font-size: 1.05rem;
        }

        .step {
            display: grid;
            grid-template-columns: 1.8rem 1fr;
            gap: 0.65rem;
            align-items: start;
            margin-top: 0.72rem;
        }

        .step-index {
            width: 1.8rem;
            height: 1.8rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            color: #fff;
            background: var(--accent);
        }

        .step p {
            margin: 0;
            color: var(--muted);
            line-height: 1.4;
            font-size: 0.88rem;
        }

        .footer {
            margin-top: 1rem;
            text-align: center;
            color: #507773;
            font-size: 0.82rem;
            font-weight: 500;
        }

        .reveal {
            opacity: 0;
            transform: translateY(14px);
            animation: rise 0.62s ease forwards;
        }

        .d1 { animation-delay: 0.08s; }
        .d2 { animation-delay: 0.16s; }
        .d3 { animation-delay: 0.24s; }

        @keyframes rise {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 980px) {
            .hero,
            .grid-lower {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .feature-wrap {
                grid-template-columns: 1fr;
            }

            .shell {
                width: min(1120px, calc(100% - 1rem));
                margin-top: 0.7rem;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .top-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .hero-main {
                padding: 1.35rem 1rem;
            }

            .hero-side,
            .steps {
                padding: 1rem;
            }

            h1 {
                font-size: 1.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="topbar reveal">
            <div class="brand">
                <x-application-logo class="brand-logo" />
                <div>
                    <p class="brand-name">Campus Health Appointment System</p>
                    <p class="brand-sub">Student Clinic Portal</p>
                </div>
            </div>
            <div class="top-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-solid">Open Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-solid">Create account</a>
                    @endif
                @endauth
            </div>
        </header>

        <main class="hero">
            <section class="hero-main reveal d1">
                <span class="eyebrow">Campus Care Hub</span>
                <h1>Appointments, records, and clinic updates in one place.</h1>
                <p class="lead">
                    CHAS helps students request consultations, track visit history, and receive reminders
                    without waiting in line at the campus clinic.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('login') }}" class="btn btn-solid">Book appointment</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Join CHAS</a>
                    @endif
                </div>
            </section>

            <aside class="hero-side reveal d2">
                <article class="metric">
                    <h3>24/7 Access</h3>
                    <p>Submit requests and review your profile anytime from your device.</p>
                </article>
                <article class="metric">
                    <h3>Secure Records</h3>
                    <p>Keep appointment and consultation details organized in one account.</p>
                </article>
                <article class="metric">
                    <h3>Fast Updates</h3>
                    <p>Get notified about schedule changes, confirmations, and next steps.</p>
                </article>
            </aside>
        </main>

        <section class="grid-lower">
            <div class="feature-wrap reveal d2">
                <article class="feature">
                    <span class="feature-id">01</span>
                    <h3>Smart Booking</h3>
                    <p>Select a preferred schedule and manage bookings with fewer clicks.</p>
                </article>
                <article class="feature">
                    <span class="feature-id">02</span>
                    <h3>Student Profiles</h3>
                    <p>Maintain personal and medical details that support each consultation.</p>
                </article>
                <article class="feature">
                    <span class="feature-id">03</span>
                    <h3>Status Tracking</h3>
                    <p>Follow each appointment from request to completion inside the dashboard.</p>
                </article>
            </div>

            <aside class="steps reveal d3">
                <h2>How it works</h2>
                <div class="step">
                    <span class="step-index">1</span>
                    <p>Create an account and complete your basic health profile.</p>
                </div>
                <div class="step">
                    <span class="step-index">2</span>
                    <p>Choose your preferred appointment time and submit a request.</p>
                </div>
                <div class="step">
                    <span class="step-index">3</span>
                    <p>Open your dashboard to track updates and prepare for your visit.</p>
                </div>
            </aside>
        </section>

        <footer class="footer">
            &copy; {{ date('Y') }} Campus Health Appointment System
        </footer>
    </div>
</body>
</html>
