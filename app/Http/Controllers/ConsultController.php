<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultController extends Controller
{
    /**
     * Show consultation/chat page
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get messages untuk user ini
            $messages = Message::forUser($user->id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return view('consult.index', compact('messages', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Send message ke admin (simulasi)
     */
    public function sendMessage(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:5000',
            ]);

            DB::beginTransaction();

            // Simpan message ke database
            $message = Message::create([
                'user_id' => $user->id,
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'is_read' => false,
                'is_admin_reply' => false,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda telah dikirim ke admin. Terima kasih!',
                'message_data' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get messages with auto-refresh
     */
    public function getMessages()
    {
        try {
            $user = Auth::user();

            $messages = Message::forUser($user->id)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'subject' => $msg->subject,
                        'message' => $msg->message,
                        'is_admin_reply' => $msg->is_admin_reply,
                        'is_read' => $msg->is_read,
                        'created_at' => $msg->created_at->diffForHumans(),
                    ];
                });

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'unread_count' => Message::forUser($user->id)->unread()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark message as read
     */
    public function markAsRead($messageId)
    {
        try {
            $user = Auth::user();
            
            $message = Message::where('user_id', $user->id)
                ->findOrFail($messageId);

            $message->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Pesan telah ditandai sebagai dibaca',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete message (soft delete via archive)
     */
    public function deleteMessage($messageId)
    {
        try {
            $user = Auth::user();
            
            $message = Message::where('user_id', $user->id)
                ->findOrFail($messageId);

            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
