<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-white/10 p-6">
                
                <h3 class="text-xl font-bold text-white mb-4">Daftar Persetujuan Organizer</h3>

                @if(isset($organizers) && $organizers->count() > 0)
                    <table class="w-full text-left text-gray-300">
                        <thead class="text-xs uppercase bg-slate-700 text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizers as $org)
                            <tr class="border-b border-slate-700">
                                <td class="px-6 py-4">{{ $org->name }}</td>
                                <td class="px-6 py-4">{{ $org->email }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.approve', $org) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                            Setujui
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">Tidak ada organizer yang menunggu persetujuan.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>