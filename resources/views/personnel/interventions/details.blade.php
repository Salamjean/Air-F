@extends('personnel.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Navigation -->
        <div class="mb-8">
            <button onclick="history.back()"
                class="inline-flex items-center text-gray-500 hover:text-green-600 transition-colors font-medium group">
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

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                            {{ $intervention->libelle }}
                        </h1>

                        <div class="flex items-center gap-4 text-gray-500">
                            <span class="font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-lg">
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

                        <div class="bg-green-50 rounded-2xl p-5 border border-green-100 flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-200">
                                <i class="far fa-calendar-check text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-xs uppercase font-bold text-green-400 tracking-wider mb-1">Date de
                                    fin</span>
                                <span class="block text-lg font-bold text-gray-900">
                                    {{ $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->translatedFormat('d F Y') : 'À définir' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($intervention->statut === 'traiter' || $intervention->rapport_commentaire || $intervention->rapport_path)
                    <!-- Rapport d'Intervention -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-file-alt text-green-500"></i>
                            Rapport d'Intervention
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-green-600 text-white flex items-center justify-center shadow-lg">
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
                                    class="w-12 h-12 rounded-xl bg-green-600 text-white flex items-center justify-center shadow-lg">
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
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Observations</span>
                                <div
                                    class="bg-green-50/50 p-6 rounded-2xl border border-green-100 text-gray-700 italic leading-relaxed">
                                    "{{ $intervention->rapport_commentaire }}"
                                </div>
                            </div>
                        @endif

                        @if($intervention->rapport_path)
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Document
                                    Transmis</span>
                                @php
                                    $extension = pathinfo($intervention->rapport_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                @if($isImage)
                                    <div class="relative group max-w-md">
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
                                        class="inline-flex items-center gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-md transition-all group">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all shadow-sm">
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
                <!-- Status Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <i class="fas fa-info-circle text-gray-400"></i> Informations
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <span class="text-gray-500 text-sm">Statut</span>
                            <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-bold border uppercase">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <span class="text-gray-500 text-sm">Prestataire</span>
                            <span
                                class="text-gray-900 text-sm font-bold">{{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-500 text-sm">Dernière mise à jour</span>
                            <span
                                class="text-gray-900 text-sm font-bold">{{ $intervention->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($intervention->equipements && $intervention->equipements->count() > 0)
                    <!-- Matériels Utilisés -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-tools text-gray-400"></i>
                            Matériels Utilisés
                        </h3>

                        <div class="space-y-4">
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
                                        <span class="text-xs font-bold text-green-600 uppercase">{{ $equip->pivot->quantity }}
                                            {{ $equip->unit }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection