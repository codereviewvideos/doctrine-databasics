<?php

namespace AppBundle\Controller;

use AppBundle\Service\RedditScraper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RedditController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
//        $posts = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')
//            ->someQueryWeCareAbout(515);

        $someConditional = false;

        $query = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')
                      ->createQueryBuilder('p');

        if ($someConditional) {
            $query->where('p.id > :id')
                  ->setParameter('id', 50);
        }

        $posts = $query->getQuery()->getResult();

        dump($posts);

        return $this->render(':reddit:index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/scraper", name="scraper")
     */
    public function scraperAction()
    {
        /** @var RedditScraper $reddit */
        $reddit = $this->get('reddit_scraper');
        $result = $reddit->scrape();

        return $this->render(':reddit:index.html.twig', [
            'posts' => []
        ]);
    }
}