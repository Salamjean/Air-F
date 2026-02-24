@extends('financier.layouts.template')

@section('title', 'Historique des Notifications')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Vos Notifications</h1>
                <p class="text-lg text-gray-600 mt-2">Suivez l'activité de vos dossiers et les alertes de paiement.</p>
            </div>

            @if(Auth::guard('user')->user()->unreadNotifications->count() > 0)
                <form action="{{ route('financier.notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg shadow-red-200">
                        <i class="fas fa-check-double mr-2"></i> Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-50">
                @forelse($notifications as $notification)
                    <div
                        class="p-6 hover:bg-gray-50/50 transition-all duration-300 group {{ $notification->unread() ? 'bg-red-50/20' : '' }}">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl {{ $notification->unread() ? 'bg-red-100 text-red-600 scale-110' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center flex-shrink-0 transition-transform">
                                    <i
                                        class="fas {{ $notification->unread() ? 'fa-bell shadow-sm' : 'fa-bell-slash' }} text-lg"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h3 class="text-sm font-black text-gray-900">
                                            {{ $notification->data['reference'] ?? 'Notification' }}
                                        </h3>
                                        <span
                                            class="text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-tighter {{ $notification->unread() ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $notification->unread() ? 'Nouveau' : 'Lu' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1 font-medium">
                                        {{ $notification->data['message'] ?? 'Aucun détail disponible.' }}
                                    </p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <span class="text-[11px] font-bold text-gray-400 flex items-center">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $notification->created_at->format('d/m/Y à H:i') }}
                                        </span>
                                        <span class="text-[11px] font-bold text-gray-300">
                                            ({{ $notification->created_at->diffForHumans() }})
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 ml-16 md:ml-0">
                                @if(isset($notification->data['intervention_id']))
                                    <a href="{{ route('financier.notifications.read', $notification->id) }}"
                                        class="px-5 py-2.5 bg-gray-900 text-white text-xs font-black rounded-xl hover:bg-red-600 transition-all duration-300 shadow-sm">
                                        Voir le dossier <i class="fas fa-external-link-alt ml-2 text-[10px]"></i>
                                    </a>
                                @elseif($notification->unread())
                                    <a href="{{ route('financier.notifications.read', $notification->id) }}"
                                        class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-xs font-black rounded-xl hover:bg-gray-50 transition-all duration-300">
                                        Marquer comme lu
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-bell-slash text-4xl text-gray-200"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Aucune notification</h3>
                        <p class="text-gray-500 mt-2 max-w-xs mx-auto">Vous n'avez pas encore reçu de notifications concernant
                            vos dossiers.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="p-8 border-t border-gray-50 bg-gray-50/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection