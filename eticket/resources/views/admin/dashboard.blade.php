<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-8 rounded-2xl border border-white/10 shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-white uppercase tracking-widest text-xs mb-2 font-bold">Total Pendapatan Tiket</h3>
                    <p class="text-5xl font-display font-black text-white">
                        IDR <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600">{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </p>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/3 bg-green-500/10 blur-3xl"></div>
            </div>

            <div class="bg-slate-800 p-6 rounded-xl border border-white/10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-yellow-500 rounded-full"></span>
                    Permintaan Organizer ({{ $pendingOrganizers->count() }})
                </h3>
                
                @forelse($pendingOrganizers as $org)
                    <div class="flex flex-col md:flex-row justify-between items-center bg-slate-900/50 p-4 rounded-lg mb-3 border border-white/5 hover:border-yellow-500/30 transition">
                        <div class="mb-3 md:mb-0">
                            <p class="text-white font-bold text-lg">{{ $org->name }}</p>
                            <p class="text-sm text-gray-200">{{ $org->email }}</p>
                            <p class="text-xs text-yellow-500 mt-1">Status: Pending Approval</p>
                        </div>
                        <div class="flex gap-3">
                            <form action="{{ route('admin.approve', $org) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-lg transition">
                                    ✓ SETUJUI
                                </button>
                            </form>
                            <form action="{{ route('admin.reject', $org) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-lg transition">
                                    ✕ TOLAK
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-white border border-dashed border-gray-600 rounded-lg">
                        Tidak ada permintaan baru.
                    </div>
                @endforelse
            </div>

            <div class="bg-slate-800 p-6 rounded-xl border border-white/10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                    Manajemen Pengguna ({{ $allUsers->count() }})
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-white">
                        <thead class="text-xs uppercase bg-slate-700 text-white">
                            <tr>
                                <th class="px-4 py-3 rounded-tl-lg">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($allUsers as $user)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="px-4 py-3 font-bold text-white">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-200">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $user->role == 'organizer' ? 'bg-purple-900 text-purple-200' : 'bg-blue-900 text-blue-200' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($user->role == 'organizer')
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                            {{ $user->organizer_status == 'berhasil' ? 'text-green-400' : ($user->organizer_status == 'pending' ? 'text-yellow-400' : 'text-red-400') }}">
                                            {{ strtoupper($user->organizer_status) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.deleteUser', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen? Data event mereka juga akan hilang.');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-300 text-sm font-bold underline decoration-red-500/30 hover:decoration-red-500">
                                            Hapus User
                                        </button>
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