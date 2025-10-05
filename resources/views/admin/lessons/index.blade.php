<div style="font-family: sans-serif; padding: 2rem;">
    <a href="{{ route('admin.courses.modules.index', $module->course) }}" style="color: #6c757d; text-decoration: none;">&larr; Kembali ke Daftar Modules</a>
    <h1 style="margin-top: 1rem;">Manajemen Lessons untuk: <span style="color: #007bff;">{{ $module->title }}</span></h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.modules.lessons.create', $module) }}" style="display: inline-block; background-color: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px; margin-bottom: 1rem;">
        + Tambah Lesson Baru
    </a>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 0.75rem; text-align: left;">Judul Lesson</th>
                <th style="padding: 0.75rem; text-align: left;">Tipe</th>
                <th style="padding: 0.75rem; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lessons as $lesson)
                <tr>
                    <td style="padding: 0.75rem;">{{ $lesson->title }}</td>
                    <td style="padding: 0.75rem;">{{ $lesson->type }}</td>
                    <td style="padding: 0.75rem; white-space: nowrap;">
                        <a href="{{ route('admin.lessons.edit', [$lesson, 'module' => $module]) }}" style="color: #ffc107; text-decoration: none; font-weight: bold;">Edit</a> |
                        <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lesson ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc3545; text-decoration: none; font-weight: bold; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="padding: 1rem; text-align: center;">
                        Belum ada data lesson untuk module ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>