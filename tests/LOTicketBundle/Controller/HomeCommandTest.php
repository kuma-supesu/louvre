<?php

namespace LO\TicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeCommandTest extends WebTestCase
{
    public function testUppercase()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $attributes = $crawler
            ->filterXpath('//body/div')
            ->extract(array('_text', 'class'))
        ;
        $this->assertCount(1, $attributes);
    }
    public function testImg()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(1, $crawler->selectImage('Oeuvres exposé au louvre'));
    }
    public function testCommandeButton()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Réservez vos tickets')->link();
        $this->assertContains('/commande', $link->getUri());
        $commandePage = $client->click($link);
        $this->assertCount(1, $commandePage->filter('html:contains("Commande")'));
    }
}
