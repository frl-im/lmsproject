<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Introduction to Laravel',
                'description' => 'Pelajari dasar-dasar Laravel framework untuk membangun aplikasi web yang scalable dan maintainable.',
            ],
            [
                'title' => 'Advanced PHP Concepts',
                'description' => 'Kuasai konsep PHP tingkat lanjut seperti OOP, design patterns, dan best practices.',
            ],
            [
                'title' => 'Database Design & SQL',
                'description' => 'Desain database yang efisien dan kuasai query SQL untuk berbagai kebutuhan aplikasi.',
            ],
            [
                'title' => 'API Development with Laravel',
                'description' => 'Bangun RESTful API yang robust dan secure menggunakan Laravel.',
            ],
            [
                'title' => 'Vue.js Fundamentals',
                'description' => 'Mulai dengan Vue.js framework untuk membuat UI yang interaktif dan responsive.',
            ],
            [
                'title' => 'Full Stack Development',
                'description' => 'Kuasai seluruh stack dari backend Laravel hingga frontend Vue.js untuk full stack development.',
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Create modules for each course
            for ($i = 1; $i <= 3; $i++) {
                $module = Module::create([
                    'course_id' => $course->id,
                    'title' => "{$course->title} - Module {$i}",
                ]);

                // Create lessons for each module
                for ($j = 1; $j <= 2; $j++) {
                    Lesson::create([
                        'module_id' => $module->id,
                        'title' => "Lesson {$j}",
                        'content' => "Content for lesson {$j} of module {$i}",
                        'type' => 'materi',
                        'xp_reward' => 100,
                    ]);
                }
            }
        }
    }
}
