<?php
namespace LO\TicketBundle\Controller;
use LO\TicketBundle\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeController extends Controller
{

    public function indexAction()
    {
        return $this->render('@LOTicket/Default/index.html.twig');
    }

    public function addAction(Request $request)
    {
        $commande = new Commande();
        $commande->setBookingCode(random_int(100, 1000000));

        $form = $this->createFormBuilder($commande)
            ->add('booking', DateType::class)
            ->add('booking_code', HiddenType::class)
            ->add('email', TextType::class)
            ->add('ticket_number', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Suivant'))
            ->getForm();

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($commande);
                $em->flush();

                return $this->redirectToRoute('lo_ticket_form', array('ticket_number' => $commande->getTicketNumber(),
                        'currentForm' => 1, 'commandeId' =>  $commande->getId()
                    )
                );
            }
        }
                return $this->render('@LOTicket/commande.html.twig', array(
                    'form' => $form->createView(),
                ));
    }
}