<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchMDType;
use App\Service\Markdown;
use App\Service\Search;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{searchterm?}", name="search")
     */
    public function search(Request $request, Markdown $md, Search $search, $searchterm)
    {
        $searchform = $this->createForm(SearchMDType::class, null, [
            'action' => $this->generateUrl('search'),
        ]);

        $searchform->handleRequest($request);
        if ($searchform->isSubmitted() && $searchform->isValid()) {
            $query = $searchform->getData();

            return $this->redirectToRoute('search', ['searchterm' => $query["searchterm"]]);
        }

        $files = $md->files;
        $results = $search->searchTitles($searchterm, $files);

        return $this->render('page/search.html.twig', [
            'searchform' => $searchform->createView(),
            'files' => $files,
            'searchterm' => $searchterm,
            'results' => $results
        ]);
    }
}
