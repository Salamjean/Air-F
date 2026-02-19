@extends('admin.layouts.template')

@section('title', 'Modifier l\'Consommable')

@section('content')
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.equipements.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Modifier l'Consommable</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('admin.equipements.update', $equipement) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Désignation du
                                    consommable</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $equipement->name) }}"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all"
                                    placeholder="Ex: Projecteur EPSON EB-W06">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="longueur" class="block text-sm font-medium text-gray-700 mb-2">Longueur
                                    </label>
                                    <input type="text" name="longueur" id="longueur"
                                        value="{{ old('longueur', $equipement->longueur) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all"
                                        placeholder="Ex: 10m">
                                </div>
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type
                                        (Optionnel)</label>
                                    <input type="text" name="type" id="type" value="{{ old('type', $equipement->type) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all"
                                        placeholder="Ex: HDMI, Fibre">
                                </div>
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie
                                    (Onglet)</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all bg-white">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $equipement->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="site_id" class="block text-sm font-medium text-gray-700 mb-2">Site de
                                    stockage</label>
                                <select name="site_id" id="site_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all bg-white">
                                    <option value="">Sélectionner un site</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}" {{ old('site_id', $currentSiteId) == $site->id ? 'selected' : '' }}>
                                            {{ $site->name }} ({{ $site->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="stock_quantity"
                                        class="block text-sm font-medium text-gray-700 mb-2">Quantité en stock</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity"
                                        value="{{ old('stock_quantity', $equipement->stock_quantity) }}" min="0" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unité</label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit', $equipement->unit) }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all"
                                        placeholder="Ex: pièce, carton">
                                </div>
                            </div>

                            <div>
                                <label for="stock_min_alert" class="block text-sm font-medium text-gray-700 mb-2">Seuil
                                    d'alerte (Stock bas)</label>
                                <input type="number" name="stock_min_alert" id="stock_min_alert"
                                    value="{{ old('stock_min_alert', $equipement->stock_min_alert) }}" min="0" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image du consommable</label>
                                @if($equipement->image)
                                    <div class="mb-4 relative w-32 h-32">
                                        <img src="{{ asset('storage/' . $equipement->image) }}" alt="{{ $equipement->name }}"
                                            class="w-full h-full object-cover rounded-lg border border-gray-200">
                                        <div class="absolute -top-2 -right-2 bg-blue-600 text-white p-1 rounded-full text-[10px]"
                                            title="Image actuelle">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex items-center justify-center w-full">
                                    <label for="image"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                            <p class="mb-1 text-xs text-gray-500"><span class="font-semibold">Cliquez pour
                                                    remplacer</span></p>
                                            <p class="text-[10px] text-gray-400">PNG, JPG ou JPEG (MAX. 2MB)</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-8 mt-6 border-t border-gray-100">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-10 py-3 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-95">
                            <i class="fas fa-save mr-2"></i> Mettre à jour le consommable
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection