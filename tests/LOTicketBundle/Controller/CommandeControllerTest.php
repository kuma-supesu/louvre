<?php

namespace LO\TicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandeControllerTest extends WebTestCase
{
    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/commande');
        $this->assertCount(1, $crawler->filter('html:contains("Commande")'));
    }

    public function testBooking()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/commande');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();

        $form['commande[booking]'] = 12/02/2018;
        $form['commande[ticket_number]'] = 1;
        $form['commande[email]'] = 'test@gmail.com';

        $client->submit($form);

        $link = $crawler->selectLink('valider')->link();
        $this->assertContains('/commande', $link->getUri());
        $submit = $client->click($link);
        $this->assertCount(1, $submit->filter('html:contains("tickets")'));
    }
}