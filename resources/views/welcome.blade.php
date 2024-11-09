<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .hero {
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("{{ asset('storage/buset.png') }}");
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
        }

        .btn-custom {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="fixed z-50 flex items-center justify-between w-full p-5 bg-transparent">
        <a href="#" class="flex items-center">
            <img src="{{ asset('storage/logo.png') }}" alt="Site Logo" class="h-12">
        </a>
        <button id="menu-toggle" class="block text-white md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div id="nav-links" class="items-center hidden space-x-6 md:flex">
            <a class="text-white hover:text-gray-300" href="#home">Home</a>
            <a class="text-white hover:text-gray-300" href="#about">About Us</a>
            <a class="text-white hover:text-gray-300" href="#contact">Contact Us</a>

            <!-- Blade Logic for Authentication -->
            <div id="header-right" class="flex items-center md:space-x-6">
                <div class="flex space-x-5">
                    @if (Route::has('filament.admin.auth.login'))
                        <nav class="flex justify-end flex-1 -mx-3">
                            @auth
                                <a href="{{ route('filament.admin.pages.dashboard') }}"
                                    class="btn-custom">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('filament.admin.auth.login') }}"
                                    class="btn-custom">
                                    LOGIN
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="text-white hover:text-gray-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
            <!-- End Blade Logic -->
        </div>
    </nav>

   <div id="home" class="flex flex-col items-start justify-center px-4 sm:px-12 hero">
        <h1 class="mb-2 text-3xl font-bold sm:text-4xl md:text-5xl">WELCOME TO</h1>
        <h2 class="max-w-2xl mb-6 text-4xl font-bold sm:text-5xl md:text-6xl">Goldenville Elementary School</h2>
        <a href="#about" class="text-lg btn-custom">LEARN MORE</a>
    </div>

    <!-- About Us Section -->
    <div id="about" class="py-16 text-center text-white bg-green-600">
        <div class="container px-4 mx-auto">
            <h2 class="mb-8 text-3xl font-semibold sm:text-4xl">About Us</h2>
            <p class="max-w-4xl mx-auto mb-8 text-lg">The interactive visual aid could include features such as gamification, simulations, and multimedia content to make learning more enjoyable and effective.</p>
            <a href="#" class="mb-8 text-lg btn-custom">Enroll Now</a>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-4">
               <div class="mb-4">
                    <img src="{{ asset('storage/classroom1.jpg') }}" class="w-full h-auto max-w-xs mx-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="{{ asset('storage/classroom2.jpg') }}" class="w-full h-auto max-w-xs mx-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="{{ asset('storage/classroom3.jpg') }}" class="w-full h-auto max-w-xs mx-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="{{ asset('storage/classroom4.jpg') }}" class="w-full h-auto max-w-xs mx-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="py-10 text-gray-800 bg-gray-100">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-4">
                <div class="text-center">
                    <img src="{{ asset('storage/logo.png') }}" alt="Site Logo" class="h-12 mx-auto">
                    <p class="mt-2 text-sm">It is a long established fact that a reader will be distracted by the readable content of a page.</p>
                </div>
                <div>
                    <h3 class="mb-2 text-lg font-semibold text-center">Featured Links</h3>
                    <p><a href="#home" class="text-black hover:underline">Home</a></p>
                    <p><a href="#about" class="text-black hover:underline">About Us</a></p>
                    <p><a href="#contact" class="text-black hover:underline">Contact Us</a></p>
                    <p><a href="#" class="text-black hover:underline">Login</a></p>
                </div>
                <div>
                    <h3 class="mb-2 text-lg font-semibold text-center">Social Media Links</h3>
                    <p><a href="#" class="text-black hover:underline">Facebook</a></p>
                    <p><a href="#" class="text-black hover:underline">Instagram</a></p>
                    <p><a href="#" class="text-black hover:underline">YouTube</a></p>
                    <p><a href="#" class="text-black hover:underline">Twitter</a></p>
                </div>
                <div class="text-center">
                    <h3 class="mb-2 text-lg font-semibold">Contact Us</h3>
                    <p>📞 +632139432871</p>
                    <p>✉️ goves@gmail.com</p>
                    <p>📍 Phase 4B, Minuyan Proper, City of San Jose Delmonte Bulacan</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Navbar Toggle -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const navLinks = document.getElementById('nav-links');
            navLinks.classList.toggle('hidden');
        });
    </script>
</body>
</html>
