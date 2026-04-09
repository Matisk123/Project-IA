<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-bold text-indigo-900 mb-2">Bienvenue, {{ Auth::user()->name }} 👋</h3>
                        <p class="text-gray-500">
                            Prêt à organiser ou participer aux {{ Auth::user()->role === 'manager' ? 'événements de votre école' : 'prochaines JPO de votre école' }} ?
                        </p>
                    </div>
                    
                    <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Parcourir les événements
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Statistic Cards -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Votre rôle</p>
                        <p class="text-xl font-bold text-gray-900 capitalize">{{ Auth::user()->role === 'manager' ? 'Responsable Engagements' : 'Élève Engagé' }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Inscriptions Actuelles</p>
                        <p class="text-xl font-bold text-gray-900">{{ Auth::user()->events()->count() }} Événements</p>
                    </div>
                </div>
            </div>

            <!-- Liste des événements ou état vide -->
            <div class="mt-12">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Vos Prochains Événements</h3>
                @if(Auth::user()->events->isEmpty())
                    <div class="bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-1">Aucun événement prévu</h4>
                        <p class="text-gray-500">Vous n'êtes inscrit à aucun salon ou journée portes ouvertes pour le moment.</p>
                        @if(Auth::user()->role !== 'manager')
                            <a href="{{ route('events.index') }}" class="mt-4 inline-block px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">Explorer les opportunités</a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(Auth::user()->events->sortBy('date') as $event)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
                                <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">{{ $event->type === 'jpo' ? 'Portes Ouvertes' : 'Salon' }}</div>
                                <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $event->title }}</h4>
                                <div class="text-sm text-gray-500">{{ $event->date->format('d/m/Y') }} • {{ $event->location }}</div>
                                <a href="{{ route('events.show', $event) }}" class="mt-4 text-sm text-indigo-600 font-medium hover:underline inline-flex items-center gap-1">Voir les détails <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
