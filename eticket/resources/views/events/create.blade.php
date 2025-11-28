<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10">
                <div class="p-8 text-gray-100">
                    
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="border-b border-white/10 pb-8">
                            <h3 class="text-xl font-bold text-white mb-6">1. Detail Konser</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Nama Event</label>
                                    <input type="text" name="name" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-1">Kategori</label>
                                        <select name="kategori" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white">
                                            <option>Musik Pop</option><option>Rock Metal</option><option>Jazz</option><option>Indie</option><option>EDM</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-1">Tanggal</label>
                                        <input type="datetime-local" name="tanggal" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Lokasi</label>
                                    <input type="text" name="lokasi" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Deskripsi Event</label>
                                    <textarea name="deskripsi" rows="3" class="w-full bg-slate-900 border-slate-600 rounded-lg text-white"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Poster</label>
                                    <input type="file" name="image" class="w-full text-gray-400 border border-slate-600 rounded-lg bg-slate-900" required>
                                </div>
                            </div>
                        </div>

                        <div class="pb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-white">2. Atur Tiket</h3>
                                <button type="button" onclick="addTicketRow()" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-bold text-sm flex items-center gap-2">
                                    + Tambah Varian Tiket
                                </button>
                            </div>

                            <div id="ticket-container" class="space-y-4">
                                <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                                        <div class="md:col-span-3">
                                            <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                                            <input type="text" name="ticket_name" placeholder="Reguler" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Harga (Rp)</label>
                                            <input type="number" name="ticket_harga" placeholder="100000" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs text-gray-400 mb-1">Stok</label>
                                            <input type="number" name="ticket_kuota" placeholder="500" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs text-gray-400 mb-1">Deskripsi Tiket</label>
                                            <input type="text" name="ticket_deskripsi" placeholder="Benefit..." class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-white/10 pt-6">
                            <button type="submit" class="bg-fuchsia-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-fuchsia-700 shadow-lg transition w-full md:w-auto">
                                TERBITKAN EVENT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let ticketCount = 0;

        function addTicketRow() {
            const container = document.getElementById('ticket-container');
            const newRow = document.createElement('div');
            newRow.classList.add('bg-slate-900/50', 'p-4', 'rounded-lg', 'border', 'border-slate-700', 'relative');
            newRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-3">
                        <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                        <input type="text" name="tickets[${ticketCount}][name]" placeholder="VIP" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Harga</label>
                        <input type="number" name="tickets[${ticketCount}][harga]" placeholder="250000" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Stok</label>
                        <input type="number" name="tickets[${ticketCount}][kuota]" placeholder="50" class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm" required>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs text-gray-400 mb-1">Deskripsi Tiket</label>
                        <input type="text" name="tickets[${ticketCount}][deskripsi]" placeholder="Benefit tambahan..." class="w-full bg-slate-800 border-slate-600 rounded text-white text-sm">
                    </div>
                    <div class="md:col-span-1 flex items-end h-full pb-1">
                        <button type="button" onclick="this.closest('.bg-slate-900\\/50').remove()" class="text-red-500 hover:text-red-400 font-bold text-xl">✕</button>
                    </div>
                </div>
            `;
            
            container.appendChild(newRow);
            ticketCount++;
        }
    </script>
</x-app-layout>