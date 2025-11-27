<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-fuchsia-400 leading-tight font-display">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border border-white/10">
                <div class="p-8 text-gray-100">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="border-b border-white/10 pb-6">
                            <h3 class="text-lg font-bold text-white mb-4">1. Detail Konser</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Nama Event</label>
                                <input type="text" name="name" class="w-full bg-slate-900 border border-slate-600 rounded text-white" required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Kategori</label>
                                    <select name="category" class="w-full bg-slate-900 border border-slate-600 rounded text-white">
                                        <option value="Musik Pop">Musik Pop</option>
                                        <option value="Rock/Metal">Rock / Metal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 text-gray-400">Tanggal</label>
                                    <input type="datetime-local" name="date_time" class="w-full bg-slate-900 border border-slate-600 rounded text-white" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Lokasi</label>
                                <input type="text" name="location" class="w-full bg-slate-900 border border-slate-600 rounded text-white" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Deskripsi</label>
                                <textarea name="description" rows="4" class="w-full bg-slate-900 border border-slate-600 rounded text-white"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2 text-gray-400">Poster</label>
                                <input type="file" name="image" class="w-full text-gray-400" required>
                            </div>
                        </div>

                        <div class="border-b border-white/10 pb-6">
                            <h3 class="text-lg font-bold text-white mb-4">2. Tiket Pertama</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <input type="text" name="ticket_name" placeholder="Nama Tiket" class="bg-slate-900 border border-slate-600 rounded text-white" required>
                                <input type="number" name="ticket_price" placeholder="Harga" class="bg-slate-900 border border-slate-600 rounded text-white" required>
                                <input type="number" name="ticket_quota" placeholder="Stok" class="bg-slate-900 border border-slate-600 rounded text-white" required>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('organizer.dashboard') }}" class="bg-slate-700 text-white px-6 py-2 rounded">Batal</a>
                            <button type="submit" class="bg-fuchsia-600 text-white px-8 py-2 rounded hover:bg-fuchsia-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>