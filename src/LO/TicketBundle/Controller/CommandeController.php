<?php
namespace LO\TicketBundle\Controller;

use LO\TicketBundle\Entity\Commande;
use LO\TicketBundle\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LO\TicketBundle\Form\Type\CommandeType;

class CommandeController extends Controller
{
    public function addAction(Request $request)
    {
        $errors = [];
        $id = $request->query->get('commandeId');
        if ($id) {
            $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
            dump($commande->getId());exit;
        } else {
            $commande = new Commande();
        }
        $commande->setBookingCode(random_int(100, 1000000));
        $commande->setPaid(0);
        $form = $this->createForm(CommandeType::class, $commande);
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->isAvailableTicketByDate($commande) !== true) {
                   if ($this->isAvailableTicketByDate($commande) === false) {
                        $errors[] =  'Ce jour est complet';
                    } else {
                        $errors[] =  'Il reste ' . $this->isAvailableTicketByDate($commande) . ' ticket(s)';
                    }
                }
                if ($this->validationDate($commande) !== true) {
                    $errors[] =  'Le musée est fermé ce jour-là.';
                }
                if ($this->validationHalfDay($commande) !== true) {
                    $errors[] =  'Vous ne pouvez pas commander de ticket tarif journée apres 14h.';
                }
                if (!$errors) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($commande);
                    $em->flush($commande);
                    return $this->redirectToRoute('lo_ticket_form', array('commandeId' =>  $commande->getId()
                        )
                    );
                }
            }
        }
                return $this->render('@LOTicket/commande.html.twig', array(
                    'form' => $form->createView(),
                    'errors' => $errors,
                ));
    }

    public function panierAction(Request $request)
    {
        $id = (int) $request->query->get('commandeId');
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('@LOTicket/panier.html.twig', array('commande' => $commande));
    }

    public function recapitulatifAction(Request $request)
    {
        $id = (int) $request->query->get('commandeId');
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $this->InsertTicket($commande);
        $commande->setPaid(1);
		$datas = ['commande' => $commande];
		$this->get('app.send_mail')->sendContactMail($datas, $commande->getEmail());
        $em->persist($commande);
        $em->flush();
        return $this->render('@LOTicket/recapitulatif.html.twig', array('commande' => $commande)
        );
    }

    public function renvoiAction(Request $request)
    {
        $error = [];
        $commande = new Commande();
        $form = $this->createFormBuilder($commande)
            ->add('email', EmailType::class, array('label' => 'Email :', 'required' => true))
            ->add('save', SubmitType::class, array('label' => 'Envoyer', 'attr' => array('class' => 'btn')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData()->getEmail();
            $commande = $this->getDoctrine()->getRepository(Commande::class)->findOneByEmail($data);

            if ($commande === null) {
                $error[] = 'Désolé, cet adresse E-mail ne correspont à aucune enrengistrés.';
            }
            if (!$error) {
                $datas = ['commande' => $commande];
                $this->get('app.send_mail')->sendContactMail($datas, $commande->getEmail());
                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Vos tickets ont été renvoyés !'
                );
                return $this->redirectToRoute('lo_commande_renvoi');
            }
        }
        return $this->render('@LOTicket/renvoi.html.twig', array(
            'form' => $form->createView(), 'error' => $error
        ));
    }

    private function isAvailableTicketByDate($commande)
    {
        $nbTicketMax = 1000;
        $bookingDate = $commande->getBooking();
        $bookByDate = $this->getDoctrine()->getRepository(Reservation::class)->findOneByDate($bookingDate);

        if ($bookByDate === null) {
            $reservation = new Reservation();
            $reservation->setDate($bookingDate);
            $reservation->setTotalTicket();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush($reservation);
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
            return false;
        }
        if ( $dayMonth < $dayNow){
            return false;
        }
        return true;
    }

    private function InsertTicket($commande)
    {
        $nbTicketAdd = $commande->getTicketNumber();
        $TicketDate = $commande->getBooking();
        $addTicketBooking = $this->getDoctrine()->getRepository(Reservation::class)->findOneByDate($TicketDate);
        $getTicketBooking = $addTicketBooking->getTotalTicket();
        $totalTicket = $nbTicketAdd + $getTicketBooking;
        $setTicket = $addTicketBooking->setTotalTicket($totalTicket);
        $em = $this->getDoctrine()->getManager();
        $em->persist($setTicket);
        $em->flush();
        return $setTicket;
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