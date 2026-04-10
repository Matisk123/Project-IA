<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Modifier l\'événement') }}: <span class="text-indigo-600">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card shadow-sm sm:rounded-3xl border border-slate-700">
                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-400">
                            <ul class="list-disc list-inside text-sm font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Titre -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-bold text-slate-300 mb-1">Titre de l'événement *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-bold text-slate-300 mb-1">Type *</label>
                                <select name="type" id="type" required class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow @error('type') border-red-500 @enderror">
                                    <option value="jpo" {{ old('type', $event->type) == 'jpo' ? 'selected' : '' }}>Journée Portes Ouvertes (JPO)</option>
                                    <option value="salon" {{ old('type', $event->type) == 'salon' ? 'selected' : '' }}>Salon Étudiant</option>
                                </select>
                                @error('type')
                                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date/Heure -->
                            <div>
                                <label for="date" class="block text-sm font-bold text-slate-300 mb-1">Date et Heure *</label>
                                <input type="datetime-local" name="date" id="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow @error('date') border-red-500 @enderror">
                                @error('date')
                                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lieu -->
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-bold text-slate-300 mb-1">Lieu *</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow @error('location') border-red-500 @enderror">
                                @error('location')
                                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-bold text-slate-300 mb-1">Description générale *</label>
                                <textarea name="description" id="description" rows="3" required class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Détails Optionnels -> Section -->
                            <div class="md:col-span-2 border-t border-slate-700 pt-6 mt-2">
                                <h3 class="text-lg font-bold text-indigo-400 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Informations d'organisation (Optionnel)
                                </h3>
                            </div>

                            <!-- Sujets -->
                            <div class="md:col-span-2">
                                <label for="subjects" class="block text-sm font-bold text-slate-300 mb-1">Sujets présentés</label>
                                <textarea name="subjects" id="subjects" rows="2" class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow">{{ old('subjects', $event->subjects) }}</textarea>
                            </div>

                            <!-- Elements à ramener -->
                            <div>
                                <label for="requirements" class="block text-sm font-bold text-slate-300 mb-1">Éléments à ramener par les élèves</label>
                                <textarea name="requirements" id="requirements" rows="3" class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow">{{ old('requirements', $event->requirements) }}</textarea>
                            </div>

                            <!-- Guides -->
                            <div>
                                <label for="guides" class="block text-sm font-bold text-slate-300 mb-1">Guides</label>
                                <textarea name="guides" id="guides" rows="3" class="w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 transition-shadow">{{ old('guides', $event->guides) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-700">
                            <a href="{{ route('events.show', $event) }}" class="text-slate-400 hover:text-white font-medium">Annuler</a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
