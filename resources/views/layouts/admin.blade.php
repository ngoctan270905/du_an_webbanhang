<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="flex flex-col min-h-screen">
        @include('admin.blocks.header')

        <div class="flex flex-1">
            <div class="w-56 bg-white shadow-md">
                @include('admin.blocks.sidebar')
            </div>

            <div class="flex-1 flex flex-col overflow-auto">
                <main class="p-0 flex-1">
                    @yield('content')
                </main>

                @include('admin.blocks.footer')
            </div>
        </div>
    </div>

    @yield('js')
</body>
</html>