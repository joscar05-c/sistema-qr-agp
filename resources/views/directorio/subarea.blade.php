@extends('layouts.public')

@section('title', $subArea->nombre . ' - ' . ($subArea->area->siglas ?? 'AGP'))
@section('header_title', 'Detalle de Oficina')

@section('back_button')
    <a href="{{ route('directorio.index') }}" class="w-8 flex items-center text-blue-200 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
@endsection

@section('content')
    <div class="p-4 space-y-6">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1"
                style="background-color: {{ $subArea->area->color ?? '#1e3a8a' }}"></div>

            <h2 class="text-xl font-bold text-gray-900">{{ $subArea->nombre }}</h2>
            <p class="text-blue-600 font-medium mt-1">{{ $subArea->area->nombre }} ({{ $subArea->area->siglas }})</p>

            @if ($subArea->oficina || $subArea->area->piso)
                <div
                    class="mt-4 inline-flex items-center gap-2 bg-slate-100 px-4 py-2 rounded-full text-sm text-gray-700 font-medium">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>
                        {{ $subArea->area->piso ? $subArea->area->piso . ' - ' : '' }}
                        {{ $subArea->oficina ?? 'Ubicación general' }}
                    </span>
                </div>
            @endif
        </div>

        <div>
            <h3 class="text-sm uppercase tracking-wider font-bold text-gray-500 mb-4 px-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Miembros del equipo ({{ $subArea->especialistas->count() }})
            </h3>

            <div class="space-y-3">
                @forelse($subArea->especialistas as $especialista)
                    <div
                        class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 hover:border-blue-200 transition relative overflow-hidden">
                        <div class="flex items-center gap-4">

                            <a href="{{ url('/v/' . $especialista->slug) }}"
                                class="flex flex-1 items-center gap-4 min-w-0 group">
                                <div class="relative shrink-0">
                                    <img src="{{ $especialista->image_url }}" alt="{{ $especialista->nombre_completo }}"
                                        class="w-14 h-14 rounded-full object-cover border border-gray-200 group-hover:border-blue-400 transition">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition truncate">
                                        {{ $especialista->nombre_completo }}</h4>
                                    <p class="text-xs text-gray-500 truncate mb-1">
                                        {{ $especialista->cargo ?? 'Especialista' }}</p>

                                    <div class="flex items-center text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= round($especialista->promedio_rating ?? 0) ? 'fill-current' : 'text-gray-200' }}"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @endfor
                                        <span
                                            class="ml-1.5 text-[10px] text-gray-400 font-medium">({{ $especialista->numero_votos ?? 0 }})</span>
                                    </div>
                                </div>
                            </a>

                            <div class="shrink-0">
                                <a href="{{ route('directorio.evaluar', $especialista->slug) }}"
                                    class="inline-flex items-center justify-center bg-blue-50 text-blue-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-100">
                                    Evaluar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-xl border border-gray-200 border-dashed">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gray-500">No hay especialistas registrados o visibles.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
