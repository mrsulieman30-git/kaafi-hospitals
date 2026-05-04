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