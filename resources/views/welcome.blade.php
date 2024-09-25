@php
    use App\Models\Setting;

    $siteName = Setting::get('site_name', 'Paradise Farms Community School');
    $siteLogo = Setting::get('site_logo');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero {
            background-image: url('{{ asset('storage/image.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero h1 {
            font-size: 3em;
            margin: 0;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow fixed w-full flex items-center justify-between p-5 z-50">
        <a href="#" class="flex items-center">
                <img src="{{ asset('storage/logo.png') }}" alt="Site Logo" class="h-12">
        </a>
        <button class="block md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div class="hidden md:flex items-center space-x-6">
            <a class="text-black hover:text-gray-700" href="#">Home</a>
            <a class="text-black hover:text-gray-700" href="#">About Us</a>
            <a class="text-black hover:text-gray-700" href="#">Contact Us</a>

            <!-- Blade Logic for Authentication -->
            <div id="header-right" class="flex items-center md:space-x-6">
                <div class="flex space-x-5">
                    @if (Route::has('filament.admin.auth.login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ route('filament.admin.pages.dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('filament.admin.auth.login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
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
    <div class="hero">
        <div>
            <h1 class="text-5xl font-bold">WELCOME TO</h1>
            <h1 class="text-5xl font-bold mt-2">{{ $siteName }}</h1>
            <a href="#" class="btn-custom mt-6 inline-block">Learn More</a>
        </div>
    </div>

<!-- About Us Section -->
<div class="about py-16 text-center bg-green-200">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-semibold mb-8 text-green-900">About Us</h2>
        <p class="mb-8 text-lg text-green-800">The interactive visual aid could include features such as gamification, simulations, and multimedia content to make learning more enjoyable and effective. The performance analysis component could provide teachers with valuable insights into student progress, helping them identify areas where students need extra support.</p>
        <a href="#" class="btn-custom mb-8 inline-block">Enroll Now</a>
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
    <footer class="footer py-16 bg-gray-100 text-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-20 mb-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $siteName }}</h3>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Featured Links</h3>
                    <p><a href="#" class="text-black hover:underline">Home</a></p>
                    <p><a href="#" class="text-black hover:underline">About Us</a></p>
                    <p><a href="#" class="text-black hover:underline">Contact Us</a></p>
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

</body>
</html>