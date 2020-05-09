<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Markdown;
use App\Form\SearchMDType;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(Markdown $md)
    {
        $searchform = $this->createForm(SearchMDType::class, null, [
            'action' => $this->generateUrl('search'),
        ]);

        $files = $md->files;
        $dirPath = $md->findIndex();

        $markdown = $md->loadMarkdown($dirPath[0], $dirPath[1]);

        return $this->render('page/note.html.twig', [
            'searchform' => $searchform->createView(),
            'directory' => $dirPath[0],
            'note' => $dirPath[1],
            'files' => $files,
            'markdown' => $markdown,
        ]);
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
     * @Route("/{directory}/{note}", name="note", requirements={"directory"="^(?!search|raw).*$"})
     */
    public function note(string $directory, string $note, Markdown $md)
    {
        $searchform = $this->createForm(SearchMDType::class, null, [
            'action' => $this->generateUrl('search'),
        ]);

        $markdown = $md->loadMarkdown($directory, $note);
        $files = $md->files;

        if ($markdown === false) {
            // if file_exists $filename..
            return $this->redirectToRoute('image', ['filename' => "{$directory}/{$note}"]);
            // endif
            throw $this->createNotFoundException('This page does not exist');
        }
        
        return $this->render('page/note.html.twig', [
            'searchform' => $searchform->createView(),
            'directory' => $directory,
            'note' => $note,
            'files' => $files,
            'markdown' => $markdown,
        ]);
    }
}
