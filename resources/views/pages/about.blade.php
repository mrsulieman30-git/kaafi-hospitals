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