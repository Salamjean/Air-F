@extends('admin.layouts.template')

@section('title', 'Gestion du Stock des consommables')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestion du Stock des consommables</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.equipements.history') }}"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg transition-colors flex items-center shadow-md">
                    <i class="fas fa-history mr-2 text-xs"></i> Historique
                </a>
                <a href="{{ route('admin.equipements.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center shadow-md">
                    <i class="fas fa-plus mr-2 text-xs"></i> Ajouter un consommable
                </a>
            </div>
        </div>

        <!-- Filters -->
        <form action="{{ route('admin.equipements.index') }}" method="GET"
            class="bg-white p-6 rounded-xl border border-gray-200 mb-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="site_id" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par Site</label>
                    <select name="site_id" id="site_id" onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm bg-gray-50">
                        <option value="">Tous les sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ $siteId == $site->id ? 'selected' : '' }}>{{ $site->name }}
                                ({{ $site->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center pb-2">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="low_stock" value="1" {{ $lowStock ? 'checked' : '' }}
                            onchange="this.form.submit()" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                        </div>
                        <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-red-600 transition-colors">Alerte
                            Stock Bas (≤ 5)</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="exportToExcel()"
                        class="text-sm bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-lg font-bold flex items-center transition-colors">
                        <i class="fas fa-file-excel mr-2"></i> Exporter Excel
                    </button>
                    <a href="{{ route('admin.equipements.index') }}"
                        class="text-sm text-red-600 hover:text-red-800 font-bold flex items-center transition-colors">
                        <i class="fas fa-times-circle mr-2"></i> Réinitialiser les filtres
                    </a>
                </div>
            </div>
            @if($categoryId)
                <input type="hidden" name="category_id" value="{{ $categoryId }}">
            @endif
        </form>

        <!-- Category Tabs -->
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('admin.equipements.index', array_merge(request()->except('category_id'))) }}"
                class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ !$categoryId ? 'bg-red-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Tous les consommables
            </a>
            @foreach($categories as $category)
                <a href="{{ route('admin.equipements.index', array_merge(request()->all(), ['category_id' => $category->id])) }}"
                    class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ $categoryId == $category->id ? 'bg-red-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <!-- <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Image</th> -->
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Désignation</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Catégorie</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Site(s)</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">En
                            Stock</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Ajouté par</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($equipements as $equipement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipement->image)
                                    <img src="{{ asset('storage/' . $equipement->image) }}" alt="{{ $equipement->name }}"
                                        class="w-12 h-12 object-cover rounded-lg border border-gray-100">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-tools text-xl"></i>
                                    </div>
                                @endif
                            </td> -->
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-bold text-gray-900">{{ $equipement->name }}</div>
                                <div class="flex flex-wrap gap-2 mt-1" style="display:flex; justify-content: center;">
                                    @if($equipement->longueur)
                                        <span
                                            class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100 font-medium">
                                            <i class="fas fa-ruler-combined mr-1"></i>{{ $equipement->longueur }}
                                        </span>
                                    @endif
                                    @if($equipement->type)
                                        <span
                                            class="text-[10px] bg-purple-50 text-purple-600 px-1.5 py-0.5 rounded border border-purple-100 font-medium">
                                            <i class="fas fa-tag mr-1"></i>{{ $equipement->type }}
                                        </span>
                                    @endif
                                    @if($equipement->numero_bien)
                                        <span
                                            class="text-[10px] bg-amber-50 text-amber-600 px-1.5 py-0.5 rounded border border-amber-100 font-medium">
                                            <i class="fas fa-barcode mr-1"></i>{{ $equipement->numero_bien }}
                                        </span>
                                    @endif
                                </div>
                                @if($equipement->description)
                                    <div class="text-xs text-gray-500 truncate max-w-xs mt-1">{{ $equipement->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                    {{ $equipement->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @forelse($equipement->sites as $site)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mb-1 mr-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $site->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Aucun site</span>
                                @endforelse
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="text-sm font-bold {{ $equipement->stock_quantity <= $equipement->stock_min_alert ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} px-3 py-1 rounded-lg">
                                        {{ $equipement->stock_quantity }} {{ $equipement->unit }}
                                    </span>
                                    @if($equipement->stock_quantity <= $equipement->stock_min_alert)
                                        <span class="text-[10px] text-red-500 font-medium uppercase tracking-tighter mt-1">Alerte
                                            Stock Bas</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-xs text-gray-600 font-medium">{{ $equipement->creator->name ?? 'N/A' }}
                                    {{ $equipement->creator->prenom ?? '' }}
                                </div>
                                <div class="text-[10px] text-gray-400">{{ $equipement->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center" style="display:flex; justify-content: center;">
                                <div class="flex justify-end space-x-2">
                                    <button type="button"
                                        onclick="openRechargeModal({{ $equipement->id }}, '{{ $equipement->name }}', '{{ $equipement->unit }}')"
                                        class="text-green-600 hover:text-green-800 transition-colors p-2" title="Recharger">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                    <a href="{{ route('admin.equipements.edit', $equipement) }}"
                                        class="text-blue-600 hover:text-blue-800 transition-colors p-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.equipements.destroy', $equipement) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce consommable ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-2"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 rounded-full p-4 mb-4">
                                        <i class="fas fa-box-open text-gray-300 text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun consommable trouvé dans cette catégorie.</p>
                                    @if($categories->count() == 0)
                                        <a href="{{ route('admin.categories.create') }}"
                                            class="mt-4 text-red-600 font-semibold hover:underline">
                                            Commencez par créer une catégorie <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recharge Modal -->
    <div id="rechargeModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeRechargeModal()">
            </div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Recharger le Stock</h3>
                    <button onclick="closeRechargeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="rechargeForm" method="POST" action="">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            <p class="text-xs text-blue-700 font-medium">
                                Consommable : <span id="modalEquipName" class="font-bold"></span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Quantité à ajouter</label>
                            <div class="relative">
                                <input type="number" name="quantity" required min="1"
                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm outline-none transition-all">
                                <span
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 text-xs font-bold uppercase"
                                    id="modalEquipUnit"></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description (facultatif)</label>
                            <textarea name="description" rows="2" placeholder="Ex: Livraison fournisseur n°123..."
                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-sm outline-none transition-all"></textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="closeRechargeModal()"
                            class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-gray-800 transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl text-sm font-bold transition-all shadow-md">
                            Confirmer la Recharge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRechargeModal(id, name, unit) {
            const modal = document.getElementById('rechargeModal');
            const form = document.getElementById('rechargeForm');
            const nameSpan = document.getElementById('modalEquipName');
            const unitSpan = document.getElementById('modalEquipUnit');

            form.action = `/admin/equipements/${id}/recharge`;
            nameSpan.textContent = name;
            unitSpan.textContent = unit;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRechargeModal() {
            const modal = document.getElementById('rechargeModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function exportToExcel() {
            const form = document.querySelector('form[action="{{ route('admin.equipements.index') }}"]');
            const params = new URLSearchParams(new FormData(form)).toString();
            window.location.href = "{{ route('admin.equipements.export') }}?" + params;
        }
    </script>
@endsection