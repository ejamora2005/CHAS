<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --bg-top: #ecfbff;
                --bg-bottom: #e8fff1;
                --card-start: #0f6f85;
                --card-end: #0f8d63;
                --surface: #ecf8ff;
                --surface-soft: #d8f2ff;
                --ink: #12313b;
                --heading: #f7fffd;
                --subheading: rgba(236, 255, 249, 0.86);
                --label: rgba(236, 255, 250, 0.93);
                --link: #d9fff4;
                --focus: #8ce6ff;
                --cta-start: #ffc56e;
                --cta-end: #f59a48;
                --cta-text: #5c2f0a;
            }

            * {
                box-sizing: border-box;
            }

            body.auth-flow {
                margin: 0;
                min-height: 100vh;
                font-family: "Poppins", sans-serif;
                color: var(--ink);
                background:
                    radial-gradient(circle at 14% 12%, rgba(32, 143, 196, 0.22) 0%, transparent 40%),
                    radial-gradient(circle at 84% 15%, rgba(27, 172, 105, 0.22) 0%, transparent 36%),
                    linear-gradient(180deg, var(--bg-top) 0%, var(--bg-bottom) 100%);
            }

            .auth-shell {
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 2rem 1rem;
            }

            .auth-card {
                width: min(100%, 35.5rem);
                position: relative;
                overflow: hidden;
                background: linear-gradient(145deg, var(--card-start) 0%, var(--card-end) 100%);
                border-radius: 1rem;
                padding: 1.75rem 1.5rem 1.5rem;
                box-shadow: 0 30px 44px rgba(6, 53, 67, 0.3);
                animation: auth-card-in 0.45s ease both;
            }

            .auth-card::before {
                content: "";
                position: absolute;
                inset: -45% -25% auto auto;
                width: 16rem;
                height: 16rem;
                border-radius: 999px;
                background: radial-gradient(circle, rgba(180, 245, 255, 0.32), transparent 70%);
                pointer-events: none;
            }

            .auth-card::after {
                content: "";
                position: absolute;
                inset: auto auto -55% -22%;
                width: 14rem;
                height: 14rem;
                border-radius: 999px;
                background: radial-gradient(circle, rgba(255, 230, 166, 0.27), transparent 70%);
                pointer-events: none;
            }

            .auth-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .auth-brand-link {
                display: inline-flex;
                align-items: center;
                gap: 0.62rem;
                text-decoration: none;
            }

            .auth-logo {
                width: 3rem;
                height: 3rem;
                object-fit: contain;
                filter: drop-shadow(0 5px 11px rgba(8, 54, 47, 0.28));
            }

            .auth-brand-copy {
                display: grid;
                line-height: 1.05;
                text-align: left;
            }

            .auth-brand-name {
                margin: 0;
                font-size: 0.78rem;
                font-weight: 700;
                color: #effffd;
            }

            .auth-brand-sub {
                margin: 0.1rem 0 0;
                font-size: 0.66rem;
                font-weight: 500;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: rgba(224, 252, 243, 0.82);
            }

            .auth-content {
                width: min(100%, 18.75rem);
                margin-inline: auto;
                animation: auth-fade-up 0.5s ease 0.08s both;
                position: relative;
                z-index: 1;
            }

            .auth-footer {
                display: flex;
                justify-content: center;
                margin-top: 1.35rem;
                animation: auth-fade-up 0.5s ease 0.16s both;
                position: relative;
                z-index: 1;
            }

            .auth-icon-row {
                display: flex;
                gap: 1rem;
            }

            .auth-icon-btn {
                width: 3.1rem;
                height: 3.1rem;
                border-radius: 0.7rem;
                border: 1px solid rgba(255, 255, 255, 0.6);
                background: linear-gradient(150deg, rgba(255, 255, 255, 0.94), rgba(227, 248, 255, 0.9));
                color: var(--ink);
                display: inline-flex;
                justify-content: center;
                align-items: center;
                font-weight: 700;
                font-size: 0.95rem;
                font-family: inherit;
                text-decoration: none;
                padding: 0;
                cursor: pointer;
                transition: transform 0.16s ease;
            }

            .auth-icon-btn:hover {
                transform: translateY(-1px);
            }

            .auth-icon-btn--google {
                color: #4285f4;
            }

            .auth-icon-btn--facebook {
                color: #1877f2;
            }

            .auth-icon-btn--apple {
                color: #111827;
            }

            .auth-icon-svg {
                width: 1.28rem;
                height: 1.28rem;
                display: block;
                flex-shrink: 0;
            }

            .auth-heading {
                margin: 0;
                text-align: center;
                font-size: 1.55rem;
                line-height: 1.1;
                letter-spacing: -0.01em;
                font-weight: 700;
                color: var(--heading);
            }

            .auth-subheading {
                margin: 0.32rem 0 1.2rem;
                text-align: center;
                font-size: 0.92rem;
                color: var(--subheading);
                line-height: 1.45;
            }

            .auth-alert {
                margin: 0 0 0.75rem;
                padding: 0.55rem 0.7rem;
                border-radius: 0.55rem;
                background: rgba(218, 255, 234, 0.93);
                color: #165a39;
                font-size: 0.82rem;
                text-align: center;
            }

            .auth-form {
                display: grid;
                gap: 0.82rem;
            }

            .auth-field {
                display: grid;
                gap: 0.3rem;
            }

            .auth-label {
                font-size: 0.82rem;
                font-weight: 600;
                margin-left: 0.2rem;
                color: var(--label);
            }

            .auth-input {
                width: 100%;
                border: 1px solid rgba(19, 86, 104, 0.2);
                border-radius: 0.65rem;
                background: linear-gradient(180deg, var(--surface) 0%, var(--surface-soft) 100%);
                color: var(--ink);
                font-size: 0.95rem;
                line-height: 1.3;
                padding: 0.72rem 0.9rem;
                transition: border-color 0.16s ease, box-shadow 0.16s ease;
            }

            .auth-input::placeholder {
                color: rgba(18, 49, 59, 0.58);
            }

            .auth-input:focus {
                outline: none;
                border-color: var(--focus);
                box-shadow: 0 0 0 3px rgba(140, 230, 255, 0.24);
            }

            .auth-input-error {
                border-color: #fecaca;
                background: #fee2e2;
            }

            .auth-error {
                margin: 0;
                font-size: 0.76rem;
                color: #611a1a;
                line-height: 1.3;
            }

            .auth-hint-row {
                display: flex;
                justify-content: flex-end;
                margin-top: -0.15rem;
            }

            .auth-link {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--link);
                text-decoration: none;
            }

            .auth-link:hover {
                text-decoration: underline;
                color: #ffffff;
            }

            .auth-submit {
                width: 100%;
                border: 0;
                border-radius: 0.65rem;
                background: linear-gradient(140deg, var(--cta-start) 0%, var(--cta-end) 100%);
                color: var(--cta-text);
                font-family: inherit;
                font-weight: 700;
                font-size: 0.95rem;
                letter-spacing: 0.01em;
                padding: 0.85rem 1rem;
                cursor: pointer;
                box-shadow: 0 10px 20px rgba(107, 60, 11, 0.22);
                transition: transform 0.16s ease, filter 0.16s ease;
            }

            .auth-submit:hover {
                transform: translateY(-1px);
                filter: brightness(1.03);
            }

            .auth-submit:focus-visible {
                outline: 2px solid rgba(255, 255, 255, 0.8);
                outline-offset: 2px;
            }

            .auth-switch {
                margin: 0.82rem 0 0;
                text-align: center;
                font-size: 0.82rem;
                color: rgba(229, 255, 247, 0.82);
            }

            @keyframes auth-card-in {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes auth-fade-up {
                from {
                    opacity: 0;
                    transform: translateY(8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 640px) {
                .auth-shell {
                    align-items: flex-start;
                    padding: 1rem 0.75rem;
                }

                .auth-card {
                    border-radius: 0.85rem;
                    padding: 1.25rem 1rem 1rem;
                }

                .auth-content {
                    width: 100%;
                }

                .auth-icon-row {
                    gap: 0.7rem;
                }

                .auth-icon-btn {
                    width: 2.85rem;
                    height: 2.85rem;
                }

                .auth-brand-link {
                    flex-direction: column;
                    gap: 0.3rem;
                }

                .auth-brand-copy {
                    text-align: center;
                }
            }
        </style>
    </head>
    <body class="auth-flow antialiased">
        <main class="auth-shell">
            <section class="auth-card">
                <div class="auth-brand">
                    <a href="/" class="auth-brand-link">
                        <x-application-logo class="auth-logo" />
                        <span class="auth-brand-copy">
                            <span class="auth-brand-name">Campus Health</span>
                            <span class="auth-brand-sub">Appointment System</span>
                        </span>
                    </a>
                </div>

                <div class="auth-content">
                    {{ $slot }}
                </div>

                @if (isset($footer))
                    <div class="auth-footer">
                        {{ $footer }}
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
