<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class EmailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function confirmRegistration(User $user): void
    {
        $message = (new \Swift_Message())
            ->setCharset('utf-8')
            ->setSubject($this->translator->trans('email.confirmRegistration.subject'))
            ->setTo((string) $user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/registration.html.twig',
                    ['name' => $user->getName()]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}