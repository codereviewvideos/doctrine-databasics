<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedditController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
//        $posts = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')
//            ->someQueryWeCareAbout(515);

        $someConditional = true;

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
        $result = $this->get('reddit_scraper')->scrape();

        return $this->render(':reddit:index.html.twig', [
            'posts' => []
        ]);
    }
}