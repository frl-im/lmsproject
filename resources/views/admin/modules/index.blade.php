<div style="font-family: sans-serif; padding: 2rem;">
    <a href="{{ route('admin.courses.index') }}" style="color: #6c757d; text-decoration: none;">&larr; Kembali ke Daftar Courses</a>
    <h1 style="margin-top: 1rem;">Manajemen Modules untuk: <span style="color: #007bff;">{{ $course->title }}</span></h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.courses.modules.create', $course) }}" style="display: inline-block; background-color: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px; margin-bottom: 1rem;">
        + Tambah Module Baru
    </a>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 0.75rem; text-align: left;">Urutan</th>
                <th style="padding: 0.75rem; text-align: left;">Judul Module</th>
                <th style="padding: 0.75rem; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($modules as $module)
                <tr>
                    <td style="padding: 0.75rem;">{{ $module->order }}</td>
                    <td style="padding: 0.75rem;">{{ $module->title }}</td>
                    <td style="padding: 0.75rem; white-space: nowrap;">
                        {{-- TOMBOL BARU DITAMBAHKAN DI SINI --}}
                        <a href="{{ route('admin.modules.lessons.index', $module) }}" style="color: #28a745; text-decoration: none; font-weight: bold;">Lessons</a> |
                        <a href="{{ route('admin.courses.modules.edit', [$course, $module]) }}" style="color: #ffc107; text-decoration: none; font-weight: bold;">Edit</a> |
                        <form action="{{ route('admin.courses.modules.destroy', [$course, $module]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus module ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc3545; text-decoration: none; font-weight: bold; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="padding: 1rem; text-align: center;">
                        Belum ada data module untuk course ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>