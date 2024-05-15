<?php

namespace App\Events;

//use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
//use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $message;
    public mixed $receiver_id;
    public mixed $unseen_messages;
    public mixed $dateTime;

    /**
     * Create a new event instance.
     */
    public function __construct(
        $message, $receiver_id, $unseen_messages, $dateTime)
    {
        $this->message = $message;
        $this->receiver_id = $receiver_id;
        $this->unseen_messages = $unseen_messages;
        $this->dateTime = $dateTime;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('message.' . $this->receiver_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     *
     * @uses ChatMessageEvent::broadcastWith()
     */
    #[ArrayShape([
        'message' => "",
        'date_time' => "",
        'receiver_id' => "mixed",
        'sender_id' => "mixed",
        'sender_image' => "string",
        'unseen_messages' => "",
    ])] public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'date_time' => $this->dateTime,
            'receiver_id' => $this->receiver_id,
            'sender_id' => auth()->user()->id,
            'sender_image' => asset(auth()->user()->image),
            'unseen_messages' => $this->unseen_messages,
        ];
    }
}
