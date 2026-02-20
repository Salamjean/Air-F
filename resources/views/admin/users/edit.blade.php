@extends('admin.layouts.template')

@section('title', 'Modifier un utilisateur')

@section('header_title', 'Gestion des utilisateurs')

@section('content')
    <div class=" mx-auto" style="width: 80%;">

        <!-- Breadcrumb / Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Modifier un utilisateur</h2>
                <p class="text-sm text-gray-500 mt-1">Modifiez les informations de l'utilisateur.</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Form Header Decoration -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>

            <div class="p-8">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 mr-4 border border-red-100">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informations du Compte</h3>
                                <p class="text-xs text-gray-500">Mettez à jour les détails de l'utilisateur.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Rôle (Placé en haut pour déterminer l'affichage) -->
                            <div class="relative">
                                <label for="role"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rôle
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <select name="role" id="role" onchange="toggleFields()"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 appearance-none">
                                        <option value="responsable" {{ old('role', $user->role) == 'responsable' ? 'selected' : '' }}>Responsable AF</option>
                                        <option value="prestataire" {{ old('role', $user->role) == 'prestataire' ? 'selected' : '' }}>Prestataire</option>
                                        <option value="finance" {{ old('role', $user->role) == 'finance' ? 'selected' : '' }}>
                                            Financier</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="relative">
                                <label for="name" id="name_label"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: KADIO">
                                </div>
                            </div>

                            <!-- Prénom -->
                            <div class="relative" id="prenom_container">
                                <label for="prenom"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Prénom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: Eric">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="relative">
                                <label for="email"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="nom@exemple.com" readonly>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="relative">
                                <label for="contact"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contact
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <input type="tel" name="contact" id="contact"
                                        value="{{ old('contact', $user->contact) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: 0102030405">
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="relative">
                                <label for="adresse"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Adresse</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" name="adresse" id="adresse"
                                        value="{{ old('adresse', $user->adresse) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: Cocody">
                                </div>
                            </div>

                            <!-- Photo - Version améliorée avec aperçu -->
                            <div class="relative md:col-span-3">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Photo
                                    de profil
                                    (Optionnel)</label>

                                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
                                    <!-- Aperçu de l'image -->
                                    <div class="w-32 h-32 flex-shrink-0">
                                        <div id="imagePreview"
                                            class="w-full h-full rounded-2xl border-2 {{ $user->profile_picture ? 'border-solid border-red-500 shadow-md' : 'border-dashed border-gray-300' }} bg-gray-50 flex flex-col items-center justify-center overflow-hidden transition-all duration-300 hover:border-red-300">

                                            <div id="previewPlaceholder"
                                                class="text-center p-4 {{ $user->profile_picture ? 'hidden' : '' }}">
                                                <div
                                                    class="w-16 h-16 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-500 flex items-center justify-center text-lg font-bold border border-red-100 shadow-sm mx-auto mb-2">
                                                    {{ substr($user->name, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                                                </div>
                                                <p class="text-xs text-gray-500">Actuel</p>
                                            </div>

                                            <img id="previewImage"
                                                src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}"
                                                alt="Aperçu avatar"
                                                class="{{ $user->profile_picture ? '' : 'hidden' }} w-full h-full object-cover">
                                        </div>
                                    </div>

                                    <!-- Zone de téléchargement -->
                                    <div class="flex-1">
                                        <div class="relative">
                                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                                class="sr-only" onchange="previewImage(event)">

                                            <!-- Zone cliquable (Label) -->
                                            <label for="profile_picture"
                                                class="cursor-pointer block w-full p-8 border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50 hover:bg-gray-100 hover:border-red-300 transition-all duration-300 text-center group">
                                                <div class="flex flex-col items-center justify-center space-y-4">
                                                    <div
                                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                        <i class="fas fa-cloud-upload-alt text-2xl text-red-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-700 mb-1">Cliquez pour modifier</p>
                                                        <p class="text-sm text-gray-500">ou glissez-déposez une nouvelle
                                                            image</p>
                                                    </div>
                                                    <div
                                                        class="flex items-center justify-center space-x-2 text-xs text-gray-500">
                                                        <i class="fas fa-info-circle"></i>
                                                        <span>PNG, JPG ou WEBP (max. 2MB)</span>
                                                    </div>
                                                    <!-- Faux bouton visuel -->
                                                    <div
                                                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-medium rounded-xl shadow-sm group-hover:shadow-md transition-all">
                                                        <i class="fas fa-upload mr-2"></i>Choisir un fichier
                                                    </div>
                                                </div>
                                            </label>

                                            <!-- Nom du fichier sélectionné -->
                                            <div id="fileNameDisplay" class="mt-4 hidden">
                                                <div
                                                    class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl p-4">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                                        <div>
                                                            <p class="font-medium text-gray-800" id="selectedFileName"></p>
                                                            <p class="text-xs text-green-600 mt-1">Prêt pour l'upload</p>
                                                        </div>
                                                    </div>
                                                    <button type="button" onclick="removeImage()"
                                                        class="text-red-500 hover:text-red-700 focus:outline-none">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Affichage des erreurs de validation -->
                                            @error('profile_picture')
                                                <p class="mt-2 text-sm text-red-600">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-3 mr-4 text-gray-500 hover:text-gray-700 font-medium transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-600 transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-save mr-2"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const prenomContainer = document.getElementById('prenom_container');
            const nameLabel = document.getElementById('name_label');
            const nameInput = document.getElementById('name');

            if (role === 'prestataire') {
                prenomContainer.classList.add('hidden');
                nameLabel.innerHTML = 'Nom du prestataire <span class="text-red-500">*</span>';
                nameInput.placeholder = 'Ex: SOS SÉCURITÉ';
            } else {
                prenomContainer.classList.remove('hidden');
                nameLabel.innerHTML = 'Nom <span class="text-red-500">*</span>';
                nameInput.placeholder = 'Ex: KADIO';
            }
        }

        // Exécuter au chargement
        document.addEventListener('DOMContentLoaded', toggleFields);

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('previewImage');
            const placeholder = document.getElementById('previewPlaceholder');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const selectedFileName = document.getElementById('selectedFileName');
            const imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }

                reader.readAsDataURL(file);

                selectedFileName.textContent = file.name;
                fileNameDisplay.classList.remove('hidden');

                imagePreview.classList.remove('border-dashed', 'border-gray-300');
                imagePreview.classList.add('border-solid', 'border-red-500', 'shadow-md');
            }
        }

        function removeImage() {
            const input = document.getElementById('profile_picture');
            const preview = document.getElementById('previewImage');
            const placeholder = document.getElementById('previewPlaceholder');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const imagePreview = document.getElementById('imagePreview');

            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            fileNameDisplay.classList.add('hidden');

            imagePreview.classList.remove('border-solid', 'border-red-500', 'shadow-md');
            imagePreview.classList.add('border-dashed', 'border-gray-300');
        }

        const dropZone = document.querySelector('label[for="profile_picture"]');

        if (dropZone) {
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-red-500', 'bg-red-50');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-red-500', 'bg-red-50');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-red-500', 'bg-red-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const input = document.getElementById('profile_picture');
                    input.files = files;
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
        }
    </script>
@endpush