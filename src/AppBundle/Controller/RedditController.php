<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RedditAuthor;
use AppBundle\Entity\RedditPost;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/create/{text}", name="create")
     */
    public function createAction($text)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new RedditPost();
        $post->setTitle('hello ' . $text);

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('list');
    }


    /**
     * @Route("/update/{id}/{text}", name="update")
     */
    public function updateAction($id, $text)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);

        if (!$post) {
            throw $this->createNotFoundException('thats not a record');
        }

        /** @var $post RedditPost */
        $post->setTitle('updated title ' . $text);

        $em->flush();

        return $this->redirectToRoute('list');
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);

        if (!$post) {
            return $this->redirectToRoute('list');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('list');
    }


    /**
     * @Route("/scrape", name="scrape")
     */
    public function scraperAction()
    {
        $em = $this->getDoctrine()->getManager();
        $client = new \GuzzleHttp\Client();
        $after = null;

        for ($x=0; $x<5; $x++) {

            $response = $client->request('GET', 'https://api.reddit.com/r/php.json?limit=10&after=' . $after);

            $contents[$x] = json_decode($response->getBody()->getContents(), true);

            $after = $contents[$x]['data']['after'];

        }

        foreach ($contents as $content) {
            foreach ($content['data']['children'] as $child) {
                $redditPost = new RedditPost();
                $redditPost->setTitle($child['data']['title']);

                $authorName = $child['data']['author'];
                $redditAuthor = $em->getRepository('AppBundle:RedditAuthor')->findOneBy(['name'=>$authorName]);

                if (!$redditAuthor) {
                    $redditAuthor = new RedditAuthor();
                    $redditAuthor->setName($authorName);
                    $em->persist($redditAuthor);
                    $em->flush();
                }

                $redditPost->setAuthor($redditAuthor);

                $em->persist($redditPost);
            }
        }

        $em->flush();

        return $this->render(':reddit:index.html.twig', [
            'posts' => []
        ]);
    }
}