<?php
namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LO\TicketBundle\Form\Type\CommandeType;

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
        $form = $this->createForm(CommandeType::class, $commande);
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->isAvailableTicketByDate($commande) !== true) {
                    $errors[] =  'Il reste ' . $this->isAvailableTicketByDate($commande) . ' ticket(s)';
                }
                if ($this->validationDate($commande) !== true){
                    $errors[] =  'Le musée est fermé ce jour-là.';
                }
                if ($this->validationHalfDay($commande) !== true){
                    $errors[] =  'Vous ne pouvez pas commander de ticket tarif journée apres 14h.';
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
        if ($nbTicketMax === $bookByDate->getTotalTicket()) {
            return false;
        }
        $ticketRestant = $nbTicketMax - $bookByDate->getTotalTicket();
        if ($commande->getTicketNumber() > $ticketRestant) {
            return $ticketRestant;
        }
        return true;
    }

    private function validationDate($commande)
    {
        $date = $commande->getBooking();
        $dayOfWeek = $date->format('w');
        $dayMonth = $date->format('y-m-d');
        $now = new \DateTime('');
        $dayNow = $now->format('y-m-d');
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
        $totalTicket = $nbTicketAdd + $addTicketBooking;
        $reservation = new Reservation();
        $reservation->setTotalTicket($totalTicket);
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
            return true;
        }
        return true;
    }
}