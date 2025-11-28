<x-guest-layout>
    <div class="text-center text-white py-10 px-6">
        
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center border border-white/10 shadow-[0_0_20px_rgba(192,38,211,0.5)]">
                @if(Auth::user()->organizer_status == 'pending')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif(Auth::user()->organizer_status == 'berhasil')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif
            </div>
        </div>

        <h2 class="text-2xl font-bold font-display mb-2 text-white">Status Akun: 
            <span class="
                {{ Auth::user()->organizer_status == 'pending' ? 'text-yellow-400' : '' }}
                {{ Auth::user()->organizer_status == 'berhasil' ? 'text-green-400' : '' }}
                {{ Auth::user()->organizer_status == 'ditolak' ? 'text-red-500' : '' }}
            ">
                {{ ucfirst(Auth::user()->organizer_status) }}
            </span>
        </h2>
        
        @if(Auth::user()->organizer_status == 'pending')
            <p class="text-gray-400 mb-8">Mohon bersabar! Akun Organizer Anda sedang ditinjau oleh Admin.<br>Kami akan memberitahu jika sudah aktif.</p>
        
        @elseif(Auth::user()->organizer_status == 'berhasil')
            <p class="text-gray-400 mb-8">Selamat! Akun Anda sudah aktif.</p>
            <a href="{{ route('organizer.dashboard') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold mb-4">
                MASUK KE DASHBOARD
            </a>

        @elseif(Auth::user()->organizer_status == 'ditolak')
            <div class="max-w-md mx-auto bg-red-900/20 border border-red-500 p-6 rounded-xl mb-6">
                <p class="text-red-300 mb-4 font-semibold">Maaf, pengajuan Anda ditolak.</p>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <input type="password" name="password" placeholder="Password untuk hapus akun" class="bg-slate-900 text-white border-slate-700 rounded px-4 py-2 w-full text-sm" required>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold w-full text-sm">
                            HAPUS AKUN
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="mt-8 border-t border-white/10 pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-white underline text-sm font-bold tracking-wider">
                    LOG OUT / KELUAR
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>