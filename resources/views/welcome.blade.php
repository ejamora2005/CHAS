<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Campus Health Appointment System</title>

    <!-- Tailwind CDN (quick setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-gradient-to-br from-green-100 to-blue-100 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="flex justify-between items-center p-6 bg-white shadow-md">
        <h1 class="text-2xl font-bold text-green-700">
            Campus Health Appointment System
        </h1>

        <div>
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="text-green-700 font-semibold hover:underline">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="mr-4 text-gray-700 hover:text-green-700">
                    Login
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Register
                    </a>
                @endif
            @endauth
        </div>
    </nav>


    <!-- HERO -->
    <main class="flex-grow flex flex-col items-center justify-center text-center px-6">

        <h2 class="text-4xl md:text-5xl font-extrabold text-green-800 mb-4">
            Book Your Campus Clinic Appointment Easily
        </h2>

        <p class="text-gray-600 max-w-xl mb-8">
            Schedule medical consultations, manage health records,
            and stay connected with your campus clinic anytime, anywhere.
        </p>

        <div class="space-x-4">
            <a href="{{ route('login') }}"
               class="bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 transition">
                Book Appointment
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="bg-white text-green-700 px-6 py-3 rounded-lg border border-green-600 hover:bg-green-50 transition">
                    Create Account
                </a>
            @endif
        </div>
    </main>


    <!-- FEATURES -->
    <section class="grid md:grid-cols-3 gap-6 px-10 pb-16">

        <!-- Feature 1 -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
            <div class="text-3xl mb-3">📅</div>
            <h3 class="text-xl font-semibold text-green-700 mb-2">Online Booking</h3>
            <p class="text-gray-600 text-sm">
                Students can schedule clinic visits without waiting in line.
            </p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
            <div class="text-3xl mb-3">🩺</div>
            <h3 class="text-xl font-semibold text-green-700 mb-2">Health Records</h3>
            <p class="text-gray-600 text-sm">
                Securely store consultation history and medical information.
            </p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
            <div class="text-3xl mb-3">🔔</div>
            <h3 class="text-xl font-semibold text-green-700 mb-2">Notifications</h3>
            <p class="text-gray-600 text-sm">
                Get reminders for upcoming appointments and clinic updates.
            </p>
        </div>

    </section>


    <!-- FOOTER -->
    <footer class="text-center text-gray-500 text-sm pb-6">
        © {{ date('Y') }} Campus Health Appointment System
    </footer>

</body>
</html>