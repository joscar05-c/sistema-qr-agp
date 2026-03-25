@extends('layouts.public')

@section('title', 'Evaluar atención - ' . $especialista->nombre_completo)

@section('content')
<div class="p-6 max-w-md mx-auto">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 text-center">

        <div class="relative inline-block mb-4">
            <img src="{{ $especialista->image_url }}"
                 alt="{{ $especialista->nombre_completo }}"
                 class="w-24 h-24 rounded-2xl object-cover border-4 border-blue-50 shadow-sm mx-auto">
        </div>

        <h2 class="text-xl font-bold text-gray-900">{{ $especialista->nombre_completo }}</h2>
        <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-2">{{ $especialista->cargo }}</p>
        <p class="text-gray-500 text-sm mb-8 italic">¿Cómo calificaría la atención recibida hoy?</p>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 font-medium animate-bounce">
                {{ session('success') }}
            </div>
            <a href="{{ route('directorio.subarea', $especialista->sub_area_id) }}"
               class="inline-block bg-slate-900 text-white px-6 py-3 rounded-xl font-bold transition active:scale-95">
                Volver a la oficina
            </a>
        @else
            <form action="{{ route('directorio.votar', $especialista->id) }}" method="POST" x-data="{ rating: 0, hover: 0 }">
                @csrf

                <div class="flex justify-center gap-2 mb-10">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                @click="rating = {{ $i }}"
                                @mouseenter="hover = {{ $i }}"
                                @mouseleave="hover = 0"
                                class="transition-all duration-200 transform hover:scale-125 focus:outline-none">
                            <svg class="w-12 h-12"
                                 :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-200'"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>

                <input type="hidden" name="estrellas" :value="rating">

                <button type="submit"
                        x-show="rating > 0"
                        x-transition
                        class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition active:scale-95">
                    Enviar mi calificación
                </button>

                <p x-show="rating == 0" class="text-gray-400 text-xs font-medium">Seleccione una estrella para continuar</p>
            </form>
        @endif
    </div>
</div>
@endsection
