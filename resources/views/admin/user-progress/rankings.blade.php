@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.users.progress.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Kembali ke Progress User
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 flex items-center gap-2">
                🏆 Ranking User
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Lihat peringkat dan berikan sertifikat kepada top 3</p>
        </div>

        <!-- Filter & Controls -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tipe Ranking</label>
                    <select id="rankingType" onchange="changeRanking()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="global" {{ $type === 'global' ? 'selected' : '' }}>🌍 Global (Semua XP)</option>
                        <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>📅 Bulanan (XP Bulan Ini)</option>
                        <option value="course" {{ $type === 'course' ? 'selected' : '' }}>📚 Per Kursus</option>
                    </select>
                </div>

                <div id="courseFilter" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Kursus</label>
                    <select id="courseSelect" onchange="changeRanking()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">- Pilih Kursus -</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $courseId == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Auto Award Button -->
            <button type="button" onclick="autoAwardTopThree()" 
                class="w-full md:w-auto px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:shadow-lg transition font-bold">
                ⚡ Auto-Award Top 3 Sertifikat
            </button>
        </div>

        <!-- Top 3 Highlight -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            @foreach($topUsers->take(3) as $user)
            <div class="bg-gradient-to-br {{ $loop->index === 0 ? 'from-yellow-400 to-yellow-600' : ($loop->index === 1 ? 'from-gray-300 to-gray-400' : 'from-orange-400 to-orange-600') }} rounded-lg shadow-lg p-6 text-white">
                <div class="text-5xl font-bold text-center mb-3">
                    @if($loop->index === 0) 🥇 @elseif($loop->index === 1) 🥈 @else 🥉 @endif
                </div>
                <h3 class="text-2xl font-bold text-center">{{ $user->name }}</h3>
                <p class="text-center opacity-90">{{ $user->email }}</p>
                
                <div class="mt-4 pt-4 border-t border-white border-opacity-30">
                    @if($type === 'global')
                    <p class="text-center text-lg font-bold">⭐ {{ $user->experience }} XP</p>
                    @elseif($type === 'monthly')
                    <p class="text-center text-lg font-bold">📅 {{ $user->monthly_xp ?? 0 }} XP</p>
                    @endif
                </div>

                <button type="button" onclick="openAwardModalForUser({{ $user->id }})" 
                    class="w-full mt-3 px-3 py-2 bg-white text-gray-900 rounded-lg hover:bg-gray-100 font-bold text-sm transition">
                    🎖️ Berikan Sertifikat
                </button>
            </div>
            @endforeach
        </div>

        <!-- Full Rankings Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">Peringkat</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">
                                @if($type === 'global') XP @elseif($type === 'monthly') XP Bulan Ini @else Score @endif
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Sertifikat</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($topUsers as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ $user->rank <= 3 ? 'bg-yellow-50 dark:bg-yellow-900 bg-opacity-50' : '' }}">
                            <td class="px-6 py-4">
                                <span class="inline-block text-2xl">
                                    @if($user->rank === 1) 🥇 @elseif($user->rank === 2) 🥈 @elseif($user->rank === 3) 🥉 @else {{ $user->rank }} @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full font-bold">
                                    @if($type === 'global')
                                        ⭐ {{ $user->experience }}
                                    @elseif($type === 'monthly')
                                        📅 {{ $user->monthly_xp ?? 0 }}
                                    @else
                                        📊 {{ $user->course_score ?? 0 }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full text-sm font-bold">
                                    🎖️ {{ $user->certificates_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                <a href="{{ route('admin.users.progress.show', $user) }}" 
                                    class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-bold transition">
                                    👁️
                                </a>
                                <button type="button" onclick="openAwardModalForUser({{ $user->id }})" 
                                    class="px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-bold transition">
                                    🎖️
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data ranking
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
            <input type="hidden" id="userIdInput" name="user_ids[]">

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
                    @foreach($courses as $course)
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
function changeRanking() {
    const type = document.getElementById('rankingType').value;
    const courseId = document.getElementById('courseSelect').value;
    const params = new URLSearchParams({
        type: type,
        course_id: courseId
    });
    window.location.href = `?${params}`;
}

function showCourseFilter() {
    const type = document.getElementById('rankingType').value;
    const filter = document.getElementById('courseFilter');
    if (type === 'course') {
        filter.classList.remove('hidden');
    } else {
        filter.classList.add('hidden');
    }
}

function openAwardModalForUser(userId) {
    document.getElementById('userIdInput').value = userId;
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
            user_ids: [parseInt(data['user_ids[]'])],
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

function autoAwardTopThree() {
    const type = document.getElementById('rankingType').value;
    const courseId = document.getElementById('courseSelect').value;
    
    if (type === 'course' && !courseId) {
        alert('Pilih kursus terlebih dahulu!');
        return;
    }

    if (!confirm(`Berikan sertifikat kepada 3 pengguna teratas?\n\nTipe: ${type}`)) {
        return;
    }

    const requestType = type === 'global' ? 'global_rank' : (type === 'monthly' ? 'monthly_rank' : 'course_rank');

    fetch('{{ route("admin.certificates.auto-award") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            type: requestType,
            course_id: courseId || null,
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        alert('Error: ' + err.message);
    });
}

// Show course filter if needed
showCourseFilter();

// Listen for type changes
document.getElementById('rankingType').addEventListener('change', showCourseFilter);

// Close modal on outside click
document.getElementById('awardModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAwardModal();
    }
});
</script>

<style>
    select {
        background-color: white;
    }
    
    @media (prefers-color-scheme: dark) {
        select {
            background-color: rgb(55 65 81);
            color: white;
        }
    }
</style>
@endsection
