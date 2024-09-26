@php
    use App\Models\Setting;

    $siteName = Setting::get('site_name', 'Paradise Farms Community School');
    $siteLogo = Setting::get('site_logo');
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('storage/image.jpg') }}');
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
    <nav class="bg-transparent fixed w-full flex items-center justify-between p-5 z-50">
        <a href="#" class="flex items-center">
            <img src="{{ asset('storage/logo.png') }}" alt="Site Logo" class="h-12">
        </a>
        <button class="block md:hidden text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div class="hidden md:flex items-center space-x-6">
            <a class="text-white hover:text-gray-300" href="#home">Home</a>
            <a class="text-white hover:text-gray-300" href="#about">About Us</a>
            <a class="text-white hover:text-gray-300" href="#contact">Contact Us</a>

            <!-- Blade Logic for Authentication -->
            <div id="header-right" class="flex items-center md:space-x-6">
                <div class="flex space-x-5">
                    @if (Route::has('filament.admin.auth.login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
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

    <!-- Hero Section -->
    <div id="home" class="hero flex flex-col justify-center items-start px-12">
        <h1 class="text-3xl font-bold mb-2">WELCOME TO</h1>
        <h2 class="text-5xl font-bold mb-6 max-w-2xl">{{ $siteName }}</h2>
        <a href="#about" class="btn-custom text-lg">LEARN MORE</a>
    </div>

    <!-- About Us Section -->
    <div id="about" class="py-16 text-center bg-green-600 text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-semibold mb-8">About Us</h2>
            <p class="mb-8 text-lg max-w-4xl mx-auto">The interactive visual aid could include features such as gamification, simulations, and multimedia content to make learning more enjoyable and effective. The performance analysis component could provide teachers with valuable insights into student progress, helping them identify areas where students need extra support.</p>
            <a href="#" class="btn-custom mb-8 text-lg">Enroll Now</a>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="mb-4">
                    <img src="/placeholder.svg?height=150&width=150" alt="Classroom 1" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="/placeholder.svg?height=150&width=150" alt="Classroom 2" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="/placeholder.svg?height=150&width=150" alt="Classroom 3" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="/placeholder.svg?height=150&width=150" alt="Classroom 4" class="w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="py-16 bg-gray-100 text-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('storage/logo.png') }}" alt="Site Logo" class="h-12">
                    <h3 class="text-lg font-semibold mb-2">{{ $siteName }}</h3>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Featured Links</h3>
                    <p><a href="#home" class="text-black hover:underline">Home</a></p>
                    <p><a href="#about" class="text-black hover:underline">About Us</a></p>
                    <p><a href="#contact" class="text-black hover:underline">Contact Us</a></p>
                    <p><a href="#" class="text-black hover:underline">Login</a></p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Social Media Links</h3>
                    <p><a href="#" class="text-black hover:underline">Facebook</a></p>
                    <p><a href="#" class="text-black hover:underline">Instagram</a></p>
                    <p><a href="#" class="text-black hover:underline">YouTube</a></p>
                    <p><a href="#" class="text-black hover:underline">Twitter</a></p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                    <p>📞 +632139432871</p>
                    <p>✉️ prcschool@school.com.ph</p>
                    <p>📍 School Address</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>