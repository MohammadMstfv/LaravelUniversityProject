<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>وارد شدید - دانشگاه خوارزمی</title>
        <link rel="icon" href="https://artarch.khu.ac.ir/templates/tmpl_modern01/images/main_logo.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white ">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-6">
            <div class="flex justify-between">
                <p>&copy; 2025 دانشگاه خوارزمی. کلیه حقوق محفوظ است.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-blue-400">تماس با ما</a>
                    <a href="#" class="hover:text-blue-400">حریم خصوصی</a>
                </div>
            </div>
        </div>
    </footer>
</html>
