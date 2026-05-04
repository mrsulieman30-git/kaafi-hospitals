@extends('layouts.app')
@section('title', 'Book an Appointment - KAAFI Hospitals')
@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-bold text-kaafi-navy">Book an Appointment</h1>
                <p class="text-sm text-gray-500 mt-1">Home > Book an Appointment</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1 text-kaafi-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Your information is secure & private
            </div>
        </div>
        
        <livewire:appointment-booking />
        
    </div>
</div>
@endsection