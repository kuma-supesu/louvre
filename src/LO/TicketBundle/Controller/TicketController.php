<?php
namespace LO\TicketBundle\Controller;
use LO\TicketBundle\Entity\Ticket;
use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Form\Type\TicketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
    public function addAction(Request $request)
    {
        $nbs = (int) $request->query->get('ticket_number');

        if ($request->query->get('currentForm')){
            $i = (int) $request->query->get('currentForm');
        }

        $id = (int) $request->query->get('commandeId');

        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $ticket = new ticket();
        $ticket->setCommande($commande);
        $form = $this->createForm(TicketType::class, $ticket);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();
                $i++;

                if ($i > $nbs) {
                    return $this->redirectToRoute('lo_commande_recap',array('commandeId' => $id)
                    );
                }
                else
                    return $this->redirectToRoute('lo_ticket_form', array('ticket_number' => $nbs,
                            'currentForm' => $i, 'commandeId' => $id
                        ));
            }
        }
    return $this->render('@LOTicket/add.html.twig', array(
        'form' => $form->createView(),
        'currentForm' => $i
    ));
    }
}
