<?php

namespace App\Http\Controllers\Backend;

use App\Events\ChatMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VendorMessageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $userId = auth()->user()->id;

        $chatUsers = Chat::with('senderProfile')->select(['sender_id'])
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->groupBy('sender_id')
            ->get();

        return view('vendor.messenger.index', compact('chatUsers'));
    }

    public function getMessages(Request $request)
    {
        $senderId = auth()->user()->id;
        $receiverId = $request->receiver_id;

        $messages = Chat::whereIn('receiver_id', [$senderId, $receiverId])
            ->whereIn('sender_id', [$senderId, $receiverId])
            ->orderBy('created_at', 'asc')
            ->get();

        Chat::where(['sender_id' => $receiverId, 'receiver_id' => $senderId])->update(['seen' => 1]);

        return response($messages);
    }

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
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
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

        return response(['status' => 'success', 'message' => 'message sent successfully']);
    }
}
