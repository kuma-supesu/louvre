<?php

namespace LO\TicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandeControllerTest extends WebTestCase
{
    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/commande');
        $this->assertCount(1, $crawler->filter('html:contains("Expositions")'));
    }

    public function testBooking()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/commande');
        $buttonCrawlerNode = $crawler->selectButton('commande[save]');
        $form = $buttonCrawlerNode->form();

        $form['commande[booking]'] = '24-01-19';
        $form['commande[ticket_number]'] = 1;
        $form['commande[email][first]'] = 'test@gmail.com';
        $form['commande[email][second]'] = 'test@gmail.com';

        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains( 'Sélection Ticket(s)', $client->getResponse()->getContent() );

    }
}