@extends('layouts.app')

@section('title', 'Contact Us - Carttelo')

@section('content')
    @php
        $fb = \App\Models\Setting::get('social_facebook');
        $ig = \App\Models\Setting::get('social_instagram');
        $em = \App\Models\Setting::get('social_email');
    @endphp

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900">Contact Us</h1>
                <p class="mt-4 text-lg text-gray-600">
                    Have questions? We'd love to hear from you.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Get in Touch</h2>
                    
                    @if($fb || $ig || $em)
                        <div class="space-y-4">
                            @if($fb)
                                <a href="{{ $fb }}" target="_blank" rel="noopener" 
                                   class="flex items-center gap-4 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 transition group">
                                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 group-hover:text-blue-700">Facebook</p>
                                        <p class="text-sm text-gray-500">Message us on Facebook</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif

                            @if($ig)
                                <a href="{{ $ig }}" target="_blank" rel="noopener" 
                                   class="flex items-center gap-4 p-4 rounded-xl bg-pink-50 hover:bg-pink-100 transition group">
                                    <div class="w-12 h-12 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 group-hover:text-pink-700">Instagram</p>
                                        <p class="text-sm text-gray-500">Follow us on Instagram</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif

                            @if($em)
                                <a href="mailto:{{ $em }}" 
                                   class="flex items-center gap-4 p-4 rounded-xl bg-green-50 hover:bg-green-100 transition group">
                                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 group-hover:text-green-700">Email</p>
                                        <p class="text-sm text-gray-500">{{ $em }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">Contact information will be available soon.</p>
                        </div>
                    @endif
                </div>

                <!-- Quick Info -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Hours</h3>
                        <div class="space-y-2 text-gray-600">
                            <p class="flex justify-between">
                                <span>Saturday - Thursday</span>
                                <span class="font-medium">9:00 AM - 9:00 PM</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Friday</span>
                                <span class="font-medium">Closed</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-600 rounded-2xl shadow-sm p-8 text-white">
                        <h3 class="text-lg font-semibold mb-2">Track Your Order</h3>
                        <p class="text-blue-100 mb-4">Already placed an order? Check its status here.</p>
                        <a href="{{ route('track-order') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Track Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
