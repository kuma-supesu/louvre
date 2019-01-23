<?php

namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Ticket;
use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Form\Type\CommandeTicketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class TicketController extends Controller
{
    public function addAction(Request $request)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());

        //dump($session->all());exit;

        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($session->getId());
        //$em = $this->getDoctrine()->getManager();
        for ($i = 0; $i < $session->get('ticket_number'); $i++) {
            $commande->addTicket(new Ticket());
        }

        $form = $this->createForm(CommandeTicketType::class, $commande);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                foreach ($commande->getTickets() as $ticket){
                    $em->persist($ticket);
                    $em->flush($ticket);
                }
                    return $this->redirectToRoute('lo_commande_panier',array('commandeId' => $id));
            }
        }
    return $this->render('@LOTicket/ticket.html.twig', array(
        'form' => $form->createView(),
    ));
    }
}