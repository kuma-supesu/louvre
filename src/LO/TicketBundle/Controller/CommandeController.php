<?php
namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CommandeController extends Controller
{

    public function indexAction()
    {
        return $this->render('@LOTicket/Default/index.html.twig');
    }

    public function addAction(Request $request)
    {
        $errors = [];
        $commande = new Commande();
        $commande->setBookingCode(random_int(100, 1000000));

        $form = $this->createFormBuilder($commande)
            ->add('booking', DateType::class, array('label' => 'Date de réservation', 'years' => range(date('Y'), 2100),'format' => 'dd-MM-yyyy', 'placeholder' => array('month' => date(' '),'day' =>date(' '))))
            ->add('booking_code', HiddenType::class)
            ->add('email', TextType::class, array('label' => 'Votre E-mail', 'required' => true))
            ->add('day',    CheckboxType::class, array('label' => 'Tarif demi journée', 'required' => false))
            ->add('ticket_number', IntegerType::class, array('label' => 'Nombre de billets', 'required' => true))
            ->add('save', SubmitType::class, array('label' => 'Suivant'))
            ->getForm();

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->isAvailableTicketByDate($commande) !== true) {
                    $errors[] =  'Il reste ' . $this->isAvailableTicketByDate($commande) . ' Billet(s)';
                }
                if ($this->validationDate($commande) !== true){
                    $errors[] =  'Le musée est fermé ce jour-là.';
                }
                if ($this->validationHalfDay($commande) !== true){
                    $errors[] =  'Vous ne pouvez pas commander de billet tarif journée apres 14h.';
                }

                if (!$errors) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($commande);
                    $em->flush();

                    return $this->redirectToRoute('lo_ticket_form', array('ticket_number' => $commande->getTicketNumber(),
                            'currentForm' => 1, 'commandeId' =>  $commande->getId()
                        )
                    );
                }
            }
        }
                return $this->render('@LOTicket/commande.html.twig', array(
                    'form' => $form->createView(),
                    'errors' => $errors
                ));
    }

    public function recapAction(Request $request)
    {
        $id = (int) $request->query->get('commandeId');
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('@LOTicket/recap.html.twig', array('email' => $commande->getEmail(), 'code' => $commande->getBookingCode(), 'booking' =>$commande->getBooking(), 'ticket_number' => $commande->getTicketNumber(),
                'ticket' => $commande->getTicket())
        );
    }

    private function isAvailableTicketByDate($commande)
    {
        $nbTicketMax = 1000;
        $bookingDate = $commande->getBooking();
        $bookByDate = $this->getDoctrine()->getRepository(Reservation::class)->findOneByDate($bookingDate);

        if ($bookByDate === null) {
            return true;
        }
        if ($nbTicketMax === $bookByDate->getTbillet()) {
            return false;
        }
        $ticketRestant = $nbTicketMax - $bookByDate->getTbillet();
        if ($commande->getTicketNumber() > $ticketRestant) {
            return $ticketRestant;
        }
        return true;
    }

    private function validationDate($commande)
    {
        $date = $commande->getBooking();
        $dayOfWeek = $date->format('w');
        $dayMonth = $date->format('d-m');
        $now = new \DateTime('d');
        $dayNow = $now->format('d-m');
        if ($dayMonth === '01-05' || $dayMonth === '01-11' || $dayMonth === '25-12' || $dayOfWeek === 2) {
            return false ;
        }
        if ( $dayMonth < $dayNow){
            return false;
        }
        return true;
    }

    private function InsertTicket($commande)
    {
        $nbTicketAdd = $commande->getBooking();
        $addTicketBooking = $this->getDoctrine()->getRepository(Reservation::class)->findOneByDate($nbTicketAdd);
        $tbillet = $nbTicketAdd + $addTicketBooking;
        $reservation = new Reservation();
        $reservation->setTbillet($tbillet);
        $em = $this->getDoctrine()->getManager();
        $em->persist();
        $em->flush();
    }

    private function validationHalfDay($commande)
    {
        $SelectDate = $commande->getBooking();
        $dayMonth = $SelectDate ->format('d-m');
        $now = new \DateTime();
        $today = $now->format('d-m');
        $toHour = $now->format('H');
        if ($toHour >= '14' && $today === $dayMonth) {
            return false;
        }
        return true;
    }
}