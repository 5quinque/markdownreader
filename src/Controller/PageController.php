<?php

namespace App\Controller;

// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Markdown;
use App\Service\Search;

use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(Markdown $md)
    {
        $files = $md->files;
        $dirPath = $md->findIndex();

        $markdown = $md->loadMarkdown($dirPath[0], $dirPath[1]);

        return $this->render('page/note.html.twig', [
            'directory' => $dirPath[0],
            'note' => $dirPath[1],
            'files' => $files,
            'markdown' => $markdown,
        ]);
    }

    /**
     * @Route("/search/{searchterm}", name="search")
     */
    public function search(Markdown $md, Search $search, string $searchterm)
    {
        $files = $md->files;
        $result = $search->searchTitles($searchterm, $files);

        dump($result);

        return $this->render('page/search.html.twig', ['files' => $files, 'searchterm' => $searchterm]);
    }

    /**
     * @Route("/raw/{filename}", name="image", requirements={"filename"=".+"})
     */
    public function image(string $filename, Markdown $md)
    {
        //var_dump($filename);
        $image = $md->loadImage($filename);

        $response = new Response();
        // [TODO] png support..
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->setContent($image);
        return $response;
    }

    /**
     * @Route("/{directory}/{note}", name="note", requirements={"directory"=".+"})
     */
    public function note(string $directory, string $note, Markdown $md)
    {
        $markdown = $md->loadMarkdown($directory, $note);
        $files = $md->files;

        if ($markdown === false) {
            // if file_exists $filename..
            return $this->redirectToRoute('image', ['filename' => "{$directory}/{$note}"]);
            // endif
            throw $this->createNotFoundException('This page does not exist');
        }
        
        return $this->render('page/note.html.twig', [
            'directory' => $directory,
            'note' => $note,
            'files' => $files,
            'markdown' => $markdown,
        ]);
    }
}
