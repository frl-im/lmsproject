<div style="font-family: sans-serif; padding: 2rem;">
    <h1>Manajemen Courses</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.courses.create') }}" style="display: inline-block; background-color: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px; margin-bottom: 1rem;">
        + Tambah Course Baru
    </a>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 0.75rem; text-align: left;">No.</th>
                <th style="padding: 0.75rem; text-align: left;">Judul</th>
                <th style="padding: 0.75rem; text-align: left;">Deskripsi</th>
                <th style="padding: 0.75rem; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td style="padding: 0.75rem;">{{ $courses->firstItem() + $loop->index }}</td>
                    <td style="padding: 0.75rem;">{{ $course->title }}</td>
                    <td style="padding: 0.75rem;">{{ Str::limit($course->description, 100) }}</td>
                    <td style="padding: 0.75rem; white-space: nowrap;">
                        <a href="{{ route('admin.courses.edit', $course) }}" style="color: #ffc107; text-decoration: none; font-weight: bold;">Edit</a> |
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus course ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc3545; text-decoration: none; font-weight: bold; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 1rem; text-align: center;">
                        Belum ada data course.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $courses->links() }}
    </div>
</div>