<?php

namespace App\Repositories;

use App\Events\MailSendEvent;
use App\Models\EmailVerification;
use App\Models\User;
use Keygen\Keygen;

class EmailVerificationRepository extends Repository
{
    public static function model()
    {
        return EmailVerification::class;
    }

    public static function sendMailByUser(User $user): EmailVerification
    {
        $varificationCode = self::create([
            'user_id' => $user->id,
            'token' => substr(md5(mt_rand()), 0, 30),
        ]);
        MailSendEvent::dispatch($user, $varificationCode, 'signup');

        return $varificationCode;
    }

    public static function updateByRequest(EmailVerification $emailVerification): EmailVerification
    {
        $token = Keygen::token(64)->generate();
        self::update($emailVerification, [
            'token' => $token
        ]);

        return $emailVerification;
    }
}
