<?php

namespace App\Controller;

use App\Entity\RedditPost;
use App\Service\RedditScraper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RedditController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
//        $posts = $this->getDoctrine()->getRepository('App\Entity\RedditPost')
//            ->someQueryWeCareAbout(515);

        $someConditional = false;

        $query = $this->getDoctrine()->getRepository(RedditPost::class)
                      ->createQueryBuilder('p');

        if ($someConditional) {
            $query->where('p.id > :id')
                  ->setParameter('id', 50);
        }

        $posts = $query->getQuery()->getResult();

        return $this->render('reddit/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/scraper", name="scraper")
     */
    public function scraperAction(RedditScraper $scraper)
    {
        // would be better as a simple console application
        // consider making this change yourself, in order to further your learning
        $scraper->scrape();

        // pointless rendering - blank page
        return $this->render('reddit/index.html.twig', [
            'posts' => []
        ]);
    }
}