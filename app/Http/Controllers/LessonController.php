namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        // Load relasi agar navigasi lancar
        $lesson->load(['module.lessons', 'module.course']);
        
        return view('lessons.show', compact('lesson'));
    }

    public function complete(Request $request, Lesson $lesson)
    {
        $user = $request->user();

        // Cek apakah sudah pernah diselesaikan untuk menghindari manipulasi XP
        $alreadyCompleted = DB::table('lesson_user')
            ->where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->exists();

        if (!$alreadyCompleted) {
            // Catat penyelesaian dan tambah XP
            $user->lessons()->attach($lesson->id, ['completed_at' => now()]);
            $user->increment('xp', $lesson->xp_reward ?? 10);
            
            return response()->json([
                'success' => true, 
                'message' => 'Materi selesai!', 
                'xp_gained' => $lesson->xp_reward ?? 10
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Sudah diselesaikan sebelumnya.']);
    }
}