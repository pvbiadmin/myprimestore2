<?php

namespace App\Http\Controllers\Backend;

use App\Events\ChatMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $chatUsers = Chat::with('senderProfile')
            ->select(['sender_id'])
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->groupBy('sender_id')
            ->get();

        return view('admin.messenger.index', compact('chatUsers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function getMessages(Request $request)
    {
        $senderId = auth()->user()->id;
        $receiverId = $request->receiver_id;

        $messages = Chat::whereIn('receiver_id', [$senderId, $receiverId])
            ->whereIn('sender_id', [$senderId, $receiverId])
            ->orderBy('created_at', 'asc')
            ->get();

        Chat::where([
            'sender_id' => $receiverId,
            'receiver_id' => $senderId
        ])->update(['seen' => 1]);

        return response($messages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required'],
            'receiver_id' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return response(['status' => 'error', 'message' => $error]);
        }

        $message = new Chat();

        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;

        $message->save();

        $unseenMessages = Chat::query()
            ->where([
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'seen' => 0
            ])->get();

        $countUnseenMsg = count($unseenMessages);

        broadcast(new ChatMessageEvent(
            $message->message, $message->receiver_id, $countUnseenMsg, $message->created_at));

        return response([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
    }
}
