@extends('personnel.layouts.template')

@section('title', 'Mon Profil - Personnel')

@section('header_title', 'Mon Profil')

@section('content')
    <div class="mx-auto" style="width: 80%;">

        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Mon Profil</h2>
                <p class="text-sm text-gray-500 mt-1">Gérez vos informations personnelles et votre sécurité.</p>
            </div>
            <a href="{{ route('personnel.dashboard') }}"
                class="group flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Retour au tableau de bord
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>

            <div class="p-8">
                <form id="profileForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 mr-4 border border-red-100">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informations du Compte</h3>
                                <p class="text-xs text-gray-500">Mettez à jour vos détails personnels.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nom -->
                            <div class="relative">
                                <label for="name"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nom</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Prénom -->
                            <div class="relative">
                                <label for="prenom"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Prénom</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="relative">
                                <label for="email"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        readonly
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="relative">
                                <label for="contact"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <input type="tel" name="contact" id="contact"
                                        value="{{ old('contact', $user->contact) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="relative md:col-span-2">
                                <label for="adresse"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Adresse</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" name="adresse" id="adresse"
                                        value="{{ old('adresse', $user->adresse) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="relative md:col-span-3 mt-4">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Photo
                                    de profil</label>
                                <div class="flex items-center gap-6">
                                    <div class="w-24 h-24 flex-shrink-0 relative group">
                                        <img id="previewImage"
                                            src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . $user->name . '+' . $user->prenom . '&background=FEF2F2&color=EF4444' }}"
                                            class="w-full h-full rounded-2xl object-cover border-2 border-gray-100 shadow-sm"
                                            alt="Profil">
                                        <label for="profile_picture"
                                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
                                            <i class="fas fa-camera text-xl"></i>
                                        </label>
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                            class="hidden" onchange="handleImagePreview(event)">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">Choisissez une photo de profil. Formats : PNG, JPG,
                                            GIF (max. 2MB).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 pt-8 border-t border-gray-100">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mr-4 border border-blue-100">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Sécurité</h3>
                                <p class="text-xs text-gray-500">Laissez vide pour conserver votre mot de passe actuel.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nouveau mot de passe -->
                            <div class="relative">
                                <label for="password"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nouveau
                                    mot de passe</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Min. 8 caractères">
                                </div>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Confirmer
                                    le mot de passe</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-check-double"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Confirmer le mot de passe">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <button type="button" onclick="confirmUpdate()"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-600 transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleImagePreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function confirmUpdate() {
            Swal.fire({
                title: 'Confirmation de sécurité',
                text: 'Veuillez saisir votre mot de passe actuel pour valider les modifications.',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Mot de passe actuel'
                },
                showCancelButton: true,
                confirmButtonText: 'Valider',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc2626',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Le mot de passe est obligatoire');
                        return false;
                    }

                    const formData = new FormData(document.getElementById('profileForm'));
                    formData.append('current_password', password);

                    return fetch('{{ route("personnel.profile.update") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(error => { throw new Error(error.message) });
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Erreur: ${error.message}`);
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès !',
                        text: result.value.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = result.value.redirect;
                    });
                }
            });
        }
    </script>
@endpush