<div style="font-family: sans-serif; padding: 2rem;">
    <a href="{{ route('admin.modules.lessons.index', $module) }}" style="color: #6c757d; text-decoration: none;">&larr; Kembali ke Daftar Lessons</a>
    <h1 style="margin-top: 1rem;">Edit Lesson di Module: <span style="color: #007bff;">{{ $module->title }}</span></h1>

    <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem;">Judul Lesson</label>
            <input type="text" id="title" name="title" value="{{ old('title', $lesson->title) }}" style="width: 100%; padding: 0.5rem;" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="type" style="display: block; margin-bottom: 0.5rem;">Tipe Lesson</label>
            <select name="type" id="type" style="width: 100%; padding: 0.5rem;" required>
                <option value="materi" @selected(old('type', $lesson->type) == 'materi')>Materi</option>
                <option value="kuis" @selected(old('type', $lesson->type) == 'kuis')>Kuis</option>
                <option value="studi_kasus" @selected(old('type', $lesson->type) == 'studi_kasus')>Studi Kasus</option>
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="content" style="display: block; margin-bottom: 0.5rem;">Konten (untuk tipe materi)</label>
            <textarea name="content" id="content" rows="10" style="width: 100%; padding: 0.5rem;">{{ old('content', $lesson->content) }}</textarea>
        </div>

        <div>
            <button type="submit" style="background-color: #28a745; color: white; padding: 0.75rem 1.5rem; border: none; cursor: pointer;">Update</button>
        </div>
    </form>
</div>