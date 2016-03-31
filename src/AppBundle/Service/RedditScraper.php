<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

class RedditScraper
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function scrape()
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.reddit.com/r/php.json');

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }
}