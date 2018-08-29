<?php


namespace LO\TicketBundle\Controller;


class IndexController extends Controller
{
    public function commandAction()
    {
        return $this->redirectToRoute('lo_ticket_form');
    }
}