@extends('admin.layouts.template')

@section('title', 'Gestion des Catégories d\'Equipements')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Catégories d'Equipements (Onglets)</h2>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouvelle Catégorie
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Ajouté par</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Date d'ajout</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $category->creator->name ?? 'N/A' }} {{ $category->creator->prenom ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="text-blue-600 hover:text-blue-800 transition-colors p-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cela supprimera également tous les équipements associés.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-2"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Aucune catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection