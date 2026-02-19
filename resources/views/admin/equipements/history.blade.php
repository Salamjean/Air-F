@extends('admin.layouts.template')

@section('title', 'Historique d\'Utilisation des Équipements')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Historique d'Utilisation</h2>
                <p class="text-gray-500 mt-1">Suivi détaillé des équipements utilisés lors des interventions.</p>
            </div>
            <a href="{{ route('admin.equipements.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                <i class="fas fa-list mr-2"></i> Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <form action="{{ route('admin.equipements.history') }}" method="GET"
                class="p-6 flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <label for="search" class="block text-xs font-bold text-gray-500 uppercase mb-2">Rechercher</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" id="search" value="{{ $search }}"
                            placeholder="Par prestataire, personnel ou code d'intervention..."
                            class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm transition-all outline-none bg-gray-50">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2.5 px-6 rounded-lg transition-all shadow-sm">
                        Filtrer
                    </button>
                    @if($search)
                        <a href="{{ route('admin.equipements.history') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-2.5 px-6 rounded-lg transition-all">
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Équipement</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                                Quantité</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                                Auteur / Prestataire</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Détails /
                                Intervention</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($usageHistory as $movement)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $movement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($movement->type === 'recharge')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            RECHARGE
                                        </span>
                                    @elseif($movement->type === 'usage')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            UTILISATION
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                            AJUSTEMENT
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($movement->equipement->image)
                                            <img src="{{ asset('storage/' . $movement->equipement->image) }}"
                                                class="w-8 h-8 rounded-md object-cover mr-3 border border-gray-100 shadow-sm">
                                        @else
                                            <div
                                                class="w-8 h-8 rounded-md bg-gray-100 flex items-center justify-center mr-3 border border-gray-100 shadow-sm">
                                                <i class="fas fa-tools text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                        <span class="font-bold text-gray-900 text-sm">{{ $movement->equipement->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="font-bold text-sm {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                        {{ $movement->equipement->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-7 h-7 rounded-full {{ $movement->type === 'usage' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-[10px]"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ $movement->user ? $movement->user->name . ' ' . $movement->user->prenom : 'Système' }}
                                            @if($movement->intervention && $movement->intervention->prestataire)
                                                <br><small
                                                    class="text-gray-400 text-[10px] uppercase">({{ $movement->intervention->prestataire->name }})</small>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($movement->intervention)
                                        <a href="{{ route('admin.interventions.show', $movement->intervention->id) }}"
                                            class="text-red-600 hover:text-red-800 font-bold text-sm inline-flex items-center">
                                            <i class="fas fa-external-link-alt mr-1.5 text-[10px]"></i>
                                            {{ $movement->intervention->code }}
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-500 italic">{{ $movement->description ?? 'N/A' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                    <i class="fas fa-history text-4xl mb-3 block text-gray-200"></i>
                                    Aucun historique pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($usageHistory->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $usageHistory->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection