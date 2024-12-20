<?php

// Уведомление ArticleCreatedNotification используется для отправки 
// информации о создании новой статьи в базу данных, а не напрямую в почту

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification; 

// Использование trait Queueable:
// Позволяет отправлять уведомления асинхронно через очередь задач.
// Свойство $article:
// Хранит ссылку на статью, о которой идет речь.
// Метод via():
// Определяет, какой канал коммуникации использовать для отправки уведомления.
// В данном случае, уведомление будет отправлено в базу данных.
// Метод toDatabase():
// Определяет формат данных, которые будут сохранены в базе данных.
// Возвращают массив с названием и ID статьи.

class ArticleCreatedNotification extends Notification
{
    use Queueable;

    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->article->name,
            'id' => $this->article->id,
        ];
    }
}
