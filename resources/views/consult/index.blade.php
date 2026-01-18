@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">💬 Konsultasi & Chat</h1>
            <p class="text-gray-600">Hubungi admin untuk bantuan dan konsultasi belajar</p>
        </div>

        <!-- Chat Container -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Messages List -->
            <div class="lg:col-span-2">
                <!-- Send Message Form -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">✉️ Kirim Pesan Baru</h2>
                    <form id="sendMessageForm" action="{{ route('consult.send') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Judul pertanyaan Anda" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Chat Messages -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b-2 border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Pesan Saya</h2>
                    </div>
                    <div id="messagesList" class="divide-y max-h-96 overflow-y-auto">
                        @forelse($messages as $message)
                            <div class="p-6 hover:bg-gray-50 transition" data-message-id="{{ $message->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-gray-900 flex items-center">
                                        {{ $message->subject }}
                                        @if($message->is_admin_reply)
                                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">✓ Admin Balas</span>
                                        @endif
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        <button class="text-red-500 hover:text-red-700 delete-message" onclick="deleteMessage({{ $message->id }})">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-3">{{ $message->message }}</p>
                                <div class="flex items-center gap-2">
                                    @if(!$message->is_read)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Belum dibaca</span>
                                    @endif
                                    <span class="text-xs text-gray-500">
                                        @if($message->is_admin_reply)
                                            ✓ Admin Sudah Balas
                                        @else
                                            ⏳ Menunggu Balasan
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500">
                                <p class="text-lg mb-2">📭 Belum ada pesan</p>
                                <p>Kirim pertanyaan Anda di form atas untuk memulai konsultasi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div>
                <!-- Admin Status -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 mb-6 border-l-4 border-blue-600">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <span class="text-2xl mr-2">👨‍💼</span> Tim Admin
                    </h3>
                    <p class="text-gray-700 mb-4">
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            🟢 Online Sekarang
                        </span>
                    </p>
                    <p class="text-sm text-gray-600 mb-4">Tim kami siap membantu Anda 24/7</p>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>⏰ Respons waktu: < 2 jam</p>
                        <p>✓ Support dalam Bahasa Indonesia</p>
                    </div>
                </div>

                <!-- Helpful Tips -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 border-l-4 border-yellow-600">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <span class="text-2xl mr-2">💡</span> Tips
                    </h3>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Jelaskan masalah dengan detail</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Sertakan screenshot jika perlu</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Tunggu respons admin</span>
                        </li>
                    </ul>
                </div>

                <!-- Message Stats -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border-l-4 border-green-600">
                    <h3 class="font-bold text-gray-900 mb-4">📊 Statistik</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Total Pesan</p>
                            <p class="text-2xl font-bold text-green-600">{{ $messages->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Sudah Dibalas</p>
                            <p class="text-2xl font-bold text-green-600">{{ $messages->where('is_admin_reply', true)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert -->
<div id="successAlert" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center">
    <span class="mr-3">✓</span>
    <span id="successMessage"></span>
    <button class="ml-4 text-white hover:text-green-200" onclick="this.parentElement.classList.add('hidden')">✕</button>
</div>

<!-- Error Alert -->
<div id="errorAlert" class="hidden fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center">
    <span class="mr-3">✗</span>
    <span id="errorMessage"></span>
    <button class="ml-4 text-white hover:text-red-200" onclick="this.parentElement.classList.add('hidden')">✕</button>
</div>

<script>
document.getElementById('sendMessageForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("consult.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showSuccess(data.message);
            document.getElementById('sendMessageForm').reset();
            setTimeout(() => location.reload(), 2000);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Terjadi kesalahan: ' + error.message);
    }
});

function deleteMessage(messageId) {
    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        fetch(`{{ route('consult.delete', '') }}/${messageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Pesan berhasil dihapus');
                setTimeout(() => location.reload(), 1000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => showError('Terjadi kesalahan: ' + error.message));
    }
}

function showSuccess(message) {
    const alert = document.getElementById('successAlert');
    document.getElementById('successMessage').textContent = message;
    alert.classList.remove('hidden');
    setTimeout(() => alert.classList.add('hidden'), 4000);
}

function showError(message) {
    const alert = document.getElementById('errorAlert');
    document.getElementById('errorMessage').textContent = message;
    alert.classList.remove('hidden');
    setTimeout(() => alert.classList.add('hidden'), 4000);
}

// Auto-refresh messages
setInterval(function() {
    fetch('{{ route("consult.messages") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.messages.length > 0) {
                console.log('Messages updated', data.messages);
            }
        });
}, 30000); // Check every 30 seconds
</script>
@endsection
