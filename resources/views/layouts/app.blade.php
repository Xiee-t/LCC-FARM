<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('layouts.header')
</head>
<body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">
    @include('layouts.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    @stack('scripts')
</body>
</html>
