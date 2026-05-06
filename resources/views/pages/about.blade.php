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

@php
    // Fetch settings and fallback to Bosaso if admin hasn't set it yet
    $settings = \App\Models\SiteSetting::first();
    $coords = $settings->location_coordinates ?? ['lat' => 11.2829, 'lng' => 49.1816];
    $lat = $coords['lat'];
    $lng = $coords['lng'];
@endphp

<!-- Beautiful Interactive Map Section -->
<div class="container mx-auto px-4 pb-24">
    <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,59,115,0.08)] border border-gray-100 overflow-hidden">
        
        <!-- Header -->
        <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#0062B8] shadow-sm">
                    <x-heroicon-s-map-pin class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-2xl font-black text-[#003B73]">Visit KAAFI Hospitals</h3>
                    <p class="text-gray-500 font-medium">Find us using the interactive map below.</p>
                </div>
            </div>
            
            <!-- Get Directions Button -->
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lng }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-[#0062B8] text-white font-bold py-3 px-6 rounded-xl shadow-md hover:bg-[#003B73] hover:shadow-lg transition-all active:scale-95">
                <x-heroicon-o-navigation class="w-5 h-5" /> Get Directions
            </a>
        </div>

        <!-- The Actual Map -->
        <div class="w-full h-[400px] md:h-[500px] bg-gray-100 relative">
            <iframe 
                src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=16&output=embed" 
                class="absolute inset-0 w-full h-full border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
@endsection