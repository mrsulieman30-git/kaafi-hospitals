<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Hospital",
      "name": "KAAFI Hospitals",
      "image": "{{ asset('images/og-image.jpg') }}",
      "@@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+252 61 0000000",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Main Street",
        "addressLocality": "Mogadishu",
        "addressCountry": "SO"
      }
    }
    </script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Tailwind CSS (CDN for quick dev, will use Vite for prod) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kaafi: {
                            navy: '#003B73',
                            blue: '#0062B8',
                            red: '#DC3545',
                            green: '#28A745',
                            light: '#E8F4FD',
                            gray: '#F8F9FA'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 bg-white">

    <!-- Top Bar -->
    <div class="bg-[#003B73] text-white text-xs py-2 hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center max-w-7xl">
            <div class="flex items-center space-x-6">
                <span class="flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Wadajir District, Mogadishu, Somalia</span>
                <span class="flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +252 615 666 999</span>
                <span class="flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> info@kaafihospitals.so</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/about" class="hover:text-gray-300 border-r border-blue-700 pr-4">About Us</a>
                <a href="#" class="hover:text-gray-300 border-r border-blue-700 pr-4">Careers</a>
                <a href="/blog" class="hover:text-gray-300 border-r border-blue-700 pr-4">News & Updates</a>
                <!-- Language Switcher Placeholder -->
                <div class="relative">
                    <button class="flex items-center hover:text-gray-300">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg> English <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center max-w-7xl">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <div class="flex items-center">
                    <!-- Custom SVG representing the Kaafi Logo from the image -->
                    <svg class="w-12 h-12 text-[#DC3545]" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M 50 10 C 25 10 10 30 10 50 C 10 70 25 90 50 90 C 75 90 90 75 90 60 L 75 60 C 75 70 65 75 50 75 C 35 75 25 60 25 50 C 25 40 35 25 50 25 C 65 25 75 35 75 45 L 90 45 C 90 25 75 10 50 10 Z" fill="#DC3545"/>
                        <path d="M 50 20 C 30 20 18 35 18 50 C 18 65 30 80 50 80" stroke="#003B73" stroke-width="6" fill="none"/>
                    </svg>
                    <div class="ml-2 flex flex-col justify-center leading-none">
                        <div class="flex items-baseline">
                            <span class="text-[#DC3545] font-bold text-2xl tracking-tight">KAAFI</span>
                            <span class="text-[#003B73] font-bold text-xl tracking-tight ml-1">HOSPITALS</span>
                        </div>
                        <span class="text-[#0062B8] font-semibold text-[0.65rem] tracking-widest mt-1">KEEPING YOU WELL</span>
                    </div>
                </div>
            </a>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden text-gray-600 hover:text-[#003B73] focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop Nav -->
            <nav class="hidden xl:flex space-x-8 items-center text-center">
                <a href="/" class="flex flex-col items-center group {{ request()->is('/') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-sm font-bold leading-tight">Home</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Hoyga</span>
                </a>
                <a href="/about" class="flex flex-col items-center group {{ request()->is('about') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="text-sm font-bold leading-tight">About Us</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Naga Ku Saabsan</span>
                </a>
                <a href="/departments" class="flex flex-col items-center group {{ request()->is('departments') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="text-sm font-bold leading-tight">Services</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Adeegyada</span>
                </a>
                <a href="/departments" class="flex flex-col items-center group text-[#003B73] hover:text-[#0062B8] transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="text-sm font-bold leading-tight">Departments</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Waaxyaha</span>
                </a>
                <a href="/doctors" class="flex flex-col items-center group {{ request()->is('doctors') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-sm font-bold leading-tight">Doctors</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Dhakhaatiirta</span>
                </a>
                <a href="#" class="flex flex-col items-center group text-[#003B73] hover:text-[#0062B8] transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="text-sm font-bold leading-tight">Patients & Visitors</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Booqdayaasha</span>
                </a>
                <a href="/contact" class="flex flex-col items-center group {{ request()->is('contact') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="text-sm font-bold leading-tight">Contact Us</span>
                    <span class="text-[0.65rem] text-gray-500 font-medium">Nala Soo Xiriir</span>
                </a>
                
                <a href="/appointment" class="bg-[#DC3545] hover:bg-red-700 text-white px-5 py-2 rounded-md font-semibold transition shadow-md flex items-center h-full">
                    <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold leading-tight">Book Appointment</span>
                        <span class="text-[0.7rem] text-red-100 font-medium">Qabso Ballan</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="xl:hidden absolute top-full left-0 w-full bg-white shadow-lg border-t border-gray-100" style="display: none;">
            <div class="px-4 py-2 space-y-1 pb-6">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-[#003B73] hover:text-[#0062B8] hover:bg-gray-50">Home / Hoyga</a>
                <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium text-[#003B73] hover:text-[#0062B8] hover:bg-gray-50">About Us / Naga Ku Saabsan</a>
                <a href="/departments" class="block px-3 py-2 rounded-md text-base font-medium text-[#003B73] hover:text-[#0062B8] hover:bg-gray-50">Departments / Waaxyaha</a>
                <a href="/doctors" class="block px-3 py-2 rounded-md text-base font-medium text-[#003B73] hover:text-[#0062B8] hover:bg-gray-50">Doctors / Dhakhaatiirta</a>
                <a href="/contact" class="block px-3 py-2 rounded-md text-base font-medium text-[#003B73] hover:text-[#0062B8] hover:bg-gray-50">Contact Us / Nala Soo Xiriir</a>
                <a href="/appointment" class="block mt-4 text-center bg-[#DC3545] hover:bg-red-700 text-white px-5 py-3 rounded-md font-bold transition shadow-md">Book Appointment</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-kaafi-navy text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-2xl font-bold mb-4">KAAFI <span class="text-blue-300">HOSPITALS</span></h3>
                    <p class="text-blue-100 mb-6">Keeping You Well. We are committed to providing compassionate, high-quality healthcare for you and your family.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-kaafi-blue transition">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-kaafi-blue transition">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">Quick Links</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><a href="/" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Home</a></li>
                        <li><a href="/about" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> About Us</a></li>
                        <li><a href="/departments" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Departments</a></li>
                        <li><a href="/doctors" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Our Doctors</a></li>
                        <li><a href="/blog" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Blog & News</a></li>
                        <li><a href="/contact" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">Departments</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><a href="/departments/cardiology" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Cardiology</a></li>
                        <li><a href="/departments/neurology" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Neurology</a></li>
                        <li><a href="/departments/pediatrics" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Pediatrics</a></li>
                        <li><a href="/departments/orthopedics" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Orthopedics</a></li>
                        <li><a href="/departments/laboratory" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> Laboratory</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">Contact Info</h4>
                    <ul class="space-y-4 text-blue-100">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-1 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Wadajir District,<br>Mogadishu, Somalia</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+252 615 666 999</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@kaafihospitals.so</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-blue-900 pt-6 text-center text-sm text-blue-200 flex flex-col md:flex-row justify-between items-center">
                <p>&copy; {{ date('Y') }} KAAFI Hospitals. All rights reserved.</p>
                <div class="mt-4 md:mt-0 space-x-4">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AI Chatbot Placeholder (Livewire Component will go here) -->
    <livewire:ai-chat-widget />
    
    @livewireScripts
</body>
</html>
