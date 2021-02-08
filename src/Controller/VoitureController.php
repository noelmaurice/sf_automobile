<?php

namespace App\Controller;


use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voiture", name="voiture_")
 */
class VoitureController extends AbstractController
{

    /**
     * @Route("/", name="search")
     */
    public function search(VoitureRepository $repository, PaginatorInterface $paginatorInterface, Request $request)
    {
        $rechercheVoiture = new RechercheVoiture();
        $session = $request->getSession();

        $form = $this->createForm(RechercheVoitureType::class, $rechercheVoiture);
        $form->handleRequest($request);

        $page = $request->query->getInt("page", 1);

        if ($form->isSubmitted() && $form->isValid())
        {
            $session->set("minAnnee", $rechercheVoiture->getMinAnnee());
            $session->set("maxAnnee", $rechercheVoiture->getMaxAnnee());
            $page = 1;
        }

        $minAnnee = $session->get("minAnnee");
        $maxAnnee = $session->get("maxAnnee");

        $voitures = $paginatorInterface->paginate(
            $repository->findAllWithPagination($minAnnee, $maxAnnee),
            $page, /*page number*/
            6 /*limit per page*/
        );

        return $this->render('voiture/view_all.html.twig',[
            "voitures" => $voitures,
            "form" => $form->createView(),
            "minAnnee" => $minAnnee,
            "maxAnnee" => $maxAnnee
        ]);
    }


    /**
     * @Route("/all", name="view_all")
     */
    public function getAll(Request $request)
    {
        $session = $request->getSession();



        $session->remove("minAnnee");
        $session->remove("maxAnnee");


        $session->set("isAdmin", true);


        return $this->redirectToRoute("voiture_search");
    }
}
