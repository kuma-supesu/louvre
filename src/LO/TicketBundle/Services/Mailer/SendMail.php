<?php
namespace LO\TicketBundle\Services\Mailer;

class SendMail
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendContactMail($datas, $receiver){
        $message = (new \Swift_Message('Confirmation de commande de ticket(s) du Musée du Louvre'))
            ->setFrom('jkenobi@free.fr')
            ->setTo($receiver)
            ->setBody(
                $this->twig->render(
                    '@LOTicket/email.html.twig',
                    $datas
                ),
                'text/html'
            );
		
        $this->mailer->send($message);
    }
}