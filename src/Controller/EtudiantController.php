<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Personne;
use App\Form\EtudiantType;
use App\Form\PersonneType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(EtudiantRepository $EtudiantRepository): Response
    {
        $Etudiants = $EtudiantRepository->findAll();
        return $this->render('etudiant/index.html.twig', ['etudiants' => $Etudiants]);
    }

    #[Route('/etudiant/add', name: 'app_etudiant_add')]
    public function addEtudiant(EtudiantRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $this->addFlash("success", "etudiant ajouté avec success");
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->render('etudiant/add.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/etudiant/delete/{id}', name: 'app_etudiant_delete')]
    public function deleteEtudiant($id, EtudiantRepository $repository, Etudiant $userObj = null, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $etudiant = $repository->findOneBy(['id' => $id]);
        if (isset($etudiant)) {
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_etudiant');
    }
}
