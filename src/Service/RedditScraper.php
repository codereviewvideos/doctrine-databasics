<?php

namespace App\Service;

use App\Entity\RedditAuthor;
use App\Entity\RedditPost;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;

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
        $client = new Client();
        $after  = null;

        for ($x = 0; $x < 5; $x++) {
            $response = $client->request(
                'GET',
                'https://api.reddit.com/r/php.json?limit=25&after=' . $after,
                [
                    //429 Too Many Requests
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
                    ]
                ]
            );

            $contents[$x] = json_decode($response->getBody()->getContents(), true);

            $after = $contents[$x]['data']['after'];

            //429 Too Many Requests
            sleep(1);
        }

        foreach ($contents as $content) {
            foreach ($content['data']['children'] as $child) {

                $redditPost = new RedditPost();
                $redditPost->setTitle($child['data']['title']);

                $authorName = $child['data']['author'];

                $redditAuthor = $this->em->getRepository('App:RedditAuthor')
                                         ->findOneBy([
                                                         'name' => $authorName
                                                     ]);

                if (!$redditAuthor) {
                    $redditAuthor = new RedditAuthor();
                    $redditAuthor->setName($authorName);

                    $this->em->persist($redditAuthor);
                    $this->em->flush();
                }

                $redditAuthor->addPost($redditPost);

                $this->em->persist($redditPost);
            }
        }

        $this->em->flush();
    }
}