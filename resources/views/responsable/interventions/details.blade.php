@extends('responsable.layouts.template')

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
                                    'envoie' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'confirmer' => 'bg-green-50 text-green-700 border-green-100',
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
                                    'envoie' => 'Envoyée',
                                    'confirmer' => 'Confirmée',
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
                            <span
                                class="text-sm font-mono text-black bg-gray-50 px-3 py-1 rounded-lg border border-gray-100">
                                {{ $intervention->code }}
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

                        <div class="flex flex-wrap items-center gap-4 text-gray-500">
                            <span class="font-semibold text-red-500 bg-red-50 px-3 py-1 rounded-lg">
                                {{ $intervention->reference }}
                            </span>
                            @if($intervention->site)
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg border border-gray-200">
                                    <i class="fas fa-map-marker-alt text-red-500"></i>
                                    {{ $intervention->site->name }} ({{ $intervention->site->code }})
                                </span>
                            @endif
                            <span
                                class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 bg-amber-50 px-3 py-1 rounded-lg border border-amber-200">
                                <i class="fas fa-coins text-amber-600"></i>
                                {{ number_format($intervention->montant, 0, ',', ' ') }} EURO
                            </span>

                            @if($intervention->devis_path)
                                <a href="{{ Storage::url($intervention->devis_path) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-calculator"></i>
                                    Voir Devis ({{ number_format($intervention->montant_estimatif, 0, ',', ' ') }})
                                </a>
                            @endif

                            @if($intervention->facture_path)
                                <a href="{{ Storage::url($intervention->facture_path) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-sm font-bold text-red-600 bg-red-50 px-3 py-1 rounded-lg border border-red-200 hover:bg-red-100 transition-colors">
                                    <i class="fas fa-file-invoice"></i>
                                    Facture Finale
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description & Planning -->
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

                @if($intervention->forfait)
                    <!-- Forfait & Tasks -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                                <i class="fas fa-certificate text-amber-500"></i>
                                Détails du Forfait : {{ $intervention->forfait->name }}
                            </h3>
                            <div class="px-4 py-2 bg-red-50 text-red-600 rounded-xl border border-red-100 font-bold text-sm">
                                {{ number_format($intervention->montant, 0, ',', ' ') }} EURO par agent
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Interventions incluses dans
                                ce forfait :</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($intervention->forfaitTasks as $task)
                                    <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-gray-100">
                                        <div
                                            class="mt-1 w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-check text-[10px]"></i>
                                        </div>
                                        <span class="text-sm text-gray-700 leading-relaxed font-medium">
                                            {{ $task->description }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if($intervention->statut === 'traiter' || $intervention->rapport_commentaire || $intervention->rapport_path)
                    <!-- Rapport d'Intervention -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-file-alt text-red-500"></i>
                            Rapport d'Intervention
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-slate-600 text-white flex items-center justify-center shadow-lg">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-xs uppercase font-bold text-slate-400 tracking-wider mb-1">Début
                                        Réel</span>
                                    <span class="block text-lg font-bold text-gray-900">
                                        {{ $intervention->date_debut_reelle ? \Carbon\Carbon::parse($intervention->date_debut_reelle)->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-slate-600 text-white flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-xs uppercase font-bold text-slate-400 tracking-wider mb-1">Fin
                                        Réelle</span>
                                    <span class="block text-lg font-bold text-gray-900">
                                        {{ $intervention->date_fin_reelle ? \Carbon\Carbon::parse($intervention->date_fin_reelle)->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($intervention->rapport_commentaire)
                            <div class="mb-8">
                                <span
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3 text-center md:text-left">Observations
                                    du Personnel</span>
                                <div
                                    class="bg-red-50/50 p-6 rounded-2xl border border-red-100 text-gray-700 italic leading-relaxed">
                                    "{{ $intervention->rapport_commentaire }}"
                                </div>
                            </div>
                        @endif

                        @if($intervention->rapport_path)
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Document
                                    Joint</span>
                                @php
                                    $extension = pathinfo($intervention->rapport_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                @if($isImage)
                                    <div class="relative group max-w-md mx-auto md:mx-0">
                                        <img src="{{ asset('storage/' . $intervention->rapport_path) }}"
                                            class="rounded-2xl shadow-lg border border-gray-200 cursor-pointer hover:opacity-95 transition-all"
                                            alt="Rapport photo">
                                        <a href="{{ asset('storage/' . $intervention->rapport_path) }}" target="_blank"
                                            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm text-gray-900 p-3 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-all flex items-center gap-2 text-sm font-bold">
                                            <i class="fas fa-search-plus"></i> Agrandir
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ asset('storage/' . $intervention->rapport_path) }}" target="_blank"
                                        class="inline-flex items-center gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-md transition-all group w-full md:w-auto">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-file-pdf text-2xl"></i>
                                        </div>
                                        <div class="text-left">
                                            <span class="block font-bold text-gray-900">Consulter le rapport PDF</span>
                                            <span class="text-xs text-gray-500">Cliquez pour ouvrir dans un nouvel onglet</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                @if($intervention->document_1 || $intervention->document_2 || $intervention->documents->count() > 0)
                    <!-- Documents de Demande -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-paperclip text-blue-500"></i>
                            Documents Joints à la Demande
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($intervention->document_1)
                                @php
                                    $ext1 = pathinfo($intervention->document_1, PATHINFO_EXTENSION);
                                    $isImg1 = in_array(strtolower($ext1), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="bg-blue-50/30 rounded-2xl p-4 border border-blue-100">
                                    <span class="block text-xs uppercase font-bold text-blue-400 tracking-wider mb-3">Document
                                        1</span>
                                    @if($isImg1)
                                        <a href="{{ asset('storage/' . $intervention->document_1) }}" target="_blank"
                                            class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-blue-200">
                                                <img src="{{ asset('storage/' . $intervention->document_1) }}"
                                                    class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div
                                                    class="absolute inset-0 bg-blue-900/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                    <i class="fas fa-search-plus text-xl"></i>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $intervention->document_1) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-blue-100 hover:shadow-md transition-all group">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700 truncate">Voir le document</span>
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
                                    <span class="block text-xs uppercase font-bold text-blue-400 tracking-wider mb-3">Document
                                        2</span>
                                    @if($isImg2)
                                        <a href="{{ asset('storage/' . $intervention->document_2) }}" target="_blank"
                                            class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-blue-200">
                                                <img src="{{ asset('storage/' . $intervention->document_2) }}"
                                                    class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div
                                                    class="absolute inset-0 bg-blue-900/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                    <i class="fas fa-search-plus text-xl"></i>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $intervention->document_2) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-blue-100 hover:shadow-md transition-all group">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700 truncate">Voir le document</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @foreach($intervention->documents as $doc)
                                @php
                                    $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                    $isImg = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="bg-blue-50/30 rounded-2xl p-4 border border-blue-100">
                                    <span class="block text-xs uppercase font-bold text-blue-400 tracking-wider mb-3">Document
                                        Supp.</span>
                                    @if($isImg)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="block group">
                                            <div class="relative rounded-xl overflow-hidden border border-blue-200">
                                                <img src="{{ asset('storage/' . $doc->file_path) }}"
                                                    class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div
                                                    class="absolute inset-0 bg-blue-900/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                    <i class="fas fa-search-plus text-xl"></i>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-white rounded-xl border border-blue-100 hover:shadow-md transition-all group">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                                                <i class="fas fa-file-invoice"></i>
                                            </div>
                                            <div class="flex flex-col truncate">
                                                <span
                                                    class="text-sm font-bold text-gray-700 truncate">{{ $doc->original_name ?? 'Voir le document' }}</span>
                                                <span class="text-[10px] text-gray-400 italic">Document joint</span>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($intervention->equipements->count() > 0)
                    <!-- Matériels Utilisés -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-tools text-gray-400"></i>
                            Matériels Utilisés
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($intervention->equipements as $equip)
                                <div
                                    class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-sm transition-all">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-white border border-slate-200 overflow-hidden flex-shrink-0">
                                        @if($equip->image)
                                            <img src="{{ asset('storage/' . $equip->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fas fa-tools text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-gray-900 text-sm">{{ $equip->name }}</h4>
                                        <span class="text-xs font-bold text-red-600 uppercase">{{ $equip->pivot->quantity }}
                                            {{ $equip->unit }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-8">
                <!-- Action Card (Only for envoie) -->
                @if($intervention->statut === 'envoie')
                    <div class="bg-gray-900 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-gray-800 rounded-full blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2">
                        </div>

                        <h3 class="text-xl font-bold mb-2 relative z-10">Action Requise</h3>
                        <p class="text-gray-400 text-sm mb-8 relative z-10">Confirmez la réception de cet ordre de mission pour
                            ce dossier.</p>

                        <button onclick="confirmValidationDetails('{{ $intervention->id }}', '{{ $intervention->reference }}')"
                            class="w-full py-4 px-6 bg-white text-gray-900 rounded-xl font-bold hover:bg-gray-50 focus:ring-4 focus:ring-gray-700 transition-all shadow-lg flex items-center justify-center gap-3 relative z-10 group-hover:scale-[1.02]">
                            <span>Confirmer réception</span>
                            <i class="fas fa-check-double text-green-500 animate-pulse"></i>
                        </button>
                    </div>
                @endif

                <!-- Actors Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-900 text-lg">Acteurs Impliqués</h3>
                    </div>

                    <div class="p-6 space-y-8">
                        <!-- Prestataire -->
                        <div>
                            <span
                                class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Prestataire</span>
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-md">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        {{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'Non assigné' }}
                                    </h4>
                                    <div class="text-sm text-gray-500 space-y-1 mt-1">
                                        <p><i
                                                class="fas fa-envelope mr-2 w-4 text-center"></i>{{ $intervention->prestataire->email ?? 'Non assigné' }}
                                        </p>
                                        <p><i
                                                class="fas fa-phone mr-2 w-4 text-center"></i>{{ $intervention->prestataire->contact ?? 'Non assigné' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-px bg-gray-100"></div>

                        <!-- Personnel -->
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Personnel
                                Technique</span>
                            @if($intervention->personnels->count() > 0)
                                <div class="space-y-4">
                                    @foreach($intervention->personnels as $personnel)
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-md flex-shrink-0">
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
                                                    <p><i class="fas fa-envelope mr-2 w-4 text-center"></i>{{ $personnel->email }}
                                                    </p>
                                                    <p><i class="fas fa-phone mr-2 w-4 text-center"></i>{{ $personnel->contact }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmValidationDetails(id, reference) {
            Swal.fire({
                title: 'Confirmer la réception ?',
                text: `L'intervention ${reference} passera au statut "Confirmée".`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/responsable/interventions/${id}/confirm`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection