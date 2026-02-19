@extends('admin.layouts.template')

@section('title', 'Modifier le Site')

@section('content')
    <div class="container mx-auto max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.sites.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center text-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
            </a>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">Modifier le Site : {{ $site->name }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.sites.update', $site) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-8 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom du Site <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $site->name) }}"
                            class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-gray-400"
                            placeholder="Ex: Site Central AF">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-bold text-gray-700 mb-2">Code du Site <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" required value="{{ old('code', $site->code) }}"
                            class="w-full px-4 py-3 rounded-xl border @error('code') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-gray-400 uppercase"
                            placeholder="Ex: SITE-001">
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Localisation (Optionnel)</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $site->location) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-gray-400"
                            placeholder="Ex: Abidjan, Plateau">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-md focus:ring-4 focus:ring-blue-100">
                        Mettre à jour le Site
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
