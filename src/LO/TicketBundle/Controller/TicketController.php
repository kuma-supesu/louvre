<?php

namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Ticket;
use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Form\Type\CommandeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
    public function addAction(Request $request)
    {
        $id = (int) $request->query->get('commandeId');
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        for ($i = 0; $i < $commande->getTicketNumber(); $i++) {
            $commande->addTicket(new ticket());
        }

        $form = $this->createForm(CommandeType::class, $commande);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();

                    return $this->redirectToRoute('lo_commande_recap',array('commandeId' => $id));
            }
        }
    return $this->render('@LOTicket/add.html.twig', array(
        'form' => $form->createView(),
        'currentForm' => $i
    ));
    }
}