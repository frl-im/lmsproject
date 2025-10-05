<div style="font-family: sans-serif; padding: 2rem;">
    <a href="{{ route('admin.courses.modules.index', $course) }}" style="color: #6c757d; text-decoration: none;">&larr; Kembali ke Daftar Modules</a>
    <h1 style="margin-top: 1rem;">Tambah Module Baru untuk: <span style="color: #007bff;">{{ $course->title }}</span></h1>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.courses.modules.store', $course) }}" method="POST">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem;">Judul Module</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" style="width: 100%; padding: 0.5rem;" required>
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="order" style="display: block; margin-bottom: 0.5rem;">Nomor Urut</label>
            <input type="number" id="order" name="order" value="{{ old('order', 1) }}" style="width: 100%; padding: 0.5rem;" required>
        </div>
        <div>
            <button type="submit" style="background-color: #28a745; color: white; padding: 0.75rem 1.5rem; border: none; cursor: pointer;">Simpan</button>
        </div>
    </form>
</div>