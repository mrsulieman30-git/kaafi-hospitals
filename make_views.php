<?php

$views = [
    'resources/views/pages/about.blade.php' => <<<'EOT'
@extends('layouts.app')
@section('title', 'About Us - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">About KAAFI Hospitals</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Providing compassionate, high-quality healthcare for you and your family.</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl font-bold text-kaafi-navy mb-6">Our Mission & Vision</h2>
            <p class="text-gray-600 mb-4">At KAAFI Hospitals, our mission is to deliver exceptional medical care to the people of Somalia. We believe in putting patients first and ensuring that everyone has access to advanced medical technology and expert doctors.</p>
            <p class="text-gray-600 mb-6">Our vision is to be the leading healthcare provider in East Africa, known for our clinical excellence, compassionate care, and state-of-the-art facilities.</p>
            <ul class="space-y-3">
                <li class="flex items-center text-kaafi-blue"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Patient-Centered Care</li>
                <li class="flex items-center text-kaafi-blue"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Advanced Medical Technology</li>
                <li class="flex items-center text-kaafi-blue"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Highly Qualified Specialists</li>
                <li class="flex items-center text-kaafi-blue"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 24/7 Emergency Services</li>
            </ul>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1538108149393-cebb47ac7924?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Hospital Building" class="rounded-xl shadow-xl">
        </div>
    </div>
</div>
@endsection
EOT,

    'resources/views/pages/departments/index.blade.php' => <<<'EOT'
@extends('layouts.app')
@section('title', 'Departments - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">Our Departments</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Comprehensive healthcare services under one roof.</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    @php
        $departments = \App\Models\Department::where('is_active', true)->get();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($departments as $dept)
        <div class="bg-white rounded-xl shadow-md p-8 text-center hover:shadow-lg transition">
            <div class="w-16 h-16 mx-auto bg-blue-100 text-kaafi-blue rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $dept->name }}</h3>
            <p class="text-gray-600 mb-6">{{ $dept->description }}</p>
            <a href="#" class="text-kaafi-blue font-semibold hover:text-blue-800">Learn More &rarr;</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
EOT,

    'resources/views/pages/doctors/index.blade.php' => <<<'EOT'
@extends('layouts.app')
@section('title', 'Our Doctors - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">Our Expert Doctors</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Meet our team of experienced medical professionals.</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($doctors as $doctor)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="h-64 overflow-hidden relative">
                <img class="w-full h-full object-cover object-top" src="https://i.pravatar.cc/300?img={{ $loop->iteration + 10 }}" alt="{{ $doctor->name }}">
                <div class="absolute bottom-0 w-full bg-gradient-to-t from-kaafi-navy to-transparent h-1/2 opacity-70"></div>
                <div class="absolute bottom-4 left-4 text-white font-semibold">
                    {{ $doctor->department->name ?? 'Specialist' }}
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900">{{ $doctor->name }}</h3>
                <p class="text-kaafi-blue font-medium mt-1">{{ $doctor->title }}</p>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                    <a href="#" class="text-kaafi-blue hover:text-blue-800 font-semibold text-sm">View Profile</a>
                    <a href="/appointment" class="bg-kaafi-green text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition">Book</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
EOT,

    'resources/views/pages/blog/index.blade.php' => <<<'EOT'
@extends('layouts.app')
@section('title', 'News & Blog - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">Health News & Blog</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Stay updated with the latest medical research and hospital news.</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    <div class="text-center py-20 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
        <p class="mt-1 text-sm text-gray-500">Check back later for new articles and updates.</p>
    </div>
</div>
@endsection
EOT,

    'resources/views/pages/contact.blade.php' => <<<'EOT'
@extends('layouts.app')
@section('title', 'Contact Us - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">Contact Us</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">We are here to assist you 24/7.</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-12">
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-2xl font-bold text-kaafi-navy mb-6">Send us a message</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-kaafi-blue focus:border-kaafi-blue">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-kaafi-blue focus:border-kaafi-blue">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium">Message</label>
                    <textarea rows="4" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-kaafi-blue focus:border-kaafi-blue"></textarea>
                </div>
                <button type="button" class="bg-kaafi-blue hover:bg-blue-700 text-white font-bold py-3 px-6 rounded w-full transition">Send Message</button>
            </form>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-kaafi-navy mb-6">Our Location</h2>
            <div class="bg-gray-200 h-64 rounded-xl mb-6 overflow-hidden relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127641.51786524385!2d45.2343940562629!3d2.059437978713291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3d58425955ce6b53%3A0xbb100b211bb12239!2sMogadishu%2C%20Somalia!5e0!3m2!1sen!2sus!4v1714658000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="space-y-4">
                <p class="flex items-start text-gray-700">
                    <svg class="w-6 h-6 mr-3 text-kaafi-blue flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Wadajir District, Mogadishu, Somalia</span>
                </p>
                <p class="flex items-center text-gray-700">
                    <svg class="w-6 h-6 mr-3 text-kaafi-blue flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>+252 615 666 999</span>
                </p>
                <p class="flex items-center text-gray-700">
                    <svg class="w-6 h-6 mr-3 text-kaafi-blue flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>info@kaafihospitals.so</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
EOT,
];

foreach ($views as $file => $content) {
    if (!is_dir(dirname(__DIR__ . '/' . $file))) {
        mkdir(dirname(__DIR__ . '/' . $file), 0777, true);
    }
    file_put_contents(__DIR__ . '/' . $file, $content);
}
echo "Views updated successfully.\n";
