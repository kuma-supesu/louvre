<?php

namespace LO\TicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeCommandTest extends WebTestCase
{
    public function testImg()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(1, $crawler->selectImage('Logo du Louvre'));
    }

    public function testCommandeButton()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Réservez vos tickets')->link();
        $this->assertContains('/commande', $link->getUri());
        $commandePage = $client->click($link);
        $this->assertCount(1, $commandePage->filter('html:contains("Ticket")'));
    }

    public function testCommandeMenu()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Ticket')->link();
        $this->assertContains('/commande', $link->getUri());
        $commandePage = $client->click($link);
        $this->assertCount(1, $commandePage->filter('html:contains("Ticket")'));
    }
}
