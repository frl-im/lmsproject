
<h2>Tambah Quiz - {{ $lesson->title }}</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="/admin/quiz/store" method="POST">
    @csrf
    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

    <div>
        <label>Pertanyaan</label><br>
        <input type="text" name="question">
    </div>

    <div>
        <label>Opsi A</label><br>
        <input type="text" name="option_a">
    </div>

    <div>
        <label>Opsi B</label><br>
        <input type="text" name="option_b">
    </div>

    <div>
        <label>Opsi C</label><br>
        <input type="text" name="option_c">
    </div>

    <div>
        <label>Opsi D</label><br>
        <input type="text" name="option_d">
    </div>

    <div>
        <label>Jawaban Benar</label><br>
        <select name="correct_answer">
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
    </div>

    <button type="submit">Simpan Soal</button>
</form>
