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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Big Amount & Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Large Amount Display -->
                <div class="bg-white rounded-3xl shadow-xl border border-red-50 p-10 text-center relative overflow-hidden">
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

                <!-- Intervention Details Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">Information de l'Intervention</h3>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                            Statut: En attente de paiement
                        </span>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
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
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Devis (Estimation)</p>
                                    <a href="{{ Storage::url($intervention->devis_path) }}" target="_blank"
                                        class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100 hover:bg-white hover:shadow-md transition-all group">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-calculator text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <span class="block text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Devis Initial</span>
                                            <span class="text-[10px] text-gray-500">{{ number_format($intervention->montant_estimatif, 0, ',', ' ') }} EURO</span>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if($intervention->facture_path)
                                <div class="space-y-2">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Facture Finale (Justificatif)</p>
                                    <a href="{{ Storage::url($intervention->facture_path) }}" target="_blank"
                                        class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-100 hover:bg-white hover:shadow-md transition-all group">
                                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-file-pdf text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <span class="block text-xs font-bold text-gray-900 group-hover:text-red-600 transition-colors">Facture Finale</span>
                                            <span class="text-[10px] text-gray-500">{{ number_format($intervention->montant, 0, ',', ' ') }} EURO</span>
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

            <!-- Right Column: Actors & Action -->
            <div class="space-y-8">
                <!-- Actors Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-50 pb-4">Parties Prenantes</h3>

                    <div class="space-y-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Personnel Technique</p>
                        @if($intervention->personnels->count() > 0)
                            @foreach($intervention->personnels as $personnel)
                                <div class="flex items-start gap-4 mb-4 last:mb-0">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
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
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
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

                <!-- Action Card -->
                <div class="bg-red-600 rounded-2xl shadow-xl p-8 text-center space-y-6">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white">Prêt pour le paiement ?</h4>
                        <p class="text-red-100 text-sm mt-1">Assurez-vous d'avoir vérifié toutes les informations avant de
                            confirmer.</p>
                    </div>

                    <form id="paymentForm" action="{{ route('financier.interventions.payer', $intervention->id) }}"
                        method="POST" class="space-y-4">
                        @csrf
                        <div class="text-left bg-white/10 p-4 rounded-xl border border-white/20">
                            <label for="delai_paiement" class="block text-xs font-bold text-red-100 uppercase mb-2">Choisir le délai de paiement</label>
                            <select name="delai_paiement" id="delai_paiement" required
                                class="w-full bg-white text-gray-900 px-4 py-3 rounded-xl font-bold focus:ring-4 focus:ring-white/30 outline-none appearance-none cursor-pointer">
                                <option value="" disabled selected>Sélectionner un délai...</option>
                                <option value="30">30 Jours</option>
                                <option value="45">45 Jours</option>
                                <option value="95">95 Jours</option>
                                <option value="120">120 Jours</option>
                            </select>
                            <p class="text-[10px] text-red-100 mt-2 italic">Basé sur la soumission du : {{ \Carbon\Carbon::parse($intervention->date_soumission_finance)->format('d/m/Y') }}</p>
                        </div>

                        <button type="button" onclick="confirmPayment()"
                            class="w-full bg-white text-red-600 hover:bg-red-50 font-black py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 active:translate-y-0 text-lg uppercase tracking-wider">
                            <i class="fas fa-lock mr-2"></i> Confirmer le Paiement
                        </button>
                    </form>
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