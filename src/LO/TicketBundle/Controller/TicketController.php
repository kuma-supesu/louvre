<?php

namespace LO\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
    public function indexAction()
    {
        return $this->render('@LOTicketBundle/Default/index.html.twig');
    }
}
