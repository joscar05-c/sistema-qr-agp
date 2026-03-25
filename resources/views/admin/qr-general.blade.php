<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>QR General - Directorio AGP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-3xl shadow-2xl text-center max-w-sm border-2 border-blue-600">
        <h1 class="text-2xl font-black text-blue-900 mb-2">DIRECTORIO DIGITAL</h1>
        <p class="text-gray-500 mb-6 font-medium">AGP - Rioja</p>

        <div class="bg-white p-4 inline-block border-4 border-slate-900 rounded-xl">
            {!! QrCode::size(250)->margin(1)->generate(config('app.url')) !!}
        </div>

        <div class="mt-6 space-y-2">
            <p class="text-lg font-bold text-slate-800 uppercase tracking-tighter">Escanea este código</p>
            <p class="text-sm text-gray-500 italic">Encuentra oficinas y especialistas al instante</p>
        </div>

        <button onclick="window.print()"
            class="mt-8 bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition print:hidden">
            Imprimir QR
        </button>
    </div>
</body>

</html>
