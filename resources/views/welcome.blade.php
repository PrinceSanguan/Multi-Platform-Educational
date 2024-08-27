@php
    use App\Models\Setting;

    $siteName = Setting::get('site_name', 'Default Site Name');
    $siteLogo = Setting::get('site_logo');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise Farms Community School</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .hero {
            background-image: url('https://via.placeholder.com/1920x1080');
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
            @if ($siteLogo)
            <img src="{{ asset('storage/' . $siteLogo) }}" alt="Site Logo">
        @else
            <p>No logo uploaded.</p>
        @endif
        </a>
        <button class="block md:hidden">
            <span class="navbar-toggler-icon"></span>
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
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('filament.admin.auth.login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
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
            <h1 class="text-5xl font-bold mt-2">Paradise Farms Community School</h1>
            <a href="#" class="btn-custom mt-6">Learn More</a>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="about py-16 text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-semibold mb-8">About Us</h2>
            <p class="mb-8 text-lg">The interactive visual aid could include features such as gamification, simulations, and multimedia content to make learning more enjoyable and effective. The performance analysis component could provide teachers with valuable insights into student progress, helping them identify areas where students need extra support.</p>
            <a href="#" class="btn-custom mb-8">Enroll Now</a>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="mb-4">
                    <img src="https://via.placeholder.com/150" alt="Classroom 1" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="https://via.placeholder.com/150" alt="Classroom 2" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="https://via.placeholder.com/150" alt="Classroom 3" class="w-full h-auto rounded-lg">
                </div>
                <div class="mb-4">
                    <img src="https://via.placeholder.com/150" alt="Classroom 4" class="w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-16 bg-white text-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="https://via.placeholder.com/150" alt="Logo" class="h-20 mb-4">
                    <h3 class="text-lg font-semibold mb-2">PFC School</h3>
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
                    <p>✉️ prcschool@schoo.com.ph</p>
                    <p>📍 hh</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>