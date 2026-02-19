@extends('admin.layouts.template')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Interventions Validées</h1>
                <p class="text-lg text-gray-600 mt-2">Gérez les interventions validées par vos prestataires et finalisez les
                    ordres de mission.</p>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto relative">
                <form action="{{ route('admin.interventions.valider') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-red-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-3 w-full md:w-80 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 placeholder-gray-400 text-gray-700"
                        placeholder="Rechercher par référence, code...">
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Top Decorative Bar -->
            <div class="h-2 bg-gradient-to-r from-green-500 via-emerald-400 to-green-500"></div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Référence / Code</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Libellé</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Prestataire</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Personnel</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Période</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Statut / Motif</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($interventions as $intervention)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900">{{ $intervention->reference }}</span>
                                        <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded mt-1 overflow-hidden">{{ $intervention->code }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-semibold text-gray-800 line-clamp-1" title="{{ $intervention->libelle }}">{{ $intervention->libelle }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs mx-auto">{{ Str::limit($intervention->description, 40) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-2">
                                            <i class="fas fa-building text-[10px]"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $intervention->prestataire->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($intervention->personnel)
                                        <button onclick="showPersonnelInfo('{{ $intervention->personnel->name }}', '{{ $intervention->personnel->prenom }}', '{{ $intervention->personnel->email }}', '{{ $intervention->personnel->contact }}')"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors text-xs font-bold">
                                            <div class="w-5 h-5 rounded-full bg-indigo-200 flex items-center justify-center text-[10px]">
                                                {{ substr($intervention->personnel->name, 0, 1) }}{{ substr($intervention->personnel->prenom, 0, 1) }}
                                            </div>
                                            {{ Str::limit($intervention->personnel->prenom, 10) }}
                                        </button>
                                    @else
                                        <span class="text-xs italic text-gray-400">Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-col text-xs text-gray-600">
                                        <span class="flex items-center justify-center gap-1">
                                            <i class="far fa-calendar-alt text-gray-400"></i>
                                            {{ $intervention->date_debut ? \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') : 'N/A' }}
                                        </span>
                                        <span class="flex items-center justify-center gap-1 mt-1">
                                            <i class="far fa-calendar-check text-gray-400"></i>
                                            {{ $intervention->date_fin ? \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($intervention->statut === 'rejeter')
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded-full border border-red-200">Rejetée</span>
                                            <button onclick="Swal.fire({title:'Motif du refus', text:'{{ addslashes($intervention->motif_refus) }}', icon:'info', confirmButtonColor:'#d33'})" 
                                                class="text-[10px] text-red-500 hover:text-red-700 underline font-medium">Voir motif</button>
                                        </div>
                                    @else
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded-full border border-green-200">Validée</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.interventions.details', $intervention->id) }}"
                                            class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors" title="Détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($intervention->statut === 'rejeter')
                                            <a href="{{ route('admin.interventions.edit', $intervention->id) }}"
                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                        @else
                                            <button onclick="openDirectConfirmationModal('{{ $intervention->id }}')"
                                                class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                                <i class="fas fa-check-double"></i> Confirmer
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-clipboard-check text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800">Aucune intervention validée</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto mt-1">
                                            Les interventions validées par les prestataires apparaîtront ici.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts remain largely the same but with tailored sweetalert styling could be nice if requested, for now functional js is kept -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showPersonnelInfo(name, prenom, email, contact) {
            Swal.fire({
                title: `<div class="text-xl font-bold text-gray-800">Assigné à</div>`,
                html: `
                                <div class="flex flex-col items-center mb-4">
                                    <div class="w-20 h-20 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl font-bold mb-4">
                                        ${name.charAt(0)}${prenom.charAt(0)}
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">${name} ${prenom}</h3>
                                    <p class="text-gray-500">Personnel Technique</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 text-left w-full space-y-3 border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm text-gray-400">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400 uppercase font-bold">Email</span>
                                            <span class="text-sm font-medium text-gray-800">${email}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                         <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm text-gray-400">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400 uppercase font-bold">Contact</span>
                                            <span class="text-sm font-medium text-gray-800">${contact}</span>
                                        </div>
                                    </div>
                                </div>
                            `,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'rounded-2xl border-0 shadow-2xl',
                    closeButton: 'focus:outline-none'
                }
            });
        }

        function confirmEnvoyer(id, reference) {
            Swal.fire({
                title: 'Envoyer l\'ordre ?',
                text: `L'intervention ${reference} passera au statut "Envoyé".`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#E5E7EB',
                confirmButtonText: '<i class="fas fa-paper-plane mr-2"></i>Oui, Envoyer',
                cancelButtonText: '<span class="text-gray-700">Annuler</span>',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg px-6 py-3',
                    cancelButton: 'rounded-lg px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/interventions/${id}/envoyer`;

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


        function openDirectConfirmationModal(id) {
            Swal.fire({
                title: 'Confirmation Directe',
                html: `
                            <div class="text-left space-y-4">
                                <p class="text-gray-600 text-sm">Cette action validera directement l'intervention (statut: Confirmée) et enverra un email au destinataire.</p>

                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Email du destinataire</label>
                                    <input type="email" id="swal-email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 border-gray-300" placeholder="exemple@email.com">
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                                    <textarea id="swal-message" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 border-gray-300 h-32" placeholder="Votre message..."></textarea>
                                </div>
                            </div>
                        `,
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Envoyer & Confirmer',
                cancelButtonText: 'Annuler',
                preConfirm: () => {
                    const email = document.getElementById('swal-email').value;
                    const message = document.getElementById('swal-message').value;

                    if (!email || !message) {
                        Swal.showValidationMessage('Tous les champs sont obligatoires');
                        return false;
                    }
                    // Simple email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        Swal.showValidationMessage('Veuillez entrer une adresse email valide');
                        return false;
                    }

                    return { email: email, message: message };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/interventions/${id}/confirmer-directement`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const emailInput = document.createElement('input');
                    emailInput.type = 'hidden';
                    emailInput.name = 'email';
                    emailInput.value = result.value.email;
                    form.appendChild(emailInput);

                    const messageInput = document.createElement('input');
                    messageInput.type = 'hidden';
                    messageInput.name = 'message';
                    messageInput.value = result.value.message;
                    form.appendChild(messageInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection