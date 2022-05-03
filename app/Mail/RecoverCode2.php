<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class RecoverCode2 extends Mailable
{
    use Queueable, SerializesModels;


    private $user;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        dd($user);
        do {
            $user->token = Str::random(40);
            $user->token_time = now();
        } while (!$user->update());

        $this->token = $user->token;
        $this->user = User::buildSimple($user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = 'test-ny4t024w1@srv1.mail-tester.com';
        $this->subject('Código de Recuperação de Acesso!');
        $userName = '';
        if (array_key_exists('name', $this->user)) {
            $userName = $this->user['name'];

            $this->to($email, $this->user['name']);
        } else {
            $this->to($email);
        }
        return $this->view(
            'mail.emailRescueCode',
            [
                'userName' => $userName,
                'token' => $this->token
            ]
        );
    }
}
