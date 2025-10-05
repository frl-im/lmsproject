<div style="font-family: sans-serif; padding: 2rem;">
    <h1>Tambah Course Baru</h1>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border: 1px solid #f5c6cb; border-radius: 5px;">
            <strong>Error! Terdapat masalah dengan input Anda.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem;">Judul Course</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="description" style="display: block; margin-bottom: 0.5rem;">Deskripsi</label>
            <textarea id="description" name="description" rows="5" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>{{ old('description') }}</textarea>
        </div>
        <div>
            <button type="submit" style="background-color: #28a745; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">Simpan</button>
            <a href="{{ route('admin.courses.index') }}" style="margin-left: 1rem; color: #6c757d;">Batal</a>
        </div>
    </form>
</div>