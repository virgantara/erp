<?php
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Password reset request form.
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Wrong email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool Whether the email was send.
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(['status' => User::STATUS_ACTIVE, 'email' => $this->email]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            return false;
        }


        $to      = $this->email;
        $subject = 'Password reset for ' . Yii::$app->name;

        $message = Yii::$app->controller->renderPartial('passwordResetToken',[
            'user' => $user
        ]);

        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Admin Tracer UNIDA Gontor<'.Yii::$app->params['supportEmail'].'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
        return true;
        // return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
        //                         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        //                         ->setTo($this->email)
        //                         ->setSubject('Password reset for ' . Yii::$app->name)
        //                         ->send();
    }
}
