<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Comment $comment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $post = $this->comment->post;

        return (new MailMessage)
            ->subject("New comment on \"{$post->title}\"")
            ->greeting("Hello {$notifiable->name},")
            ->line("{$this->comment->user->name} commented on your post \"{$post->title}\":")
            ->line(Str::limit($this->comment->comment, 200))
            ->action('View post', route('posts.show', $post));
    }
}
