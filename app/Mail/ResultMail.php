<?php

namespace App\Mail;

use App\Models\Term;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResultMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $term;
    protected $grade;

    /**
     * Create a new message instance.
     */
    public function __construct($term,$grade)
    {
        $this->term = $term;
        $this->grade = $grade;
    }

    public function build()
    {
        return $this->subject("Result of ".$this->grade." of ".$this->term." term" )
            ->view('layouts.email.result')->with([
                'grade' => $this->grade,
                'term' => $this->term,
            ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path("/app/Grade ". $this->grade. ".zip"))
        ];
    }
}
