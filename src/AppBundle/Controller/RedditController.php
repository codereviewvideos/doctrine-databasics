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
        $posts = $this->getDoctrine()->getRepository('AppBundle:RedditPost')->findAll();

        return $this->render(':reddit:index.html.twig', [
            'posts' => $posts
        ]);
    }
}