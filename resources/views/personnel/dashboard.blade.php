@extends('personnel.layouts.template')

@section('title', 'Tableau de bord Personnel')

@section('header_title', 'Tableau de bord')

@section('content')
    @section('content')
        <div class="container mx-auto px-6 py-10">
            <!-- Welcome Section -->
            <div class="mb-10 animate-fade-in">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Bonjour, <span
                        class="text-green-600">{{ Auth::guard('user')->user()->prenom }}</span> !</h1>
                <p class="text-lg text-gray-600 mt-2">Voici un aperçu de vos activités et de vos interventions.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Total Tasks -->
                <div class="relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div
                        class="relative bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 bg-blue-50 rounded-2xl text-blue-600">
                                <i class="fas fa-tasks text-2xl"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['total'] }}</h3>
                            <span class="text-gray-500 font-medium">Interventions</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-2">Toutes les tâches reçues</p>
                    </div>
                </div>

                <!-- Completed Tasks -->
                <div class="relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div
                        class="relative bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 bg-green-50 rounded-2xl text-green-600">
                                <i class="fas fa-check-double text-2xl"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Réussites</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['completed'] }}</h3>
                            <span class="text-gray-500 font-medium">Traitées</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-2">Interventions finalisées</p>
                    </div>
                </div>

                <!-- Pending Tasks -->
                <div class="relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div
                        class="relative bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-4 bg-orange-50 rounded-2xl text-orange-600">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Priorité</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['pending'] }}</h3>
                            <span class="text-gray-500 font-medium">En attente</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-2">À traiter prochainement</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 mb-10">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Interventions Récentes</h3>
                        <p class="text-sm text-gray-500 mt-1">Vos dernières mises à jour et assignations.</p>
                    </div>
                    <a href="{{ route('personnel.interventions.index') }}"
                        class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center gap-2 transition-colors">
                        Tout voir <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    Référence</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    Libellé</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    Prestataire</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Statut
                                </th>
                                <th class="px-8 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentInterventions as $intervention)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $intervention->reference }}</div>
                                        <div
                                            class="text-[10px] text-gray-400 font-mono mt-0.5 bg-gray-100 px-1.5 py-0.5 rounded w-fit capitalize">
                                            #{{ $intervention->code }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-semibold text-gray-800 line-clamp-1 truncate max-w-xs">
                                            {{ $intervention->libelle }}</div>
                                        <div class="text-xs text-gray-400 truncate max-w-xs mt-0.5">
                                            {{ Str::limit($intervention->description, 50) }}</div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs font-bold border border-purple-100">
                                                <i class="fas fa-building text-[10px]"></i>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-700">{{ $intervention->prestataire->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'en_attente' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'label' => 'En attente', 'icon' => 'fa-clock'],
                                                'valider' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'label' => 'Validée', 'icon' => 'fa-check'],
                                                'envoyer' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'label' => 'Envoyée', 'icon' => 'fa-paper-plane'],
                                                'confirmer' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'label' => 'Confirmée', 'icon' => 'fa-play'],
                                                'traiter' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'label' => 'Traitée', 'icon' => 'fa-check-double'],
                                                'traiter_incorrect' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'label' => 'Incomplète', 'icon' => 'fa-exclamation-triangle'],
                                                'rejeter' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'label' => 'Rejetée', 'icon' => 'fa-times-circle'],
                                                'devis' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-600', 'label' => 'Devis', 'icon' => 'fa-file-invoice-dollar'],
                                                'accord' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-600', 'label' => 'Accordée', 'icon' => 'fa-handshake'],
                                                'finance' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'label' => 'Financée', 'icon' => 'fa-wallet'],
                                                'finaliser' => ['bg' => 'bg-gray-900', 'text' => 'text-white', 'label' => 'Terminée', 'icon' => 'fa-flag-checkered'],
                                            ];
                                            $config = $statusConfig[$intervention->statut] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'label' => $intervention->statut, 'icon' => 'fa-info-circle'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg {{ $config['bg'] }} {{ $config['text'] }} text-[10px] font-bold uppercase tracking-wider">
                                            <i class="fas {{ $config['icon'] }} text-[8px]"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right whitespace-nowrap">
                                        <a href="{{ route('personnel.interventions.show', $intervention->id) }}"
                                            class="inline-flex items-center justify-center p-2.5 bg-gray-50 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all duration-300">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-6">
                                                <i class="fas fa-clipboard-check text-2xl text-gray-200"></i>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900">Aucune activité récente</h4>
                                            <p class="text-sm text-gray-500 max-w-xs mx-auto mt-2">Dès qu'une intervention vous sera
                                                assignée ou traitée, elle apparaîtra ici.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }
        </style>
    @endsection
@endsection