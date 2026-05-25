<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $title;
    public $description;
    public $note;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, $title, $description, $note = null)
    {
        $this->transaction = $transaction;
        $this->title = $title;
        $this->description = $description;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SweetBite - ' . $this->title)
                    ->view('emails.order_status');
    }
}
