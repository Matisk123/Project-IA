<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour aux événements
                </a>
                <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                    {{ $event->title }}
                </h2>
            </div>
            
            <div class="flex gap-2">
                @if(Auth::user()->role === 'manager')
                    <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl shadow-sm hover:bg-gray-50 flex items-center gap-2 font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Modifier
                    </a>
                    
                    <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-white border border-red-200 text-red-600 rounded-xl shadow-sm hover:bg-red-50 flex items-center gap-2 font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                @endif
                
                @php
                    $isRegistered = $event->users->contains(Auth::user());
                @endphp
                
                <form action="{{ route('events.register.toggle', $event) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 rounded-xl shadow-sm font-semibold flex items-center gap-2 transition-all transform hover:-translate-y-0.5 {{ $isRegistered ? 'bg-red-50 text-red-600 border border-red-200 hover:bg-red-100' : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:shadow-md hover:shadow-indigo-500/30' }}">
                        @if($isRegistered)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Se désinscrire
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            M'inscrire
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">
            
            <!-- Main Content -->
            <div class="flex-grow space-y-6">
                <!-- Description -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">À propos</h3>
                    <p class="text-gray-600 whitespace-pre-line">{{ $event->description }}</p>
                </div>

                <!-- Organization Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Sujets présentés</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $event->subjects ?: 'À définir' }}</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Éléments à ramener</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $event->requirements ?: 'À définir' }}</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Guides (Démos IA)</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $event->guides ?: 'À définir' }}</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="w-full md:w-80 flex-shrink-0 space-y-6">
                <!-- Info Card -->
                <div class="bg-gray-900 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                    
                    <div class="relative z-10 space-y-6">
                        <div>
                            <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Date & Heure</p>
                            <p class="font-bold text-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->date->format('d/m/Y \à H:i') }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Lieu</p>
                            <p class="font-bold text-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->location }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Type d'Événement</p>
                            <p class="font-bold border border-white/20 bg-white/10 backdrop-blur-sm inline-block px-3 py-1 rounded-lg">
                                {{ $event->type === 'jpo' ? 'Portes Ouvertes' : 'Salon Étudiant' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Students Registered -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center justify-between">
                        Élèves inscrits
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-extrabold px-2 py-1 rounded-full">{{ $event->users->count() }}</span>
                    </h4>
                    
                    @if($event->users->isEmpty())
                        <p class="text-sm text-gray-500 italic">Aucun inscrit pour le moment.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($event->users as $registeredUser)
                                <li class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($registeredUser->name, 0, 2) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $registeredUser->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
