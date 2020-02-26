<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Markdown;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(Markdown $md)
    {
        $files = $md->files;
        return $this->render('page/index.html.twig', ['files' => $files]);
    }

    /**
     * @Route("/{directory}/{note}", name="note", requirements={"directory"=".+"})
     */
    public function note(string $directory, string $note, Markdown $md)
    {
        $markdown = $md->LoadMarkdown($directory, $note);
        $files = $md->files;

        if ($markdown === false) {
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
