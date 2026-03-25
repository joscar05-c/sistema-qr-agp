<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg text-center border-2 border-blue-600">
        <h1 class="text-xl font-bold uppercase">{{ $subArea->nombre }}</h1>
        <p class="text-gray-500 mb-4">{{ $subArea->area->nombre }}</p>

        <div class="inline-block p-4 bg-white border-2 border-gray-900 rounded-lg">
            {!! QrCode::size(250)->generate($url) !!}
        </div>

        <p class="mt-4 text-sm font-medium">Escanee para evaluar nuestra atención</p>
        <button onclick="window.print()" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-lg print:hidden">
            Imprimir Código
        </button>
    </div>
</body>
