<!DOCTYPE html>
<html lang="es" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1e3a8a">
    <title>@yield('title', 'Directorio Institucional - AGP')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Ocultar scrollbar para un look más "App" */
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800">

    <div class="mx-auto max-w-md min-h-screen flex flex-col bg-white shadow-2xl relative overflow-hidden">

        <header class="bg-blue-900 text-white sticky top-0 z-50 shadow-md">
            <div class="px-4 py-4 flex items-center justify-between">
                @hasSection('back_button')
                    @yield('back_button')
                @else
                    <div class="w-8"></div>
                @endif

                <h1 class="text-lg font-semibold text-center truncate flex-1 px-2">
                    @yield('header_title', 'Directorio Institucional')
                </h1>

                <a href="{{ url('/') }}" class="w-8 flex justify-end text-blue-200 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-blue-400 to-blue-600"></div>
        </header>

        <main class="flex-1 overflow-y-auto bg-slate-50 pb-8">
            @yield('content')
        </main>

        <footer class="bg-slate-100 border-t border-slate-200 py-4 text-center pb-safe">
            <p class="text-xs text-slate-500 font-medium">
                © {{ date('Y') }} Área de Gestión Pedagógica<br>
                <span class="text-slate-400">Todos los derechos reservados</span>
            </p>
        </footer>

    </div>

    @stack('scripts')
</body>

</html>
