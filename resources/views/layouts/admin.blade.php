<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Carttelo</title>

    <!-- Favicon -->
    @php $adminFavicon = \App\Models\Setting::get('site_favicon'); @endphp
    @if($adminFavicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $adminFavicon) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }
        .btn-danger {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    @php $adminLogo = \App\Models\Setting::get('site_logo'); @endphp
                    @if($adminLogo)
                        <img src="{{ asset('storage/' . $adminLogo) }}" alt="Carttelo" class="h-8 w-auto">
                    @else
                        <span class="text-2xl font-bold">Carttelo Admin</span>
                    @endif
                </a>
            </div>

            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Orders
                    </span>
                </a>

                <a href="{{ route('admin.settings.index') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.settings.index') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Delivery Charges
                    </span>
                </a>

                <a href="{{ route('admin.settings.logo') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.settings.logo') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Logo Settings
                    </span>
                </a>

                <a href="{{ route('admin.settings.social') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.settings.social') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Social Media
                    </span>
                </a>

                <a href="{{ route('admin.admins.index') }}" 
                   class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.admins.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Admin Users
                    </span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-6">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-400 hover:text-white">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
