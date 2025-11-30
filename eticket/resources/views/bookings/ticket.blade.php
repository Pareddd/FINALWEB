<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $booking->ticket->event->name }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Raleway:wght@300;400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body { font-family: 'Raleway', sans-serif; }
        .font-display { font-family: 'Orbitron', sans-serif; }
        .ticket-perforation {
            border-left: 2px dashed rgba(255,255,255,0.2);
            position: relative;
        }
        /* Hiasan lubang sobekan */
        .ticket-perforation::before, .ticket-perforation::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #0f172a; /* Sesuaikan dengan bg body */
            border-radius: 50%;
            left: -11px;
        }
        .ticket-perforation::before { top: -10px; }
        .ticket-perforation::after { bottom: -10px; }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-6 text-white">

    <div class="max-w-4xl w-full">
        
        <div class="flex justify-between items-center mb-8" data-html2canvas-ignore="true">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white flex items-center gap-2 transition">
                &larr; Kembali ke Dashboard
            </a>
            <button onclick="downloadTicket()" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-6 py-2 rounded-full font-bold shadow-[0_0_15px_rgba(192,38,211,0.5)] transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                DOWNLOAD TIKET (PDF)
            </button>
        </div>

        <div id="ticket-card">
            <div class="bg-slate-800 rounded-3xl overflow-hidden shadow-2xl border border-white/10 flex flex-col md:flex-row relative">
                
                <div class="p-8 flex-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-fuchsia-600/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-sm font-bold text-fuchsia-500 tracking-widest uppercase mb-1">E-TICKET</p>
                            <h1 class="font-display text-3xl md:text-4xl font-bold text-white uppercase leading-tight">
                                {{ $booking->ticket->event->name }}
                            </h1>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-fuchsia-600 to-purple-700 flex items-center justify-center text-white font-bold text-xl shadow-lg border border-white/20">
                            SS
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                            <p class="font-bold text-white text-lg">
                                {{ \Carbon\Carbon::parse($booking->ticket->event->tanggal)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-300">
                                {{ \Carbon\Carbon::parse($booking->ticket->event->tanggal)->format('H:i') }} WIB
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Lokasi</p>
                            <p class="font-bold text-white text-lg">{{ $booking->ticket->event->lokasi }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jenis Tiket</p>
                            <p class="font-bold text-fuchsia-400 text-lg">{{ $booking->ticket->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jumlah</p>
                            <p class="font-bold text-white text-lg">{{ $booking->quantity }} Orang</p>
                        </div>
                    </div>

                    <div class="border-t border-white/10 pt-6 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pemesan</p>
                            <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Booking ID</p>
                            <p class="font-mono text-white tracking-widest">#{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-80 bg-slate-900/50 p-8 flex flex-col justify-center items-center relative ticket-perforation border-l border-white/10">
                    <div class="bg-white p-2 rounded-lg mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TIKET-{{ $booking->id }}-{{ Auth::user()->email }}" alt="QR Code" class="w-32 h-32">
                    </div>
                    
                    <p class="text-center text-xs text-gray-500 mb-2">Scan di pintu masuk</p>
                    <p class="text-center font-display font-bold text-white text-xl tracking-widest">ADMIT ONE</p>
                    
                    <div class="mt-6 w-full border-t border-white/10 pt-4 text-center">
                        <p class="text-[10px] text-gray-600 uppercase">Powered by SoundTix</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function downloadTicket() {
            // Ambil elemen tiket
            const element = document.getElementById('ticket-card');
            
            // Konfigurasi PDF
            const opt = {
                margin:       10,
                filename:     'E-Ticket-{{ $booking->id }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, backgroundColor: '#0f172a' }, // Background gelap sesuai tema
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            // Eksekusi Download
            html2pdf().set(opt).from(element).save();
        }
    </script>

</body>
</html>