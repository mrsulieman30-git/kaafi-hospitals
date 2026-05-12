@extends('layouts.app')
@section('title', 'Our Doctors - KAAFI Hospitals')
@section('content')
<div class="relative bg-gradient-to-br from-[#003B73] via-[#0062B8] to-[#003B73] py-12 overflow-hidden shadow-lg">
    <!-- Abstract Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg class="absolute w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-sm uppercase">
            Our <span class="text-blue-300">Doctors</span>
        </h1>
        <p class="mt-3 text-blue-100 text-sm md:text-base font-bold tracking-widest uppercase opacity-80">WORLD-CLASS MEDICAL SPECIALISTS</p>
        <div class="mt-4 flex items-center justify-center gap-2">
            <div class="h-1.5 w-12 bg-white/20 rounded-full"></div>
            <div class="h-1.5 w-4 bg-[#DC3545] rounded-full"></div>
            <div class="h-1.5 w-12 bg-white/20 rounded-full"></div>
        </div>
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