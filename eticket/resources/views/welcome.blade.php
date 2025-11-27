<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoundStage - Tiket Konser</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Raleway:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #0f172a; /* Slate 900 */
            color: #ffffff;
            font-family: 'Raleway', sans-serif;
        }
        .font-display {
            font-family: 'Orbitron', sans-serif;
        }
        .neon-text {
            text-shadow: 0 0 5px #fff, 0 0 10px #d946ef, 0 0 20px #d946ef;
        }
    </style>
</head>
<body class="antialiased bg-slate-900 text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-black/60 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-fuchsia-600 to-purple-700 flex items-center justify-center shadow-[0_0_15px_rgba(192,38,211,0.6)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <a href="{{ route('home') }}" class="font-display font-bold text-2xl tracking-widest text-white hover:text-gray-200 transition">
                        SOUND<span class="text-fuchsia-500">STAGE</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition font-bold tracking-wide border border-fuchsia-500/50 px-4 py-2 rounded hover:bg-fuchsia-900/50">
                                    ADMIN PANEL
                                </a>
                            @elseif(Auth::user()->role === 'organizer')
                                <a href="{{ route('organizer.dashboard') }}" class="text-gray-300 hover:text-white transition font-bold tracking-wide border border-fuchsia-500/50 px-4 py-2 rounded hover:bg-fuchsia-900/50">
                                    ORGANIZER STUDIO
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition font-bold tracking-wide">
                                    MY TICKETS
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition font-bold tracking-wide text-sm">LOGIN</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-bold text-white bg-fuchsia-600 hover:bg-fuchsia-700 transition skew-x-[-10deg] border border-fuchsia-400 shadow-[0_0_10px_rgba(192,38,211,0.5)]">
                                    <span class="skew-x-[10deg] inline-block">JOIN NOW</span>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>
    
    <div class="relative h-screen flex items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=2070&auto=format&fit=crop" alt="Concert" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-purple-900/40 to-slate-900"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-10">
            <div class="inline-block border border-fuchsia-500/50 bg-black/30 backdrop-blur px-4 py-1 rounded-full mb-6">
                <span class="text-fuchsia-400 text-xs font-bold tracking-[0.3em] uppercase">The Ultimate Music Experience</span>
            </div>
            
            <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-black text-white mb-6 leading-tight">
                FEEL THE <br/> <span class="neon-text">RHYTHM</span>
            </h1>
            
            <p class="text-gray-200 text-lg md:text-xl mb-10 max-w-2xl mx-auto font-light tracking-wide">
                Dapatkan tiket eksklusif konser band favoritmu. Jangan lewatkan momen bersejarah di panggung impian.
            </p>

            <form action="{{ route('home') }}" method="GET" class="max-w-xl mx-auto relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-fuchsia-600 to-blue-600 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative flex bg-black rounded-lg border border-white/20">
                    <input type="text" name="search" placeholder="Cari Artis, Band, atau Kota..." 
                           class="w-full bg-transparent text-white border-none focus:ring-0 px-6 py-4 placeholder-gray-500 outline-none"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-white text-black font-black px-8 py-2 m-1 rounded hover:bg-gray-200 transition uppercase tracking-widest text-sm">
                        CARI
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-24 relative bg-slate-900">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-fuchsia-500 to-transparent opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12 border-b border-white/10 pb-4">
                <div>
                    <h2 class="text-4xl font-display font-bold text-white mb-2">UPCOMING <span class="text-fuchsia-500">GIGS</span></h2>
                </div>
                <div class="hidden md:block">
                    <span class="text-gray-400 text-sm tracking-widest">SCROLL DOWN FOR MORE</span>
                </div>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                    <div class="group relative bg-gray-800 rounded-xl overflow-hidden hover:-translate-y-2 transition-all duration-300 shadow-2xl border border-white/5">
                        
                        <div class="relative h-64 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent z-10 opacity-80"></div>
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <img src="https://source.unsplash.com/random/800x600/?concert&sig={{ $event->id }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 grayscale group-hover:grayscale-0">
                            @endif

                            <div class="absolute top-4 right-4 z-20 bg-black/80 border border-fuchsia-500 text-center px-3 py-2 rounded">
                                <span class="block text-2xl font-bold font-display text-white">{{ \Carbon\Carbon::parse($event->date_time)->format('d') }}</span>
                                <span class="block text-xs text-fuchsia-400 uppercase">{{ \Carbon\Carbon::parse($event->date_time)->format('M') }}</span>
                            </div>
                        </div>

                        <div class="p-6 relative z-20 -mt-12">
                            <span class="text-xs font-bold tracking-widest text-blue-400 uppercase mb-2 block">{{ $event->category }}</span>
                            
                            <h3 class="text-2xl font-bold text-white mb-2 font-display leading-tight group-hover:text-fuchsia-400 transition">
                                {{ $event->name }}
                            </h3>
                            
                            <div class="flex items-center text-gray-400 text-sm mb-6">
                                📍 {{ $event->location }}
                            </div>

                            <div class="flex items-center justify-between border-t border-white/10 pt-4">
                                <div>
                                    <span class="text-xs text-gray-500 block uppercase">Mulai Dari</span>
                                    @if($event->tickets->count() > 0)
                                        <span class="text-lg font-bold text-white">IDR {{ number_format($event->tickets->min('price')/1000, 0) }}K</span>
                                    @else
                                        <span class="text-lg font-bold text-white">TBA</span>
                                    @endif
                                </div>
                                <a href="{{ route('events.show', $event) }}" class="bg-white text-black hover:bg-fuchsia-500 hover:text-white px-6 py-2 rounded-full font-bold text-sm transition-colors duration-300">
                                    TIKET
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10 border-dashed">
                    <h3 class="text-2xl font-display text-white mb-2">Belum Ada Jadwal</h3>
                    <p class="text-gray-400">Panggung sedang disiapkan. Cek lagi nanti!</p>
                </div>
            @endif
            </div>
    </div>

    <footer class="bg-black border-t border-white/10 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="font-display text-2xl font-bold text-white mb-4">SOUND<span class="text-fuchsia-500">STAGE</span></h2>
            <p class="text-gray-500 text-sm mb-8">Platform tiket konser terpercaya di Indonesia.</p>
            <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} SoundStage. Keep Rocking! 🤘</p>
        </div>
    </footer>

</body>
</html>