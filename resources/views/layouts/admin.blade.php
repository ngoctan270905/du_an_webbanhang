<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
</head>
<body class="bg-gray-100 text-gray-900">

   <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('admin.blocks.sidebar')

        <!-- Nội dung chính -->
        <div id="main-content" class="main-content flex-1 flex flex-col overflow-y-auto md:ml-[230px]">
            <!-- Header -->
            @include('admin.blocks.header')

            <!-- Main content -->
            <main class="p-0 flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin.blocks.footer')
        </div>
    </div>

    @yield('js')
</body>
</html>