<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Événements (JPO & Salons)') }}
            </h2>
            @if(Auth::user()->role === 'manager')
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Créer un événement
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if($events->isEmpty())
                <div class="glass-card rounded-3xl p-12 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Aucun événement à venir</h3>
                    <p class="text-slate-400 max-w-md">Les prochains salons et JPO s'afficheront ici. Revenez bientôt ou contactez un responsable.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="group glass-card rounded-3xl overflow-hidden hover:shadow-lg hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-300">
                            <!-- Type Badge & Date Header -->
                            <div class="h-32 {{ $event->type === 'jpo' ? 'bg-gradient-to-br from-indigo-500/80 to-purple-600/80' : 'bg-gradient-to-br from-emerald-500/80 to-teal-500/80' }} p-6 flex flex-col justify-between text-white relative overflow-hidden backdrop-blur-sm">
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="flex justify-between items-start relative z-10">
                                    <div class="flex flex-col gap-2">
                                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider">
                                            {{ $event->type === 'jpo' ? 'Portes Ouvertes' : 'Salon' }}
                                        </span>
                                        @if($event->date->isPast())
                                            <span class="px-3 py-1 bg-slate-900/40 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-wider text-slate-300 border border-white/10 text-center">
                                                Terminé
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-black leading-none">{{ $event->date->format('d') }}</div>
                                        <div class="text-sm font-medium uppercase opacity-80">{{ $event->date->translatedFormat('M y') }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="p-6">
                                <h3 class="font-bold text-xl text-white mb-2 line-clamp-1">{{ $event->title }}</h3>
                                
                                <div class="flex items-center text-sm text-slate-400 mb-4 gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="truncate">{{ $event->location }}</span>
                                </div>
                                
                                <p class="text-slate-500 text-sm line-clamp-2 mb-6 h-10">{{ $event->description }}</p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <a href="{{ route('events.show', $event) }}" class="text-indigo-400 font-semibold hover:text-indigo-300 hover:underline decoration-2 underline-offset-4 flex items-center gap-1 transition-all">
                                        Voir les détails
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                    
                                    @php
                                        $isRegistered = $event->users->contains(Auth::user());
                                    @endphp
                                    
                                    @if($isRegistered)
                                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/30 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Inscrit
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
