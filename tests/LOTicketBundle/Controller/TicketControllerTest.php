<?php

namespace LO\TicketBundle\Tests\Ticket;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketControllerTest extends WebTestCase
{
    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ticket?commandeId=17');
        $this->assertCount(1, $crawler->filter('html:contains("Sélection Ticket(s)")'));
    }

    public function testTicketSelect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ticket?commandeId=17');
        $buttonCrawlerNode = $crawler->selectButton('commande[save]');
        $form = $buttonCrawlerNode->form();

        $form['commande_ticket[tickets][0][fname]'] = 'Adam';
        $form['commande_ticket[tickets][0][lname]'] = 'Martin';
        $form['commande_ticket[tickets][0][birthday]'] = '12-05-1975';
        $form['commande_ticket[tickets][0][country]'] = 'FR';

        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains( 'Panier', $client->getResponse()->getContent() );
    }
}
