<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($threadId)
    {
        $thread = ChatThread::findOrFail($threadId);
        return view('chat.index', compact('thread'));
    }

    public function sendMessage(Request $request, $threadId)
    {
        $thread = ChatThread::findOrFail($threadId);
        $message = new ChatMessage([
            'thread_id' => $thread->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);
        $message->save();

        // Optionally broadcast the event
        // broadcast(new MessageSent($message->message, auth()->user()->name))->toOthers();

        return back();
    }
}