@extends('admin.layouts.template')

@section('title', 'Gestion des Sites')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Sites</h2>
            <a href="{{ route('admin.sites.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center shadow-md">
                <i class="fas fa-plus mr-2 text-xs"></i> Ajouter un Site
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Succès</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Nom du Site</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Localisation</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($sites as $site)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold">{{ $site->code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $site->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                    {{ $site->location ?? 'Non spécifiée' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.sites.edit', $site) }}"
                                        class="text-blue-600 hover:text-blue-800 transition-colors p-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sites.destroy', $site) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce site ?')">
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
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 rounded-full p-4 mb-4">
                                        <i class="fas fa-map-marked-alt text-gray-300 text-4xl"></i>
                                    </div>
                                    <p>Aucun site enregistré pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sites->links() }}
        </div>
    </div>
@endsection