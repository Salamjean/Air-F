@extends('prestataire.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Navigation -->
        <div class="mb-8">
            <button onclick="history.back()"
                class="inline-flex items-center text-gray-500 hover:text-gray-800 transition-colors font-medium group">
                <div
                    class="w-8 h-8 rounded-full bg-white shadow-sm border border-gray-200 flex items-center justify-center mr-3 group-hover:border-gray-300 group-hover:shadow-md transition-all">
                    <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
                </div>
                Retour aux interventions
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Header Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <i class="fas fa-file-signature text-9xl"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            @php
                                $statusClasses = [
                                    'en_attente' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'valider' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'envoyer' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'traiter' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'facture' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    'accord' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                    'finance' => 'bg-teal-50 text-teal-700 border-teal-100',
                                    'payer' => 'bg-green-50 text-green-700 border-green-100',
                                    'terminer' => 'bg-green-50 text-green-700 border-green-100',
                                    'rejeter' => 'bg-red-50 text-red-700 border-red-100',
                                ];
                                $statusLabels = [
                                    'en_attente' => 'En attente',
                                    'valider' => 'Validée',
                                    'envoyer' => 'Envoyée',
                                    'traiter' => 'En cours',
                                    'facture' => 'Facturée (Attente finalisation)',
                                    'accord' => 'Accordée (Facture finale soumise)',
                                    'finance' => 'En attente de paiement (Finance)',
                                    'payer' => 'Paiement Validé',
                                    'terminer' => 'Terminée',
                                    'rejeter' => 'Rejetée',
                                ];
                                $statusClass = $statusClasses[$intervention->statut] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                                $statusLabel = $statusLabels[$intervention->statut] ?? ucfirst($intervention->statut);
                            @endphp
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full border text-sm font-bold uppercase tracking-wider {{ $statusClass }}">
                                <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <!-- PROMINENT PAYMENT DATE -->
                        @if($intervention->date_paiement_prevue)
                            <div
                                class="mb-8 flex flex-col items-center justify-center p-8 bg-green-50 rounded-3xl border border-green-100 shadow-sm relative overflow-hidden group">
                                <div
                                    class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                                    <i class="fas fa-calendar-check text-6xl text-green-600"></i>
                                </div>
                                <span
                                    class="text-xs font-bold text-green-600 uppercase tracking-widest mb-3 relative z-10">Paiement
                                    fixé pour le</span>
                                <div class="flex items-center gap-4 relative z-10">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-200">
                                        <i class="fas fa-calendar-alt text-2xl"></i>
                                    </div>
                                    <span class="text-3xl md:text-5xl font-black text-green-800 tracking-tight">
                                        {{ \Carbon\Carbon::parse($intervention->date_paiement_prevue)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                @if($intervention->delai_paiement)
                                    <div
                                        class="mt-4 px-4 py-1.5 bg-white/50 backdrop-blur-sm rounded-full border border-green-200 text-sm font-bold text-green-700 relative z-10">
                                        <i class="fas fa-hourglass-half mr-2 text-green-500"></i>
                                        Délai : {{ $intervention->delai_paiement }} jours
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- BILLING EVOLUTION STEPPER -->
                        @if(in_array($intervention->statut, ['facture', 'accord', 'finance', 'payer']))
                            <div class="mb-10 bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 text-center">
                                    Évolution du processus de règlement</h4>
                                <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0 px-4">
                                    <!-- Step 1: Facturée -->
                                    <div class="flex flex-col items-center flex-1">
                                        <div
                                            class="w-10 h-10 rounded-full {{ in_array($intervention->statut, ['facture', 'accord', 'finance', 'payer']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <span
                                            class="text-[10px] mt-2 font-bold {{ in_array($intervention->statut, ['facture', 'accord', 'finance', 'payer']) ? 'text-green-600' : 'text-gray-400' }} uppercase">Facturation</span>
                                        <span class="text-[8px] text-gray-400 font-medium whitespace-nowrap">Rapport
                                            validé</span>
                                    </div>

                                    <div
                                        class="hidden md:block w-full h-1 {{ in_array($intervention->statut, ['accord', 'finance', 'payer']) ? 'bg-green-500' : 'bg-gray-200' }} -mt-6">
                                    </div>

                                    <!-- Step 2: Accordée -->
                                    <div class="flex flex-col items-center flex-1">
                                        <div
                                            class="w-10 h-10 rounded-full {{ in_array($intervention->statut, ['accord', 'finance', 'payer']) ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-400' }} {{ $intervention->statut == 'accord' ? 'ring-4 ring-indigo-100 animate-pulse' : '' }} flex items-center justify-center shadow-lg transition-all">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <span
                                            class="text-[10px] mt-2 font-bold {{ in_array($intervention->statut, ['accord', 'finance', 'payer']) ? 'text-indigo-600' : 'text-gray-400' }} uppercase text-center">Accord
                                            Admin</span>
                                        <span class="text-[8px] text-gray-400 font-medium whitespace-nowrap">Facture
                                            soumise</span>
                                    </div>

                                    <div
                                        class="hidden md:block w-full h-1 {{ in_array($intervention->statut, ['finance', 'payer']) ? 'bg-indigo-500' : 'bg-gray-200' }} -mt-6">
                                    </div>

                                    <!-- Step 3: Finance -->
                                    <div class="flex flex-col items-center flex-1">
                                        <div
                                            class="w-10 h-10 rounded-full {{ in_array($intervention->statut, ['finance', 'payer']) ? 'bg-teal-500 text-white' : 'bg-gray-200 text-gray-400' }} {{ $intervention->statut == 'finance' ? 'ring-4 ring-teal-100 animate-pulse' : '' }} flex items-center justify-center shadow-lg transition-all">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <span
                                            class="text-[10px] mt-2 font-bold {{ in_array($intervention->statut, ['finance', 'payer']) ? 'text-teal-600' : 'text-gray-400' }} uppercase text-center">En
                                            Finance</span>
                                        <span class="text-[8px] text-gray-400 font-medium whitespace-nowrap">En attente
                                            paiement</span>
                                    </div>

                                    <div
                                        class="hidden md:block w-full h-1 {{ in_array($intervention->statut, ['payer']) ? 'bg-teal-500' : 'bg-gray-200' }} -mt-6">
                                    </div>

                                    <!-- Step 4: Payée -->
                                    <div class="flex flex-col items-center flex-1">
                                        <div
                                            class="w-10 h-10 rounded-full {{ in_array($intervention->statut, ['payer']) ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-400' }} {{ $intervention->statut == 'payer' ? 'ring-4 ring-green-100' : '' }} flex items-center justify-center shadow-lg transition-all">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                        <span
                                            class="text-[10px] mt-2 font-bold {{ in_array($intervention->statut, ['payer']) ? 'text-green-700' : 'text-gray-400' }} uppercase text-center">Payé</span>
                                        <span
                                            class="text-[8px] text-gray-400 font-medium whitespace-nowrap underline italic">{{ $intervention->date_paiement_prevue ? \Carbon\Carbon::parse($intervention->date_paiement_prevue)->format('d/m/Y') : 'À planifier' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                            {{ $intervention->libelle }}
                        </h1>

                        @if ($intervention->statut === 'finance')
                            <div
                                class="mb-4 p-4 bg-teal-50 border border-teal-100 rounded-2xl flex items-center gap-4 animate-pulse">
                                <div
                                    class="w-10 h-10 rounded-xl bg-teal-500 text-white flex items-center justify-center shadow-sm">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-teal-800">Dossier en attente chez le service financier</p>
                                    <p class="text-xs text-teal-600">Soumis par l'administration le
                                        {{ \Carbon\Carbon::parse($intervention->date_soumission_finance)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @elseif($intervention->statut === 'payer' && $intervention->date_paiement_prevue)
                            <div class="mb-4 p-4 bg-green-50 border border-green-100 rounded-2xl flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-green-500 text-white flex items-center justify-center shadow-sm">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-green-800">Paiement validé par le service financier</p>
                                    <p class="text-xs text-green-600">Le paiement est prévu pour le : <span
                                            class="font-bold underline">{{ \Carbon\Carbon::parse($intervention->date_paiement_prevue)->format('d F Y') }}</span>
                                        (Délai : {{ $intervention->delai_paiement }} jours)</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-4 text-gray-500">
                            <span class="font-semibold text-red-500 bg-red-50 px-3 py-1 rounded-lg">
                                {{ $intervention->reference }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description & Dates -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <i class="fas fa-align-left text-gray-400"></i>
                        Description & Planning
                    </h3>

                    <div class="prose max-w-none text-gray-600 mb-8 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        {{ $intervention->description }}
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                                <i class="far fa-calendar-alt text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-xs uppercase font-bold text-blue-400 tracking-wider mb-1">Date de
                                    début</span>
                                <span class="block text-lg font-bold text-gray-900">
                                    {{ $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->translatedFormat('d F Y') : 'À définir' }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-2xl p-5 border border-indigo-100 flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                                <i class="far fa-calendar-check text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-xs uppercase font-bold text-indigo-400 tracking-wider mb-1">Date de
                                    fin</span>
                                <span class="block text-lg font-bold text-gray-900">
                                    {{ $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->translatedFormat('d F Y') : 'À définir' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations Financières (Devis et Facture) -->
                @if ($intervention->montant_estimatif > 0 || $intervention->devis_path || $intervention->montant > 0 || $intervention->facture_path)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-file-invoice-dollar text-gray-400"></i>
                            Informations Financières
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Section Devis (Estimation) -->
                            @if ($intervention->montant_estimatif > 0 || $intervention->devis_path)
                                <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100/50">
                                    <span class="block text-[10px] uppercase font-bold text-blue-400 tracking-wider mb-3">Estimation
                                        Initiale (Devis)</span>
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-md">
                                            <i class="fas fa-calculator text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="block text-lg font-bold text-gray-900">
                                                {{ number_format($intervention->montant_estimatif, 0, ',', ' ') }} EURO
                                            </span>
                                            @if ($intervention->devis_path)
                                                <a href="{{ Storage::url($intervention->devis_path) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 mt-1">
                                                    <i class="fas fa-download"></i> Voir le devis
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Section Facture Finale -->
                            @if ($intervention->facture_path || ($intervention->statut === 'accord' || $intervention->statut === 'payer'))
                                <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-100/50">
                                    <span
                                        class="block text-[10px] uppercase font-bold text-emerald-400 tracking-wider mb-3">Facturation
                                        Finale</span>
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md">
                                            <i class="fas fa-file-invoice-dollar text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="block text-lg font-bold text-gray-900">
                                                {{ number_format($intervention->montant, 0, ',', ' ') }} EURO
                                            </span>
                                            @if ($intervention->facture_path)
                                                <a href="{{ Storage::url($intervention->facture_path) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 mt-1">
                                                    <i class="fas fa-download"></i> Voir la facture
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif($intervention->montant > 0 && !$intervention->facture_path && $intervention->statut === 'devis')
                                <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-100/50 opacity-60">
                                    <span class="block text-[10px] uppercase font-bold text-emerald-400 tracking-wider mb-2">Montant
                                        Final Prévu</span>
                                    <span class="block text-lg font-bold text-gray-900">
                                        {{ number_format($intervention->montant, 0, ',', ' ') }} EURO
                                    </span>
                                    <span class="text-[10px] text-gray-500 italic">En attente de facture finale</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Documents Joints Section -->
                @if($intervention->document_1 || $intervention->document_2 || $intervention->documents->count() > 0)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-paperclip text-blue-500"></i>
                            Documents Joints pour l'intervention
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if($intervention->document_1)
                                @php
                                    $ext1 = pathinfo($intervention->document_1, PATHINFO_EXTENSION);
                                    $isImg1 = in_array(strtolower($ext1), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="bg-blue-50/30 rounded-2xl p-4 border border-blue-100">
                                    <span class="block text-[10px] uppercase font-bold text-blue-400 tracking-wider mb-2">Document
                                        1</span>
                                    @if($isImg1)
                                        <a href="{{ asset('storage/' . $intervention->document_1) }}" target="_blank"
                                            class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-blue-200 aspect-video">
                                                <img src="{{ asset('storage/' . $intervention->document_1) }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $intervention->document_1) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-blue-100 hover:shadow-md transition-all group">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                            <span class="text-sm font-bold text-gray-700 truncate">Document 1</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if($intervention->document_2)
                                @php
                                    $ext2 = pathinfo($intervention->document_2, PATHINFO_EXTENSION);
                                    $isImg2 = in_array(strtolower($ext2), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="bg-blue-50/30 rounded-2xl p-4 border border-blue-100">
                                    <span class="block text-[10px] uppercase font-bold text-blue-400 tracking-wider mb-2">Document
                                        2</span>
                                    @if($isImg2)
                                        <a href="{{ asset('storage/' . $intervention->document_2) }}" target="_blank"
                                            class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-blue-200 aspect-video">
                                                <img src="{{ asset('storage/' . $intervention->document_2) }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $intervention->document_2) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-blue-100 hover:shadow-md transition-all group">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                            <span class="text-sm font-bold text-gray-700 truncate">Document 2</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @foreach($intervention->documents as $doc)
                                @php
                                    $ext = strtolower($doc->file_type);
                                    $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $icon = in_array($ext, ['xls', 'xlsx']) ? 'file-excel text-green-600' : (in_array($ext, ['pdf']) ? 'file-pdf text-red-500' : 'file-alt text-blue-500');
                                @endphp
                                <div class="bg-indigo-50/30 rounded-2xl p-4 border border-indigo-100">
                                    <span class="block text-[10px] uppercase font-bold text-indigo-400 tracking-wider mb-2">Document
                                        Joint</span>
                                    @if($isImg)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-indigo-200 aspect-video">
                                                <img src="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-indigo-100 hover:shadow-md transition-all group">
                                            <i class="fas fa-{{ $icon }}"></i>
                                            <span class="text-sm font-bold text-gray-700 truncate"
                                                title="{{ $doc->original_name }}">{{ $doc->original_name }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-8">
                <!-- Site Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-red-500"></i> Localisation
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-500 text-sm">Site</span>
                            <span class="text-gray-900 text-sm font-bold">{{ $intervention->site->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actors Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-900 text-lg">Acteurs Impliqués</h3>
                    </div>

                    <div class="p-6 space-y-8">
                        <!-- Personnel -->
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Personnel
                                Technique</span>
                            @if($intervention->personnels->count() > 0)
                                @foreach($intervention->personnels as $personnel)
                                    <div class="flex items-start gap-4 mb-4 last:mb-0">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-md">
                                            <span class="font-bold text-lg">{{ substr($personnel->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">
                                                {{ $personnel->name }} {{ $personnel->prenom }}
                                                @if($personnel->pivot->is_responsible)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800 ml-2">
                                                        <i class="fas fa-crown mr-1"></i> Chef d'équipe
                                                    </span>
                                                @endif
                                            </h4>
                                            <div class="text-sm text-gray-500 space-y-1 mt-1">
                                                <p><i class="fas fa-envelope mr-2 w-4 text-center"></i>{{ $personnel->email }}</p>
                                                <p><i class="fas fa-phone mr-2 w-4 text-center"></i>{{ $personnel->contact }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="p-4 bg-yellow-50 text-yellow-800 rounded-xl border border-yellow-100 flex items-center gap-3">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                    <span class="font-medium text-sm">Non assigné</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection