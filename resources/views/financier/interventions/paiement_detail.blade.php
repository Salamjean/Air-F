@extends('financier.layouts.template')

@section('title', 'Détails du Paiement')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('financier.interventions.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des paiements
            </a>
        </div>

        <!-- Large Amount Display -->
        <div class="bg-white rounded-3xl shadow-xl border border-red-50 p-10 text-center relative overflow-hidden mb-8">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
            <div class="relative z-10">
                <span class="text-sm font-bold text-red-600 uppercase tracking-widest mb-4 block">Montant à
                    Régler</span>
                <h2 class="text-6xl md:text-8xl font-black text-gray-900 tracking-tighter">
                    {{ number_format($intervention->montant, 0, ',', ' ') }}
                    <span class="text-3xl md:text-5xl text-red-600 ml-2">EURO</span>
                </h2>
            </div>
        </div>

        <!-- Progress Header Card -->
        @if(in_array($intervention->statut, ['facture', 'accord', 'finance', 'receptionne', 'attente_paiement', 'payer']))
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden mb-8">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class="fas fa-tasks text-9xl"></i>
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
                                'finance' => 'bg-teal-100 text-teal-800 border-teal-200',
                                'receptionne' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'attente_paiement' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
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
                                'finance' => 'Transmis à la Finance',
                                'receptionne' => 'Réceptionné par Finance',
                                'attente_paiement' => 'Attente de règlement',
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

                    <!-- BILLING EVOLUTION STEPPER -->
                    <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 text-center">
                            Évolution du processus de règlement</h4>
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0 px-4">
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-8 h-8 rounded-full {{ in_array($intervention->statut, ['facture', 'accord', 'finance', 'receptionne', 'attente_paiement', 'payer']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-file-invoice text-xs"></i>
                                </div>
                                <span
                                    class="text-[8px] mt-2 font-bold {{ in_array($intervention->statut, ['facture', 'accord', 'finance', 'receptionne', 'attente_paiement', 'payer']) ? 'text-green-600' : 'text-gray-400' }} uppercase text-center">Facturation</span>
                            </div>
                            <div
                                class="hidden md:block w-full h-0.5 {{ in_array($intervention->statut, ['accord', 'finance', 'receptionne', 'attente_paiement', 'payer']) ? 'bg-green-500' : 'bg-gray-200' }} -mt-5">
                            </div>
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-8 h-8 rounded-full {{ in_array($intervention->statut, ['accord', 'finance', 'receptionne', 'attente_paiement', 'payer']) ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-file-signature text-xs"></i>
                                </div>
                                <span
                                    class="text-[8px] mt-2 font-bold {{ in_array($intervention->statut, ['accord', 'finance', 'receptionne', 'attente_paiement', 'payer']) ? 'text-indigo-600' : 'text-gray-400' }} uppercase text-center">Accord
                                    Admin</span>
                            </div>
                            <div
                                class="hidden md:block w-full h-0.5 {{ in_array($intervention->statut, ['finance', 'receptionne', 'attente_paiement', 'payer']) ? 'bg-indigo-500' : 'bg-gray-200' }} -mt-5">
                            </div>
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-8 h-8 rounded-full {{ in_array($intervention->statut, ['receptionne', 'attente_paiement', 'payer']) ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-hand-holding-usd text-xs"></i>
                                </div>
                                <span
                                    class="text-[8px] mt-2 font-bold {{ in_array($intervention->statut, ['receptionne', 'attente_paiement', 'payer']) ? 'text-blue-600' : 'text-gray-400' }} uppercase text-center">Réception</span>
                            </div>
                            <div
                                class="hidden md:block w-full h-0.5 {{ in_array($intervention->statut, ['attente_paiement', 'payer']) ? 'bg-blue-500' : 'bg-gray-200' }} -mt-5">
                            </div>
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-8 h-8 rounded-full {{ in_array($intervention->statut, ['attente_paiement', 'payer']) ? 'bg-teal-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-calendar-alt text-xs"></i>
                                </div>
                                <span
                                    class="text-[8px] mt-2 font-bold {{ in_array($intervention->statut, ['attente_paiement', 'payer']) ? 'text-teal-600' : 'text-gray-400' }} uppercase text-center">Délai</span>
                            </div>
                            <div
                                class="hidden md:block w-full h-0.5 {{ in_array($intervention->statut, ['payer']) ? 'bg-teal-500' : 'bg-gray-200' }} -mt-5">
                            </div>
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-8 h-8 rounded-full {{ in_array($intervention->statut, ['payer']) ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center shadow-lg transition-all">
                                    <i class="fas fa-check-double text-xs"></i>
                                </div>
                                <span
                                    class="text-[8px] mt-2 font-bold {{ in_array($intervention->statut, ['payer']) ? 'text-green-600' : 'text-gray-400' }} uppercase text-center">Payé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Details Column -->
            <div class="space-y-8">

                <!-- Intervention Details Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <i class="fas fa-file-invoice text-9xl"></i>
                    </div>

                    <div class="relative z-10">

                        <h3 class="text-xl font-bold text-gray-900 mb-6">Information de l'Intervention</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Référence</p>
                                <p class="text-lg font-bold text-gray-900">{{ $intervention->reference }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Code</p>
                                <p class="text-lg font-mono text-gray-700 bg-gray-50 px-3 py-1 rounded w-fit capitalize">
                                    {{ $intervention->code }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Libellé</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $intervention->libelle }}</p>
                            </div>

                            <!-- Documents Financiers -->
                            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($intervention->devis_path)
                                    <div class="space-y-2">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Devis (Estimation)
                                        </p>
                                        <a href="{{ Storage::url($intervention->devis_path) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100 hover:bg-white hover:shadow-md transition-all group">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                                <i class="fas fa-calculator text-sm"></i>
                                            </div>
                                            <div class="text-left">
                                                <span
                                                    class="block text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Devis
                                                    Initial</span>
                                                <span
                                                    class="text-[10px] text-gray-500">{{ number_format($intervention->montant_estimatif, 0, ',', ' ') }}
                                                    EURO</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                @if($intervention->facture_path)
                                    <div class="space-y-2">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Facture Finale
                                            (Justificatif)</p>
                                        <a href="{{ Storage::url($intervention->facture_path) }}" target="_blank"
                                            class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-100 hover:bg-white hover:shadow-md transition-all group">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all shadow-sm">
                                                <i class="fas fa-file-pdf text-sm"></i>
                                            </div>
                                            <div class="text-left">
                                                <span
                                                    class="block text-xs font-bold text-gray-900 group-hover:text-red-600 transition-colors">Facture
                                                    Finale</span>
                                                <span
                                                    class="text-[10px] text-gray-500">{{ number_format($intervention->montant, 0, ',', ' ') }}
                                                    EURO</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</p>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                {{ $intervention->description ?? 'Aucune description fournie.' }}
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Action & Actors -->
            <div class="space-y-8">
                <!-- Action Card -->
                <div class="bg-red-600 rounded-2xl shadow-xl p-8 text-center space-y-6">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                        <i class="fas fa-money-check-alt"></i>
                    </div>

                    @if($intervention->statut == 'receptionne')
                        <div>
                            <h4 class="text-xl font-bold text-white">Fixer le délai de paiement</h4>
                            <p class="text-red-100 text-sm mt-1">Choisissez le délai contractuel pour calculer la date
                                d'échéance.</p>
                        </div>

                        <form action="{{ route('financier.interventions.fixer_delai', $intervention->id) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <div class="text-left bg-white/10 p-4 rounded-xl border border-white/20">
                                <label for="delai_paiement" class="block text-xs font-bold text-red-100 uppercase mb-2">Choisir
                                    le délai</label>
                                <select name="delai_paiement" id="delai_paiement" required
                                    class="w-full bg-white text-gray-900 px-4 py-3 rounded-xl font-bold focus:ring-4 focus:ring-white/30 outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected>Sélectionner un délai...</option>
                                    <option value="30">30 Jours</option>
                                    <option value="45">45 Jours</option>
                                    <option value="60">60 Jours</option>
                                    <option value="95">95 Jours</option>
                                    <option value="120">120 Jours</option>
                                </select>
                                <p class="text-[10px] text-red-100 mt-2 italic">Réceptionnée le :
                                    {{ \Carbon\Carbon::parse($intervention->date_reception_finance)->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full bg-white text-red-600 hover:bg-red-50 font-black py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 active:translate-y-0 text-lg uppercase tracking-wider">
                                <i class="fas fa-calendar-check mr-2"></i> Valider le délai
                            </button>
                        </form>

                    @elseif($intervention->statut == 'attente_paiement')
                        <div>
                            <h4 class="text-xl font-bold text-white">Prêt pour le paiement ?</h4>
                            <p class="text-red-100 text-sm mt-1">Le délai de <strong>{{ $intervention->delai_paiement }}
                                    jours</strong> est fixé.</p>
                            <p class="text-white text-xs mt-2 bg-white/10 py-2 rounded-lg border border-white/20">
                                Échéance prévue le :
                                <strong>{{ \Carbon\Carbon::parse($intervention->date_paiement_prevue)->format('d/m/Y') }}</strong>
                            </p>
                        </div>

                        <form id="paymentForm" action="{{ route('financier.interventions.payer', $intervention->id) }}"
                            method="POST" class="space-y-4">
                            @csrf
                            <button type="button" onclick="confirmPayment()"
                                class="w-full bg-white text-red-600 hover:bg-red-50 font-black py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 active:translate-y-0 text-lg uppercase tracking-wider">
                                <i class="fas fa-lock mr-2"></i> Confirmer le Paiement
                            </button>
                        </form>

                    @elseif($intervention->statut == 'finance')
                        <div>
                            <h4 class="text-xl font-bold text-white">Nouvelle Demande</h4>
                            <p class="text-red-100 text-sm mt-1">Veuillez d'abord réceptionner l'intervention pour
                                continuer.
                            </p>
                        </div>
                        <form action="{{ route('financier.interventions.receptionner', $intervention->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-white text-red-600 hover:bg-red-50 font-black py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-hand-holding-usd mr-2"></i> Réceptionner
                            </button>
                        </form>

                    @elseif($intervention->statut == 'payer')
                        <div class="bg-green-500/20 p-4 rounded-xl border border-green-500/30">
                            <i class="fas fa-check-circle text-white text-4xl mb-3"></i>
                            <h4 class="text-xl font-bold text-white">Règlement Effectué</h4>
                            <p class="text-green-100 text-xs mt-1">Intervention payée le
                                {{ \Carbon\Carbon::parse($intervention->date_paiement_effectif)->format('d/m/Y') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Actors Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-50 pb-4">Parties Prenantes</h3>

                    <div class="space-y-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Personnel Technique</p>
                        @if($intervention->personnels->count() > 0)
                            @foreach($intervention->personnels as $personnel)
                                <div class="flex items-start gap-4 mb-4 last:mb-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">
                                            {{ $personnel->name . ' ' . $personnel->prenom }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $personnel->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Non assigné</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-start gap-4 border-t border-gray-50 pt-4">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Prestataire</p>
                            <p class="text-sm font-bold text-gray-900">
                                {{ $intervention->prestataire->name . ' ' . $intervention->prestataire->prenom ?? 'Non assigné' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmPayment() {
            Swal.fire({
                title: 'Confirmer le paiement ?',
                text: "Cette action changera le statut de l'intervention en 'Payé' et ne peut pas être annulée.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626', // bg-red-600
                cancelButtonColor: '#6B7280', // bg-gray-500
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> Oui, valider le paiement',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'font-bold px-6 py-3 rounded-xl',
                    cancelButton: 'px-6 py-3 rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('paymentForm').submit();
                }
            });
        }
    </script>
@endpush