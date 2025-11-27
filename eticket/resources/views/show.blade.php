<x-guest-layout>
    <div class="container mx-auto py-10 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded shadow-lg p-6">
            <div class="flex justify-between items-start">
                <h1 class="text-3xl font-bold">{{ $event->name }}</h1>

                @auth
                    <form action="{{ route('events.favorite', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 border rounded {{ auth()->user()->favorites->contains($event->id) ? 'bg-red-100 text-red-600 border-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ auth()->user()->favorites->contains($event->id) ? '❤️ Tersimpan' : '🤍 Simpan Favorit' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" onclick="return confirm('Silakan login untuk menyimpan ke favorit.')" class="px-4 py-2 border rounded text-gray-400 hover:bg-gray-50">
                        🤍 Favorit
                    </a>
                @endauth
            </div>

            <p class="text-gray-600 mt-2">Lokasi: {{ $event->location }} | Waktu: {{ $event->date_time }}</p>
            <p class="mt-4 text-gray-800">{{ $event->description }}</p>

            <hr class="my-6">

            <h3 class="text-xl font-bold mb-4">Tiket Tersedia</h3>
            <div class="space-y-3">
                @foreach($event->tickets as $ticket)
                <div class="border p-4 rounded flex justify-between items-center">
                    <div>
                        <div class="font-bold text-lg">{{ $ticket->name }}</div>
                        <div class="text-gray-600">Rp {{ number_format($ticket->price) }}</div>
                        <div class="text-sm text-gray-500">Sisa: {{ $ticket->quota }}</div>
                    </div>

                    @auth
                        @if($ticket->quota > 0)
                            <form action="{{ route('booking.store', $ticket) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $ticket->quota }}" class="border rounded w-16 p-1 text-center">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Beli</button>
                            </form>
                        @else
                            <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded cursor-not-allowed">Habis</button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-100 text-blue-600 px-4 py-2 rounded hover:bg-blue-200">
                            Login untuk Pesan
                        </a>
                    @endauth
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>