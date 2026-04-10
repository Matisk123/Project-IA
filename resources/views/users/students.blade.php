<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Suivi des Étudiants') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="glass-card p-8 mb-8 rounded-3xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold text-white mb-2">Statistiques d'engagement</h3>
                    <p class="text-slate-400 max-w-2xl">
                        Consultez la participation des élèves aux salons et journées portes ouvertes. Suivez leur progression et leur taux d'assiduité.
                    </p>
                </div>
            </div>

            @if($students->isEmpty())
                <div class="glass-card rounded-3xl p-12 text-center">
                    <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-white font-bold text-lg">Aucun étudiant inscrit</p>
                    <p class="text-slate-400">Il n'y a actuellement aucun compte avec le rôle 'Élève'.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($students as $student)
                        <div class="glass-card rounded-3xl p-6 hover:-translate-y-1 transition-transform duration-300 flex flex-col">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-600/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 text-xl font-bold uppercase shadow-inner">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-white font-bold text-lg truncate">{{ $student->name }}</h4>
                                    <p class="text-slate-500 text-sm truncate">{{ $student->email }}</p>
                                </div>
                            </div>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400">Événements rejoints</span>
                                    <span class="text-white font-bold">{{ $student->total_events }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-400">Événements terminés</span>
                                    <span class="text-emerald-400 font-bold">{{ $student->finished_events }}</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-auto">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-[10px] uppercase font-black tracking-widest text-slate-500">Taux de complétion</span>
                                    <span class="text-xs font-bold text-white">{{ $student->total_events > 0 ? round(($student->finished_events / $student->total_events) * 100) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden border border-white/5">
                                    <div class="bg-gradient-to-r from-indigo-500 to-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $student->total_events > 0 ? ($student->finished_events / $student->total_events) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
