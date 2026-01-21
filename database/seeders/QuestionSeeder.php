<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all lessons
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            // Create 5 sample questions for each lesson
            $this->createQuestionsForLesson($lesson);
        }
    }

    /**
     * Create sample questions for a lesson
     */
    private function createQuestionsForLesson($lesson)
    {
        $questions = [
            [
                'question' => 'Apa yang merupakan konsep utama dalam ' . $lesson->name . '?',
                'option_a' => 'Pendekatan tradisional',
                'option_b' => 'Metode modern dan inovatif',
                'option_c' => 'Teknik kuno',
                'option_d' => 'Cara yang tidak efektif',
                'correct_answer' => 'B',
                'point' => 10,
            ],
            [
                'question' => 'Manakah pernyataan berikut yang BENAR tentang ' . $lesson->name . '?',
                'option_a' => 'Ini adalah metode yang sudah ketinggalan zaman',
                'option_b' => 'Ini merupakan cara yang paling relevan untuk saat ini',
                'option_c' => 'Ini tidak penting untuk dipelajari',
                'option_d' => 'Ini hanya digunakan di negara tertentu saja',
                'correct_answer' => 'B',
                'point' => 10,
            ],
            [
                'question' => 'Apa keuntungan utama dalam mempelajari ' . $lesson->name . '?',
                'option_a' => 'Tidak ada keuntungan',
                'option_b' => 'Meningkatkan produktivitas dan efisiensi kerja',
                'option_c' => 'Hanya untuk hiburan saja',
                'option_d' => 'Untuk menghabiskan waktu',
                'correct_answer' => 'B',
                'point' => 10,
            ],
            [
                'question' => 'Siapa yang PALING SERING menggunakan ' . $lesson->name . '?',
                'option_a' => 'Orang yang tidak ingin berkembang',
                'option_b' => 'Profesional dan orang-orang yang ingin meningkatkan keahlian',
                'option_c' => 'Hanya anak-anak saja',
                'option_d' => 'Tidak ada siapa pun',
                'correct_answer' => 'B',
                'point' => 10,
            ],
            [
                'question' => 'Berapa lama waktu yang dibutuhkan untuk menguasai ' . $lesson->name . '?',
                'option_a' => 'Selamanya tidak bisa dikuasai',
                'option_b' => 'Hanya 1 hari',
                'option_c' => 'Tergantung komitmen dan usaha Anda',
                'option_d' => 'Tidak perlu waktu',
                'correct_answer' => 'C',
                'point' => 10,
            ],
        ];

        foreach ($questions as $question) {
            Question::create([
                'lesson_id' => $lesson->id,
                'question' => $question['question'],
                'option_a' => $question['option_a'],
                'option_b' => $question['option_b'],
                'option_c' => $question['option_c'],
                'option_d' => $question['option_d'],
                'correct_answer' => $question['correct_answer'],
                'point' => $question['point'],
            ]);
        }
    }
}

