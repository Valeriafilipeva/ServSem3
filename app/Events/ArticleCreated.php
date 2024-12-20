<?php


namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // Dispatchable: Позволяет диспетчеру событий правильно обрабатывать и распространять события.
    // InteractsWithSockets: предоставляет методы для работы с WebSocket-соединениями.
    // SerializesModels: сериализует соответствующие модели перед отправкой событий.
    public $article;

    /**
     * Create a new event instance.
     */
    public function __construct($article)
    {
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('articles');
        // Этот метод определяет канал, на который будет отправлено событие.
        //  В данном случае все события будут публиковаться на канале Articles.
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->article->id,
            'name' => $this->article->name,
            'created_at' => $this->article->created_at->toDateTimeString(),
            // Преобразует заданное строковое представление даты и времени в эквивалентное значение даты и времени.
        ];
        // Этот метод определяет данные, которые будут отправлены вместе по событию
    }
}
