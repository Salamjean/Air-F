@extends('admin.layouts.template')

@section('title', 'Nouvelle Catégorie')

@section('content')
    <div class="container mx-auto">
        <div class="max-w-xl mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Ajouter une Catégorie</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all outline-none"
                            placeholder="Ex: Informatique, Mobilier, etc.">
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-all shadow-sm hover:shadow-md">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection