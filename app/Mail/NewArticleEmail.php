<?php

namespace App\Mail;

use App\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewArticleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $article;
//    protected $article;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        //
        $this->article = $article;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_article_email')
            ->from('articles@news.com',"Articles Team")
//            ->with(['article_title'=>$this->article->title])
            ->subject('New Article Add!');
    }
}
