<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Mailer
{
    private $siteEmail = "";

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct($siteEmail, Swift_Mailer $mailer, Environment $twig)  {
        $this->siteEmail = $siteEmail;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param User $user
     */
    public function sendConfirmationMessage(User $user)
    {
        try {
            $messageBody = $this->twig->render('security/confirmation.html.twig', [
                'user' => $user
            ]);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }

        $message = new Swift_Message();
        $message
            ->setSubject('Вы успешно прошли регистрацию!')
            ->setFrom($this->siteEmail)
            ->setTo($user->getEmail())
            ->setBody($messageBody, 'text/html');

        $this->mailer->send($message);
    }
}