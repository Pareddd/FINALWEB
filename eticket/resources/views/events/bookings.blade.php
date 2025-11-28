<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            Manajemen Pesanan: {{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('organizer.dashboard') }}" class="text-gray-400 hover:text-white transition">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
            @endif

            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Daftar Pemesan Masuk</h3>
                    <div class="flex gap-2">
                        <div class="bg-yellow-500/20 border border-yellow-500 px-3 py-1 rounded text-xs text-yellow-500">
                            Pending: {{ $bookings->where('status', 'pending')->count() }}
                        </div>
                        <div class="bg-green-500/20 border border-green-500 px-3 py-1 rounded text-xs text-green-500">
                            Lunas: {{ $bookings->where('status', 'lunas')->count() }}
                        </div>
                    </div>
                </div>

                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-white">
                            <thead class="text-xs uppercase bg-slate-700 text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Pemesan</th>
                                    <th class="px-6 py-3">Tiket</th>
                                    <th class="px-6 py-3">Jml</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @foreach($bookings as $booking)
                                <tr class="hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $booking->id }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $booking->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-fuchsia-300">{{ $booking->ticket->name }}</td>
                                    <td class="px-6 py-4">{{ $booking->quantity }}</td>
                                    <td class="px-6 py-4">
                                        @if($booking->status == 'pending')
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-500/20 text-yellow-500 border border-yellow-500/50">PENDING</span>
                                        @elseif($booking->status == 'lunas')
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-green-500/20 text-green-500 border border-green-500/50">LUNAS</span>
                                        @else
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-red-500/20 text-red-500 border border-red-500/50">BATAL</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            
                                            @if($booking->status == 'pending')
                                                <form action="{{ route('bookings.updateStatus', $booking) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="lunas">
                                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold shadow-lg transition transform hover:scale-105">
                                                        ✓ TERIMA
                                                    </button>
                                                </form>
                                            @endif

                                            @if($booking->status != 'batal')
                                                <form action="{{ route('bookings.updateStatus', $booking) }}" method="POST" onsubmit="return confirm('Tolak/Batalkan pesanan ini?');">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="batal">
                                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold shadow-lg transition transform hover:scale-105">
                                                        ✕ TOLAK
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10 border border-dashed border-gray-600 rounded-lg">
                        <p class="text-gray-400">Belum ada pesanan masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>