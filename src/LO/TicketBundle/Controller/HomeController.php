<?php

namespace LO\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('@LOTicket/index.html.twig');
    }
}