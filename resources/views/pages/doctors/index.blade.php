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