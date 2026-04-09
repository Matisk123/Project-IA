<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Engagement Manager - JPO & Salons</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .bg-pattern {
            background-image: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .animated-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.4) 0%, rgba(168, 85, 247, 0.4) 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 0;
            animation: moveBlob 15s infinite alternate ease-in-out;
        }

        .blob-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, rgba(236, 72, 153, 0.3) 0%, rgba(244, 63, 94, 0.3) 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 0;
            right: 10%;
            bottom: 10%;
            animation: moveBlob2 18s infinite alternate ease-in-out;
        }

        @keyframes moveBlob {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(100px, 50px) scale(1.1); }
            100% { transform: translate(-50px, 150px) scale(0.9); }
        }

        @keyframes moveBlob2 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-100px, -100px) scale(1.2); }
            100% { transform: translate(50px, -50px) scale(0.8); }
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-white min-h-screen relative overflow-x-hidden flex flex-col selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Background -->
    <div class="blob top-[-10%] left-[-5%] pointer-events-none"></div>
    <div class="blob-2 pointer-events-none"></div>
    <div class="absolute inset-0 bg-slate-950/50 z-0 pointer-events-none"></div>
    <div class="absolute inset-0 bg-pattern z-0 opacity-50 pointer-events-none"></div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="relative z-50 flex justify-between items-center px-8 py-6 max-w-7xl mx-auto w-full">
            <div class="flex items-center gap-2 group cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 transition-all duration-300 transform group-hover:scale-105">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-100">Engagement<span class="text-indigo-400">Manager</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold rounded-full bg-white/10 hover:bg-white/20 border border-white/10 backdrop-blur-md transition-all duration-300 hover:scale-105">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 shadow-lg shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-indigo-500/50">Rejoindre</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex flex-col items-center justify-center pt-8 pb-16 px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-300 text-sm font-medium mb-8 backdrop-blur-sm animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                Participez au rayonnement de l'école
            </div>
            
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tight mb-6 max-w-5xl leading-tight">
                Gérez vos <span class="animated-text">JPO & Salons</span> avec élégance.
            </h1>
            
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mb-12 font-medium">
                La plateforme incontournable pour les responsables d'engagements et les élèves. Organisez, préparez et participez aux événements qui mettent en valeur notre école d'informatique.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 w-full justify-center px-4">
                @auth
                    <a href="{{ route('events.index') }}" class="px-8 py-4 rounded-full bg-white text-slate-900 font-bold text-lg shadow-xl shadow-white/10 hover:shadow-white/20 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Voir les événements
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 font-bold text-lg shadow-xl shadow-indigo-600/30 hover:shadow-indigo-500/50 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        S'engager maintenant
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-24 max-w-6xl w-full text-left">
                <div class="glass-card p-6 rounded-3xl hover:-translate-y-2 transition-transform duration-500">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Organisation simplifiée</h3>
                    <p class="text-slate-400">Planifiez les dates, les lieux et les responsables de chaque Journée Portes Ouvertes.</p>
                </div>
                
                <div class="glass-card p-6 rounded-3xl hover:-translate-y-2 transition-transform duration-500">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Préparation complète</h3>
                    <p class="text-slate-400">Gérez les sujets présentés, le matériel requis et les guides d'applications spécifiques à l'IA.</p>
                </div>
                
                <div class="glass-card p-6 rounded-3xl hover:-translate-y-2 transition-transform duration-500">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/20 text-pink-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Engagement étudiant</h3>
                    <p class="text-slate-400">Les élèves peuvent s'inscrire facilement en 1 clic pour participer et défendre les couleurs de l'école.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
