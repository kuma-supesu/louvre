<?php


namespace LO\TicketBundle\Controller;
use LO\TicketBundle\Entity\commande;
use LO\TicketBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class commandeController
{

    public function indexAction()
    {
        return $this->render('@LOTicket/Default/index.html.twig');
    }

    public function addAction(Request $request)
    {
        $commande= new Commande();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $commande);

        $formBuilder
            ->add('booking',      DateType::class)
            ->add('booking_code',     TextType::class)
            ->add('email',   TextareaType::class)
            ->add('ticket_number',    IntegerType::class)
        ;

        $form = $formBuilder->getForm();

        return $this->render('@OCPlatformBundle:commande:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}