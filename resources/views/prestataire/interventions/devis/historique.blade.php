@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Historique des Devis</h1>
                <p class="text-lg text-gray-600 mt-2">Consultez les devis que vous avez déjà soumis.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('prestataire.interventions.devis.historique') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence, code...">
                </form>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($interventions as $intervention)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col h-full overflow-hidden group">
                    <!-- Card Header with Status-based Gradient Strip -->
                    @php
                        $statusColors = [
                            'devis' => 'from-blue-500 to-indigo-500',
                            'accord' => 'from-emerald-500 to-teal-500',
                            'facture' => 'from-purple-500 to-pink-500',
                            'payer' => 'from-green-500 to-emerald-600',
                            'rejeter' => 'from-red-500 to-orange-500',
                        ];
                        $statusLabels = [
                            'devis' => 'En attente d\'accord',
                            'accord' => 'Accord donné',
                            'facture' => 'Facture soumise',
                            'payer' => 'Payée',
                            'rejeter' => 'Rejetée',
                        ];
                        $gradientClass = $statusColors[$intervention->statut] ?? 'from-gray-500 to-slate-500';
                        $statusLabel = $statusLabels[$intervention->statut] ?? ucfirst($intervention->statut);
                    @endphp
                    <div class="h-2 bg-gradient-to-r {{ $gradientClass }}"></div>

                    <div class="p-6 flex-grow flex flex-col">
                        <!-- Top Info (Ref & Status) -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $intervention->reference }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500 mt-1">
                                    <i class="fas fa-map-marker-alt text-red-500"></i>
                                    {{ $intervention->site->name ?? 'N/A' }}
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 bg-white text-gray-700 text-[10px] font-bold uppercase tracking-wide rounded-full border border-gray-100 flex items-center gap-1 shadow-sm">
                                <i class="fas fa-info-circle text-blue-500"></i> {{ $statusLabel }}
                            </span>
                        </div>

                        <!-- Main Content (Libelle) -->
                        <div class="mb-4 flex-grow">
                            <h4 class="text-md font-semibold text-gray-800 mb-2 line-clamp-1"
                                title="{{ $intervention->libelle }}">
                                {{ $intervention->libelle }}
                            </h4>
                            <p class="text-gray-500 text-sm line-clamp-2 md:line-clamp-3">
                                {{ Str::limit($intervention->description, 100) }}
                            </p>
                        </div>

                        <!-- Devis Info -->
                        <div class="mb-4 p-3 bg-blue-50/50 rounded-lg border border-blue-100/50">
                             <div class="flex justify-between items-center mb-1">
                                <span class="text-[10px] text-gray-500 uppercase font-bold">Estimation Devis</span>
                                <span class="text-sm font-bold text-gray-900">{{ number_format($intervention->montant_estimatif, 0, ',', ' ') }} EURO</span>
                            </div>
                            @if($intervention->montant != $intervention->montant_estimatif && $intervention->montant > 0)
                                <div class="flex justify-between items-center mt-2 pt-2 border-t border-blue-100/50">
                                    <span class="text-[10px] text-emerald-600 uppercase font-bold">Montant Final</span>
                                    <span class="text-sm font-bold text-emerald-700">{{ number_format($intervention->montant, 0, ',', ' ') }} EURO</span>
                                </div>
                            @endif
                        </div>


                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100/50">
                            <!-- Dates -->
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 uppercase font-bold mb-1 tracking-tighter">Début</span>
                                <span class="text-xs font-bold text-gray-800 flex items-center gap-2">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/y') }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 uppercase font-bold mb-1 tracking-tighter">Fin Prévue</span>
                                <span class="text-xs font-bold text-gray-800 flex items-center gap-2">
                                    <i class="far fa-calendar-check text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions Footer -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-auto">
                            <a href="{{ route('prestataire.interventions.details', $intervention->id) }}"
                                class="flex-1 text-center py-2 px-4 bg-gray-900 text-white text-[10px] font-bold rounded-lg shadow-sm hover:bg-gray-800 transition-all uppercase tracking-wider">
                                Détails
                            </a>
                            @if($intervention->devis_path)
                                <a href="{{ Storage::url($intervention->devis_path) }}" target="_blank"
                                    class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100"
                                    title="Voir le Devis">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                            @if($intervention->facture_path)
                                <a href="{{ Storage::url($intervention->facture_path) }}" target="_blank"
                                    class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100"
                                    title="Voir la Facture">
                                    <i class="fas fa-invoice"></i>
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 lg:col-span-2 xl:col-span-3">
                    <div
                        class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-folder-open text-4xl text-gray-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Aucun devis dans l'historique</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Vos devis soumis apparaîtront ici.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection