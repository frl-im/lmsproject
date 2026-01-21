@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.users.progress.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                    ← Kembali ke Daftar User
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    👤 {{ $user->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold text-yellow-500">⭐ {{ $progress['xp'] }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total XP</div>
            </div>
        </div>

        <!-- User Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Global Rank</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $globalRank }}</p>
                    </div>
                    <div class="text-4xl">🏅</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Progress</p>
                        <p class="text-3xl font-bold text-green-600">{{ $progress['progress_percentage'] }}%</p>
                    </div>
                    <div class="text-4xl">📚</div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    {{ $progress['completed_lessons'] }}/{{ $progress['total_lessons'] }} materi
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Quiz Lolos</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $progress['quizzes_passed'] }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Dari {{ $progress['quiz_attempts'] }} kuis
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Sertifikat</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $progress['certificates'] }}</p>
                    </div>
                    <div class="text-4xl">🎖️</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Course Progress -->
            <div class="lg:col-span-2">
                <!-- Course Progress -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📖 Progress Materi</h2>
                    <div class="space-y-4">
                        @forelse($courseProgress as $item)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold text-gray-900 dark:text-white">
                                    {{ $item['course']->name }}
                                </h3>
                                <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $item['completed'] }}/{{ $item['total'] }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                {{ $item['percentage'] }}% Selesai
                            </p>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400">Belum ada progress materi</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quiz Results -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📝 Hasil Quiz</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($quizResults as $result)
                        <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 dark:text-white">
                                    {{ $result->lesson->name ?? 'Unknown' }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $result->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-lg">
                                    <span class="text-gray-900 dark:text-white">{{ $result->score }}%</span>
                                    @if($result->score >= 70)
                                        <span class="text-green-600">✅</span>
                                    @else
                                        <span class="text-red-600">❌</span>
                                    @endif
                                </div>
                                @if($result->xp_awarded > 0)
                                <p class="text-sm text-yellow-600">+{{ $result->xp_awarded }} XP</p>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400">Belum ada hasil quiz</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Certificates -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">🎖️ Sertifikat</h2>
                    
                    @if($certificates->count() > 0)
                    <div class="space-y-3 mb-6 max-h-80 overflow-y-auto">
                        @foreach($certificates as $cert)
                        <div class="bg-gradient-to-br {{ $cert->type === 'global_rank_1' || $cert->type === 'monthly_rank_1' ? 'from-yellow-100 to-yellow-200 dark:from-yellow-900 dark:to-yellow-800' : ($cert->type === 'global_rank_2' || $cert->type === 'monthly_rank_2' ? 'from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600' : 'from-orange-100 to-orange-200 dark:from-orange-900 dark:to-orange-800') }} rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-gray-900 dark:text-white">
                                    @if(str_contains($cert->type, 'rank_1'))
                                        🥇 Peringkat 1
                                    @elseif(str_contains($cert->type, 'rank_2'))
                                        🥈 Peringkat 2
                                    @elseif(str_contains($cert->type, 'rank_3'))
                                        🥉 Peringkat 3
                                    @else
                                        ✨ Sertifikat
                                    @endif
                                </span>
                                <button type="button" onclick="deleteCertificate({{ $cert->id }})" 
                                    class="text-red-600 hover:text-red-800 text-sm">
                                    ✕
                                </button>
                            </div>
                            <p class="text-xs text-gray-700 dark:text-gray-300">
                                {{ $cert->course ? $cert->course->name : 'Global' }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ $cert->earned_at->format('d/m/Y') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        Belum ada sertifikat
                    </p>
                    @endif

                    <!-- Award Certificate Button -->
                    <button type="button" onclick="openAwardModal({{ $user->id }})" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-bold">
                        🎖️ Berikan Sertifikat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Award Certificate Modal -->
<div id="awardModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">🎖️ Berikan Sertifikat</h3>
        
        <form id="certificateForm" onsubmit="submitCertificate(event)">
            @csrf
            <input type="hidden" name="user_ids[]" value="{{ $user->id }}">

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    Tipe Sertifikat
                </label>
                <select name="type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">- Pilih Tipe -</option>
                    <option value="global_rank_1">🥇 Peringkat 1 Global</option>
                    <option value="global_rank_2">🥈 Peringkat 2 Global</option>
                    <option value="global_rank_3">🥉 Peringkat 3 Global</option>
                    <option value="monthly_rank_1">🥇 Peringkat 1 Bulanan</option>
                    <option value="monthly_rank_2">🥈 Peringkat 2 Bulanan</option>
                    <option value="monthly_rank_3">🥉 Peringkat 3 Bulanan</option>
                    <option value="course_complete">✨ Selesai Kursus</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    Kursus (Opsional)
                </label>
                <select name="course_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">- Pilih Kursus -</option>
                    @foreach(\App\Models\Course::all() as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeAwardModal()" 
                    class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 font-bold">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-bold">
                    Berikan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAwardModal(userId) {
    document.getElementById('awardModal').classList.remove('hidden');
}

function closeAwardModal() {
    document.getElementById('awardModal').classList.add('hidden');
}

function submitCertificate(e) {
    e.preventDefault();
    
    const formData = new FormData(document.getElementById('certificateForm'));
    const data = Object.fromEntries(formData);
    
    if (!data.type) {
        alert('Pilih tipe sertifikat!');
        return;
    }

    fetch('{{ route("admin.certificates.award") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            type: data.type,
            course_id: data.course_id || null,
            user_ids: [{{ $user->id }}],
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    })
    .catch(err => {
        alert('Error: ' + err.message);
    });
}

function deleteCertificate(certId) {
    if (!confirm('Hapus sertifikat ini?')) return;

    fetch(`/admin/certificates/${certId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    })
    .catch(err => alert('Error: ' + err.message));
}

// Close modal on outside click
document.getElementById('awardModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAwardModal();
    }
});
</script>
@endsection
