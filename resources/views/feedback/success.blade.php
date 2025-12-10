<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Feedback PLN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-cyan-700 to-cyan-900 min-h-screen flex items-center justify-center">
    <!-- Modal Success -->
    <div id="modal-success-root"></div>
    <a id="back-to-form" href="{{ route('feedback.create') }}" 
       class="inline-block px-8 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition">
        Kembali ke Form
    </a>
    <script>
    // Render modal only after JS runs, to prevent any flash
    window.onload = function() {
        var root = document.getElementById('modal-success-root');
        root.innerHTML = `
        <div id="modal-success" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
            <div class="relative bg-white rounded-xl shadow-2xl p-4 sm:p-8 md:p-10 text-center border-t-8 border-yellow-400 animate-pop-up w-full max-w-xs sm:max-w-sm mx-auto">
                <div class="flex flex-col items-center justify-center mb-4">
                    <div class="bg-yellow-400 rounded-full shadow p-3 mb-2">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#ffe600"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12l3 3 5-5" stroke="#17687a" stroke-width="2"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-cyan-800 mb-2 animate-fade-in">Feedback Berhasil Dikirim</h2>
                </div>
                <p class="mb-6 text-gray-700 text-base animate-fade-in">Terima kasih atas partisipasi Anda dalam pengisian survei implementasi inovasi PLN.<br>Kami sangat menghargai masukan Anda.</p>
                <button id="btn-ok" class="px-10 py-2 bg-cyan-700 text-white font-semibold rounded shadow hover:bg-cyan-800 transition animate-fade-in">OK</button>
                <style>
                @keyframes pop-up {
                  0% { transform: scale(0.7); opacity: 0; }
                  80% { transform: scale(1.05); opacity: 1; }
                  100% { transform: scale(1); opacity: 1; }
                }
                .animate-pop-up { animation: pop-up 0.5s cubic-bezier(.68,-0.55,.27,1.55); }
                @keyframes fade-in {
                  from { opacity: 0; }
                  to { opacity: 1; }
                }
                .animate-fade-in { animation: fade-in 1s; }
                </style>
            </div>
        </div>
        `;
        var btn = document.getElementById('btn-ok');
        var timeout = setTimeout(function() {
            window.location.href = document.getElementById('back-to-form').href;
        }, 2500);
        btn.onclick = function() {
            clearTimeout(timeout);
            window.location.href = document.getElementById('back-to-form').href;
        };
    };
    </script>
</body>
</html>