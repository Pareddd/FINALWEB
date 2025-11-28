<x-guest-layout>
    <div class="text-center text-white py-12 px-6">
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center border border-white/10 shadow-[0_0_20px_rgba(192,38,211,0.5)]">
                @if(Auth::user()->organizer_status == 'pending')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>
        </div>

        <h2 class="text-3xl font-bold font-display mb-2 text-white">Status Akun: 
            <span class="{{ Auth::user()->organizer_status == 'pending' ? 'text-yellow-400' : 'text-red-500' }}">
                {{ ucfirst(Auth::user()->organizer_status) }}
            </span>
        </h2>
        
        @if(Auth::user()->organizer_status == 'pending')
            <p class="text-gray-400 mb-8 text-lg">Mohon bersabar! Akun Organizer Anda sedang ditinjau oleh Admin.<br>Kami akan memberitahu jika sudah aktif.</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white bg-slate-700 hover:bg-slate-600 px-6 py-2 rounded font-bold transition">Log Out</button>
            </form>
        @elseif(Auth::user()->organizer_status == 'ditolak')
            <div class="max-w-md mx-auto bg-red-900/20 border border-red-500 p-6 rounded-xl">
                <p class="text-red-300 mb-4 font-semibold">Maaf, pengajuan Anda ditolak oleh Admin.</p>
                <p class="text-sm text-gray-400 mb-4">Silakan hapus akun ini jika ingin mencoba mendaftar ulang dengan data yang benar.</p>
                
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="flex flex-col gap-3">
                        <input type="password" name="password" placeholder="Masukkan Password untuk Konfirmasi" class="bg-slate-900 text-white border-slate-700 rounded px-4 py-2 w-full focus:ring-red-500" required>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold w-full transition shadow-lg">
                            HAPUS AKUN PERMANEN
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-guest-layout>