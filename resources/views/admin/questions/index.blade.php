<!-- resources/views/admin/questions/index.blade.php -->

<h2>Quiz - {{ $lesson->title }}</h2>

<a href="/admin/lessons/{{ $lesson->id }}/quiz/create">+ Tambah Soal</a>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Pertanyaan</th>
        <th>Aksi</th>
    </tr>

    @foreach($questions as $q)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $q->question }}</td>
        <td>
            <a href="/admin/quiz/{{ $q->id }}/edit">Edit</a>

            <form action="/admin/quiz/{{ $q->id }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
