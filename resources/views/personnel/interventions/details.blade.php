@extends('personnel.layouts.template')

@section('title', 'Détails de l\'Intervention - ' . $intervention->code)

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('personnel.dashboard') }}"
                        class="text-gray-500 hover:text-green-600 transition-colors">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                        <a href="{{ route('personnel.interventions.historique') }}"
                            class="text-gray-500 hover:text-green-600 transition-colors">Historique</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                        <span class="text-gray-900 font-bold">Détails #{{ $intervention->reference }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Column: Intervention & Report Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Header Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                        <div>
                            <span
                                class="text-xs font-bold text-green-600 uppercase tracking-widest bg-green-50 px-3 py-1 rounded-full mb-3 inline-block">
                                Intervention {{ $intervention->statut === 'traiter' ? 'Traitée' : 'En cours' }}
                            </span>
                            <h1 class="text-3xl font-extrabold text-gray-900">{{ $intervention->libelle }}</h1>
                            <p class="text-gray-500 mt-2 flex items-center gap-2">
                                <i class="fas fa-barcode text-gray-400"></i>
                                Référence: <span
                                    class="font-mono font-bold text-gray-700">{{ $intervention->reference }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Description de la mission</h3>
                        <p>{{ $intervention->description }}</p>
                    </div>
                </div>

                @if($intervention->statut === 'traiter' || $intervention->rapport_commentaire || $intervention->rapport_path)
                    <!-- Rapport d'Intervention -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-file-alt text-green-500"></i>
                            Votre Rapport d'Intervention
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
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Vos
                                    Observations</span>
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
            </div>

            <!-- Sidebar: Equipment & Status -->
            <div class="space-y-8">
                <!-- Status Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <i class="fas fa-info-circle text-gray-400"></i> Informations
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <span class="text-gray-500 text-sm">Statut</span>
                            <span
                                class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-100 uppercase">
                                {{ $intervention->statut }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-50">
                            <span class="text-gray-500 text-sm">Prestataire</span>
                            <span
                                class="text-gray-900 text-sm font-bold">{{ $intervention->prestataire->name.' '.$intervention->prestataire->prenom ?? 'N/A' }}</span>
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
                @else
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tools text-gray-300 text-xl"></i>
                        </div>
                        <h3 class="text-gray-900 font-bold mb-1">Aucun matériel utilisé</h3>
                        <p class="text-gray-500 text-xs">Aucun équipement n'a été enregistré pour cette intervention.</p>
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
                             <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Prestataire</span>
                             <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center shadow-md">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $intervention->prestataire->name .' '.$intervention->prestataire->prenom ?? 'Non assigné' }}</h4>
                                    <div class="text-sm text-gray-500 space-y-1 mt-1">
                                        <p><i class="fas fa-envelope mr-2 w-4 text-center"></i>{{ $intervention->prestataire->email ?? 'Non assigné' }}</p>
                                        <p><i class="fas fa-phone mr-2 w-4 text-center"></i>{{ $intervention->prestataire->contact ?? 'Non assigné' }}</p>
                                    </div>
                                </div>
                             </div>
                        </div>

                        <div class="w-full h-px bg-gray-100"></div>

                        <!-- Personnel -->
                        <div>
                             <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Personnel Technique</span>
                             @if($intervention->personnels->count() > 0)
                                @foreach($intervention->personnels as $personnel)
                                    <div class="flex items-start gap-4 mb-4 last:mb-0">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-md">
                                            <span class="font-bold text-lg">{{ substr($personnel->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">
                                                {{ $personnel->name }} {{ $personnel->prenom }}
                                                @if($personnel->pivot->is_responsible)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800 ml-2">
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