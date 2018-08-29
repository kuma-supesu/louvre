<?php

namespace LO\TicketBundle\Controller;
use LO\TicketBundle\Entity\commande;
use LO\TicketBundle\Entity\Ticket;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

        $ticket = new ticket();

            $form = $this->createFormBuilder($ticket)
                ->add('fname',  TextType::class)
                ->add('lname',  TextType::class)
                ->add('birthday',   DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
                ->add('country',    CountryType::class)
                ->add('reduc',  CheckboxType::class, array('required' => false))
                ->add('day',    CheckboxType::class, array('required' => false))
                ->add('save',   SubmitType::class, array('label' => 'Create Task'))
                ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();
                $i++;

                if ($i > $nbs) {
                    return $this->redirectToRoute('lo_commande_homepage');
                }
                else
                    return $this->redirectToRoute('lo_ticket_form', array('ticket_number' => $nbs,
                            'currentForm' => $i
                        )
                    );
            }
        }
    return $this->render('@LOTicket/add.html.twig', array(
        'form' => $form->createView(),
        'currentForm' => $i
    ));
    }
}
