<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">Admin Dashboard</h2>
            <a href="{{ route('events.create') }}" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-4 py-2 rounded text-sm font-bold transition shadow-lg whitespace-nowrap">
                + BUAT EVENT
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-8 rounded-2xl border border-white/10 shadow-2xl relative overflow-hidden mx-4 sm:mx-0">
                <div class="relative z-10">
                    <h3 class="text-white uppercase tracking-widest text-xs mb-2 font-bold">Total Pendapatan Tiket</h3>
                    <p class="text-3xl sm:text-5xl font-display font-black text-white">
                        IDR <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600">{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </p>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/3 bg-green-500/10 blur-3xl"></div>
            </div>

            <div class="bg-slate-800 p-4 sm:p-6 rounded-xl border border-white/10 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-fuchsia-500 rounded-full"></span>
                    Kelola Seluruh Acara ({{ $allEvents->count() }})
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-white min-w-[800px]">
                        <thead class="text-xs uppercase bg-slate-700 text-white">
                            <tr>
                                <th class="px-4 py-3 whitespace-nowrap">Nama Event</th>
                                <th class="px-4 py-3 whitespace-nowrap">Organizer</th>
                                <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                                <th class="px-4 py-3 whitespace-nowrap">Lokasi</th>
                                <th class="px-4 py-3 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($allEvents as $event)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="px-4 py-3 font-bold text-white">{{ $event->name }}</td>
                                <td class="px-4 py-3 text-gray-300">
                                    {{ $event->organizer->name }}
                                    @if($event->user_id == Auth::id()) 
                                        <span class="text-xs text-fuchsia-400 font-bold">(Admin)</span> 
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-300">{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-gray-300 text-sm">{{ $event->lokasi }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('events.bookings', $event) }}" class="text-green-400 hover:text-green-300 text-sm font-bold underline whitespace-nowrap">
                                            Laporan
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-bold underline whitespace-nowrap">
                                            Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Hapus event ini secara permanen?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-400 text-sm font-bold underline whitespace-nowrap">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-slate-800 p-4 sm:p-6 rounded-lg border border-white/10 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-white mb-4">Request Organizer</h3>
                
                <div class="overflow-x-auto">
                    <div class="min-w-[600px]">
                        @forelse($pendingOrganizers as $org)
                            <div class="flex justify-between items-center border-b border-slate-700 py-3">
                                <div>
                                    <p class="text-white font-bold">{{ $org->name }}</p>
                                    <p class="text-sm text-gray-200">{{ $org->email }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.approve', $org) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm whitespace-nowrap">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.reject', $org) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="bg-red-600 text-white px-3 py-1 rounded text-sm whitespace-nowrap">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-white italic">Tidak ada permintaan baru.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 p-4 sm:p-6 rounded-lg border border-white/10 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-white mb-4">Daftar Semua User</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-white min-w-[800px]">
                        <thead class="text-xs uppercase bg-slate-700 text-white">
                            <tr>
                                <th class="px-4 py-2 whitespace-nowrap">Nama</th>
                                <th class="px-4 py-2 whitespace-nowrap">Email</th>
                                <th class="px-4 py-2 whitespace-nowrap">Role</th>
                                <th class="px-4 py-2 whitespace-nowrap">Status</th>
                                <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allUsers as $user)
                            <tr class="border-b border-slate-700">
                                <td class="px-4 py-2 font-bold text-white">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-gray-200">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ strtoupper($user->role) }}</td>
                                <td class="px-4 py-2">{{ strtoupper($user->organizer_status) }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('admin.deleteUser', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-300 text-sm underline whitespace-nowrap">Hapus User</button>
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