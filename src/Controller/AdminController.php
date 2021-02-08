<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="delete", methods="supprimer")
     */
    public function suppression(Voiture $voiture, Request $request, EntityManagerInterface $em)
    {
        if($this->isCsrfTokenValid("supprimer" . $voiture->getId(), $request->get("_token")))
        {
            $em->remove($voiture);
            $em->flush();
            $this->addFlash('success', "Le véhicule a été supprimé");

            return $this->redirectToRoute("voiture_view_all");
        }
    }

    /**
     * @Route("/", name="view_all_vehicles")
     */
    public function index(Request $request)
    {
        return $this->redirectToRoute("voiture_view_all");
    }



    /**
     * @Route("/create", name="create")
     * @Route("/update/{id}", name="update")
     */
    public function update(Voiture $voiture = null, Request $request, EntityManagerInterface $em)
    {
        if(!$voiture)
        {
            $voiture = new Voiture();
        }

        $form = $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($voiture);
            $em->flush();
            $this->addFlash('success', "Le véhicule a été modifié");
            return $this->redirectToRoute("admin_view_all_vehicles");
        }

        return $this->render("admin/update.html.twig", [
           "form" => $form->createView(),
           "voiture" => $voiture
        ]);
    }



}
