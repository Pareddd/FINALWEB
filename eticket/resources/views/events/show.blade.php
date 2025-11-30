<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->name }} - SoundTix</title>
    
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
        .font-display { font-family: 'Orbitron', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-900 text-white overflow-x-hidden">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-black/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-fuchsia-600 to-purple-700 flex items-center justify-center shadow-[0_0_15px_rgba(192,38,211,0.6)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <a href="{{ route('home') }}" class="font-display font-bold text-2xl tracking-widest text-white hover:text-gray-300 transition">
                        SOUND<span class="text-fuchsia-500">TIX</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white font-bold border border-white/20 px-3 py-1 rounded hover:bg-white/10">ADMIN PANEL</a>
                        @elseif(Auth::user()->role === 'organizer')
                            <a href="{{ route('organizer.dashboard') }}" class="text-gray-300 hover:text-white font-bold border border-white/20 px-3 py-1 rounded hover:bg-white/10">ORGANIZER STUDIO</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white font-bold">TIKET SAYA</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-bold">LOGIN</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded relative">
                    <strong class="font-bold">Sukses!</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded relative">
                    <strong class="font-bold">Error!</strong> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-1">
                    <div class="sticky top-32">
                        <div class="relative rounded-2xl overflow-hidden shadow-[0_0_30px_rgba(192,38,211,0.3)] border border-white/10 group aspect-[3/4]">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center text-gray-500">No Image</div>
                            @endif
                            
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-fuchsia-600 text-white px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider shadow-lg">
                                    {{ $event->kategori ?? 'Event' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    
                    <div class="border-b border-white/10 pb-8 mb-8">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-2 leading-tight">
                                    {{ $event->name }}
                                </h1>
                                <p class="text-gray-400">by {{ $event->organizer->name ?? 'Unknown Organizer' }}</p>
                            </div>
                            
                            @auth
                                @if(auth()->user()->role == 'user')
                                    <form action="{{ route('events.favorite', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex flex-col items-center group">
                                            <div class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center transition group-hover:bg-white/10 {{ auth()->user()->favorites->contains($event->id) ? 'bg-fuchsia-600 border-fuchsia-600' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ auth()->user()->favorites->contains($event->id) ? 'text-white' : 'text-gray-400 group-hover:text-fuchsia-500' }}" fill="{{ auth()->user()->favorites->contains($event->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </div>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <div class="flex flex-col md:flex-row gap-6 mt-6 text-gray-300">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-fuchsia-500 border border-white/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Tanggal</p>
                                    <p class="font-bold text-white">
                                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        {{ \Carbon\Carbon::parse($event->tanggal)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-cyan-500 border border-white/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Lokasi</p>
                                    <p class="font-bold text-white">{{ $event->lokasi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h3 class="font-display text-xl font-bold text-white mb-4 uppercase tracking-wide">Tentang Event</h3>
                        <div class="prose prose-invert text-gray-400 leading-relaxed bg-slate-800/50 p-6 rounded-xl border border-white/5">
                            @if($event->deskripsi)
                                {!! nl2br(e($event->deskripsi)) !!}
                            @else
                                <span class="italic text-gray-600">Tidak ada deskripsi event.</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-white/5">
                        <h3 class="font-display text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-2 h-8 bg-fuchsia-600 rounded-full"></span>
                            PILIH TIKET
                        </h3>

                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                            <div class="bg-slate-900 border border-white/10 rounded-xl p-5 flex flex-col md:flex-row justify-between items-center hover:border-fuchsia-500/50 transition duration-300 group">
                                <div class="mb-4 md:mb-0 w-full md:w-auto">
                                    <h4 class="font-bold text-lg text-white group-hover:text-fuchsia-400 transition">{{ $ticket->name }}</h4>
                                    
                                    @if($ticket->deskripsi)
                                        <p class="text-sm text-gray-400 mt-1 max-w-md">{{ $ticket->deskripsi }}</p>
                                    @endif

                                    <p class="text-xl sm:text-2xl font-display font-bold text-white mt-2">
                                        IDR {{ number_format($ticket->harga, 0, ',', '.') }}
                                    </p>
                                    
                                    <p class="text-sm {{ $ticket->kuota > 0 ? 'text-green-400' : 'text-red-500' }} mt-1 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full {{ $ticket->kuota > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $ticket->kuota > 0 ? 'Tersedia: ' . $ticket->kuota : 'Sold Out' }}
                                    </p>
                                </div>

                                <div class="w-full md:w-auto">
                                    @auth
                                        @if(auth()->user()->role == 'user')
                                            @if($ticket->kuota > 0)
                                                <form action="{{ route('booking.store', $ticket) }}" method="POST" class="flex items-center gap-3 bg-black/40 p-2 rounded-lg border border-white/10">
                                                    @csrf
                                                    <input type="number" name="quantity" value="1" min="1" max="{{ $ticket->kuota }}" class="w-16 bg-slate-800 text-white text-center border-none rounded focus:ring-1 focus:ring-fuchsia-500 py-2">
                                                    <button type="submit" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-6 py-2 rounded font-bold transition shadow-lg whitespace-nowrap">
                                                        BELI
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled class="bg-slate-700 text-gray-400 px-6 py-3 rounded font-bold w-full md:w-auto cursor-not-allowed">
                                                    HABIS
                                                </button>
                                            @endif
                                        @elseif(auth()->user()->role == 'organizer' || auth()->user()->role == 'admin')
                                            <span class="text-xs text-gray-500 bg-slate-800 px-3 py-2 rounded border border-white/5 uppercase tracking-wider">Mode View Only</span>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="block text-center bg-white text-black hover:bg-gray-200 px-6 py-3 rounded font-bold transition w-full md:w-auto text-sm">
                                            LOGIN UNTUK BELI
                                        </a>
                                    @endauth
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="bg-black border-t border-white/10 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SoundTix. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>