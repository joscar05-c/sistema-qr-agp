@extends('layouts.public')

@section('title', 'Directorio de Áreas')
@section('header_title', 'Sede Principal')

@section('content')
<div class="p-4 space-y-6">

    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input type="text" placeholder="Buscar especialista, oficina o trámite..."
               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm shadow-sm transition">
    </div>

    <div>
        <h2 class="text-lg font-bold text-gray-800 mb-3 px-1">Guía por Pisos</h2>

        <div class="space-y-3">
            @foreach($areas as $area)
                <div x-data="{ expanded: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                    <button @click="expanded = ! expanded" class="w-full text-left px-4 py-4 flex items-center justify-between focus:outline-none focus:bg-slate-50 active:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background-color: {{ $area->color ?? '#1e3a8a' }}">
                                <span class="font-bold text-sm">{{ $area->siglas }}</span>
                            </div>

                            <div>
                                <h3 class="font-bold text-gray-900 leading-tight">{{ $area->nombre }}</h3>
                                @if($area->piso)
                                    <p class="text-sm text-blue-600 font-medium">{{ $area->piso }}</p>
                                @endif
                            </div>
                        </div>

                        <svg :class="{'rotate-180': expanded}" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="expanded" x-collapse x-cloak>
                        <div class="bg-slate-50 px-4 py-3 border-t border-gray-100 space-y-2">
                            @forelse($area->subAreas as $subArea)
                                <a href="{{ route('directorio.subarea', $subArea->id) }}" class="block bg-white p-3 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 hover:shadow-md transition">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $subArea->nombre }}</p>
                                            @if($subArea->oficina)
                                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                    {{ $subArea->oficina }}
                                                </p>
                                            @endif
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-500 italic py-2 text-center">No hay oficinas registradas aún.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
