@extends('layouts.public')

@section('title', $especialista->nombre_completo)

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    <div class="h-32 w-full" style="background-color: {{ $especialista->subArea->area->color ?? '#1e3a8a' }}"></div>

    <div class="px-4 -mt-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-6 text-center">
                <div class="relative inline-block">
                    <img src="{{ $especialista->image_url }}"
                         alt="{{ $especialista->nombre_completo }}"
                         class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-lg mx-auto">
                </div>

                <h2 class="mt-4 text-2xl font-bold text-gray-900 leading-tight">
                    {{ $especialista->nombre_completo }}
                </h2>
                <p class="text-blue-600 font-semibold uppercase tracking-wide text-sm mt-1">
                    {{ $especialista->cargo }}
                </p>
                <p class="text-gray-500 text-sm">
                    {{ $especialista->subArea->nombre }}
                </p>
            </div>

            <div class="flex border-t border-gray-100">
                @if($especialista->celular)
                <a href="https://wa.me/51{{ $especialista->celular }}" class="flex-1 py-4 text-center hover:bg-gray-50 transition border-r border-gray-100">
                    <span class="block text-green-600 font-bold">WhatsApp</span>
                </a>
                @endif
                @if($especialista->correo)
                <a href="mailto:{{ $especialista->correo }}" class="flex-1 py-4 text-center hover:bg-gray-50 transition">
                    <span class="block text-blue-600 font-bold">Correo</span>
                </a>
                @endif
            </div>
        </div>

        <div class="mt-6 space-y-4">
            <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest px-2">Información de Contacto</h3>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">DNI</p>
                        <p class="text-gray-800 font-medium">{{ $especialista->dni }}</p>
                    </div>
                </div>

                @if($especialista->horario_atencion)
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Horario de Atención</p>
                        <p class="text-gray-800 font-medium">{{ $especialista->horario_atencion }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('directorio.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-blue-600 transition font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" /></svg>
                Volver al Directorio
            </a>
        </div>
    </div>
</div>
@endsection
