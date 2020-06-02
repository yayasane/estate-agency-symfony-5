<?php
namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
/*use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;*/

class ContactNotification {

    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
            $message = (new Email())
                ->subject('Agence '.$contact->getProperty()->getTitle())
                ->from('noreply@agence.fr')
                ->to('contact@agence.fr')
                ->replyTo($contact->getEmail())
                ->html($this->renderer->render('emails/contact.html.twig', ['contact' => $contact]));
            $this->mailer->send($message);

    }
}