<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCredentailMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $roles;
    protected $password;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, array $roles, string $password)
    {
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $roles;
        $this->password = $password;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('User Credentials')
            ->view('layouts.email.userCredential')->with([
                'name' => $this->name,
                'email' => $this->email,
                'roles' => $this->roles,
                'password' => $this->password
            ]);
    }

}