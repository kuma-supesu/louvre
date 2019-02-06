<?php

namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Ticket;
use LO\TicketBundle\Entity\Commande_Temp;
use LO\TicketBundle\Form\Type\CommandeTicketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
    public function addAction(Request $request)
    {
        $id = $request->query->get('commandeId');
        $commande = $this->getDoctrine()->getRepository(Commande_Temp::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        if (count($commande->getTickets()) != $commande->getTicketNumber()) {
            for ($i = 0; $i < $commande->getTicketNumber(); $i++) {
                $commande->addTicket(new Ticket());
            }
        }
        $form = $this->createForm(CommandeTicketType::class, $commande);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                foreach ($commande->getTickets() as $ticket){
                    $em->persist($ticket);
                    $em->flush($ticket);
                }
                    return $this->redirectToRoute('lo_commande_panier', array('commandeId' => $id));
            }
        }
    return $this->render('@LOTicket/ticket.html.twig', array(
        'form' => $form->createView(), 'commandeId' => $commande->getId()
    ));
    }
}