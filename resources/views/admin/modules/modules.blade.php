<div style="font-family: sans-serif; padding: 2rem;">
    <a href="{{ route('admin.courses.index') }}" style="color: #6c757d; text-decoration: none;">&larr; Kembali ke Daftar Courses</a>
    <h1 style="margin-top: 1rem;">Manajemen Modules untuk: <span style="color: #007bff;">{{ $course->title }}</span></h1>

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
                        <a href="#" style="color: #ffc107; text-decoration: none; font-weight: bold;">Edit</a> |
                        <a href="#" style="color: #dc3545; text-decoration: none; font-weight: bold;">Hapus</a>
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

    <div style="margin-top: 1rem;">
        {{ $modules->links() }}
    </div>
</div>