@extends('financier.layouts.template')

@section('title', 'Ajouter un utilisateur Finance')

@section('content')
    <div class=" mx-auto" style="width: 80%;">

        <!-- Breadcrumb / Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Ajouter un utilisateur</h2>
                <p class="text-sm text-gray-500 mt-1">Créez un nouveau compte financier.</p>
            </div>
            <a href="{{ route('financier.users.index') }}"
                class="group flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Form Header Decoration -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>

            <div class="p-8">
                <form action="{{ route('financier.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 mr-4 border border-red-100">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informations du Compte</h3>
                                <p class="text-xs text-gray-500">Remplissez les détails pour créer un nouvel utilisateur
                                    finance.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nom -->
                            <div class="relative">
                                <label for="name"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="name" id="name" required
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: KADIO">
                                </div>
                            </div>

                            <!-- Prénom -->
                            <div class="relative">
                                <label for="prenom"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Prénom
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-signature"></i>
                                    </span>
                                    <input type="text" name="prenom" id="prenom" required
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
                                    <input type="email" name="email" id="email" required
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="nom@exemple.com">
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
                                    <input type="tel" name="contact" id="contact" required
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: 0102030405">
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="relative">
                                <label for="adresse"
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Adresse
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" name="adresse" id="adresse" required
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all outline-none text-gray-700 placeholder-gray-400"
                                        placeholder="Ex: Cocody">
                                </div>
                            </div>

                            <!-- Rôle (Verrouillé) -->
                            <div class="relative">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rôle
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <input type="text" value="Financier" readonly
                                        class="w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 font-medium cursor-not-allowed">
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Le rôle est automatiquement défini sur Financier.</p>
                            </div>

                            <!-- Photo - Version améliorée avec aperçu -->
                            <div class="relative md:col-span-3">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Photo
                                    de profil
                                    (Optionnel)</label>

                                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
                                    <!-- Zone d'aperçu -->
                                    <div class="relative w-32 h-32 rounded-2xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50 flex-shrink-0"
                                        id="imagePreview">
                                        <img id="previewImage" src="" alt="Aperçu"
                                            class="w-full h-full object-cover hidden">
                                        <div id="previewPlaceholder"
                                            class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-image text-3xl mb-2"></i>
                                            <span class="text-xs">Aperçu</span>
                                        </div>
                                    </div>

                                    <!-- Zone de téléchargement -->
                                    <div class="flex-1 w-full">
                                        <div class="relative">
                                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                                class="hidden" onchange="previewImage(event)">

                                            <!-- Zone cliquable (Label) -->
                                            <label for="profile_picture"
                                                class="cursor-pointer block w-full p-8 border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50 hover:bg-gray-100 hover:border-red-300 transition-all duration-300 text-center group">
                                                <div class="flex flex-col items-center justify-center space-y-4">
                                                    <div
                                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                        <i class="fas fa-cloud-upload-alt text-2xl text-red-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-700 mb-1">Cliquez pour télécharger
                                                        </p>
                                                        <p class="text-sm text-gray-500">ou glissez-déposez votre image</p>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <button type="reset"
                            class="px-6 py-3 mr-4 text-gray-500 hover:text-gray-700 font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-600 transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-check-circle mr-2"></i> Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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

                // Afficher le nom du fichier
                selectedFileName.textContent = file.name;
                fileNameDisplay.classList.remove('hidden');

                // Changer le style de la zone d'aperçu
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

            // Réinitialiser l'input file
            input.value = '';

            // Cacher l'aperçu
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            fileNameDisplay.classList.add('hidden');

            // Réinitialiser le style
            imagePreview.classList.remove('border-solid', 'border-red-500', 'shadow-md');
            imagePreview.classList.add('border-dashed', 'border-gray-300');
        }

        // Gestion du drag & drop
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
                    // Déclencher manuellement l'événement change
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
        }
    </script>
@endpush