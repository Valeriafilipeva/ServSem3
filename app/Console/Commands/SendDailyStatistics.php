<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArticleView;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;

class SendStatisticsEmail extends Command
{
    // Эти строки определяют, как команда будет вызываться из Artisan CLI:

    // $signatureуказывает имя команды ( email:send-statistics)
    // $descriptionдает краткое описание того, что делает команда «Отправить статистику модераторам»
    protected $signature = 'email:send-statistics';
    protected $description = 'Отправить статистику модераторам';

    public function handle()
    {
        $viewCount = ArticleView::count(); // Кол-во просмотров
        $commentCount = Comment::whereDate('created_at', today())->count(); // Новые комментарии

        $message = "Статистика за день:\nПросмотры: $viewCount\nКомментарии: $commentCount";

        Mail::raw($message, function ($mail) {
            $mail->to('lerikafilipeva@gmail.com')
                ->subject('Дневная статистика сайта');
        });

        $this->info('Статистика успешно отправлена!');
    }
}
