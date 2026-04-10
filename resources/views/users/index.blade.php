<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Gestion des Utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Search / Header Info -->
            <div class="glass-card p-6 mb-6 rounded-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Membres de l'organisation</h3>
                    <p class="text-slate-400 text-sm">Gérez les privilèges des élèves et des responsables.</p>
                </div>
                <div class="bg-indigo-500/20 text-indigo-400 px-4 py-2 rounded-xl border border-indigo-500/30 text-sm font-bold">
                    {{ $users->count() }} Autres inscrits
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="glass-card overflow-hidden shadow-xl sm:rounded-3xl border border-slate-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700 bg-slate-900/50">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Utilisateur</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Rôle Actuel</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Actions (Modification Directe)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($users as $user)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-indigo-400 font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-white font-bold">{{ $user->name }}</div>
                                                <div class="text-slate-400 text-sm">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $user->role === 'manager' ? 'bg-purple-500/20 text-purple-400 border-purple-500/30' : 'bg-slate-700/50 text-slate-300 border-slate-600' }}">
                                            {{ $user->role === 'manager' ? 'MANAGER / ADMIN' : 'STUDENT / ÉLÈVE' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('users.update-role', $user) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="bg-slate-900 border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 transition-all cursor-pointer">
                                                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Élève</option>
                                                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
