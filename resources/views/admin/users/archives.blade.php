@extends('admin.layouts.template')

@section('title', 'Utilisateurs archivés')

@section('header_title', 'Gestion des archives')

@section('content')
    <div class="mx-auto" style="width: 80%;">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Archives</h2>
                <p class="text-gray-500 mt-1">Consultez et restaurez les utilisateurs archivés.</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Retour à la liste active
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Table Header Decoration -->
            <div class="h-1 bg-gradient-to-r from-gray-500 via-gray-400 to-gray-600"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-100">
                            <th class="px-8 py-6 font-semibold text-center">Utilisateur</th>
                            <th class="px-6 py-6 font-semibold text-center">Rôle</th>
                            <th class="px-6 py-6 font-semibold text-center">Date d'archivage</th>
                            <th class="px-6 py-6 font-semibold text-center">Heure d'archivage</th>
                            <th class="px-6 py-6 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/80 transition-all duration-200 group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center" style="display: flex; justify-content: center; align-items: center;">
                                        <div class="h-12 w-12 flex-shrink-0 relative grayscale opacity-70">
                                            @if($user->profile_picture)
                                                <img class="h-12 w-12 rounded-xl object-cover border border-gray-100 shadow-sm"
                                                    src="{{ asset('storage/' . $user->profile_picture) }}"
                                                    alt="{{ $user->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center text-lg font-bold border border-gray-200 shadow-sm">
                                                    {{ substr($user->name, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-600 group-hover:text-gray-800 transition-colors">{{ $user->name }} {{ $user->prenom }}</div>
                                            <div class="text-xs text-gray-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $roleStyles = [
                                            'admin' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'responsable' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'prestataire' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'finance' => 'bg-gray-100 text-gray-600 border-gray-200',
                                        ];
                                        $style = $roleStyles[$user->role] ?? 'bg-gray-50 text-gray-500 border-gray-100';
                                        $label = ucfirst($user->role);
                                    @endphp
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg border {{ $style }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center text-sm text-gray-500">
                                    {{ $user->archive_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5 text-center text-sm text-gray-500">
                                    {{ $user->archive_at->format('H:i') }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirmRestore(event)">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 hover:border-green-300 transition-all font-medium text-sm shadow-sm"
                                            title="Restaurer">
                                            <i class="fas fa-trash-restore mr-2"></i> Restaurer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-archive text-gray-300 text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">Aucune archive</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm">Les utilisateurs archivés apparaîtront ici.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmRestore(event) {
                event.preventDefault();
                const form = event.target;

                Swal.fire({
                    title: 'Restaurer cet utilisateur ?',
                    text: "Il sera de nouveau actif et visible dans la liste principale.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981', // green-500
                    cancelButtonColor: '#9ca3af', // gray-400
                    confirmButtonText: 'Oui, restaurer',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold',
                        cancelButton: 'rounded-xl px-6 py-3 font-medium'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            }
        </script>
    @endpush
@endsection
