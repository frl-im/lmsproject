
<h2>Edit Soal</h2>

<form action="/admin/quiz/{{ $question->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="question" value="{{ $question->question }}"><br>
    <input type="text" name="option_a" value="{{ $question->option_a }}"><br>
    <input type="text" name="option_b" value="{{ $question->option_b }}"><br>
    <input type="text" name="option_c" value="{{ $question->option_c }}"><br>
    <input type="text" name="option_d" value="{{ $question->option_d }}"><br>

    <select name="correct_answer">
        <option value="a" {{ $question->correct_answer == 'a' ? 'selected' : '' }}>A</option>
        <option value="b" {{ $question->correct_answer == 'b' ? 'selected' : '' }}>B</option>
        <option value="c" {{ $question->correct_answer == 'c' ? 'selected' : '' }}>C</option>
        <option value="d" {{ $question->correct_answer == 'd' ? 'selected' : '' }}>D</option>
    </select>

    <button type="submit">Update</button>
</form>
