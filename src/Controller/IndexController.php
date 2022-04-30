<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Form\PersonnageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
         //Pour dialoguer avec notre base de données et envoyer des éléments, nous avons besoin de l'Entity Manager
        $entityManager = $managerRegistry->getManager();
        $membreRepository = $entityManager->getRepository(Personnage::class);
        $membre = $membreRepository->findAll();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'membre' => $membre,
        ]);
    }

    #[Route('/personnage',name:'app_perso')]
    public function createPersonnage(ManagerRegistry $managerRegistry, Request $request):Response
    {
        $entityManager = $managerRegistry->getManager();
        //On instancie notre nouvel objet
        $membre = new Personnage;
        //on crée notre formulaire qui aura dans ces champs les propriétes de PersonnageType
        $membreForm = $this->createForm(PersonnageType::class, $membre);
        $membreForm->handleRequest($request);
        //Si le formulaire est envoyé et est valide on retourne à la page d'accueuil
        if($membreForm->isSubmitted() && $membreForm->isValid()){
            $entityManager->persist($membre);
            $entityManager->flush();
            $this->redirectToRoute('app_index');
        }
        //Si le formulaire n'est pas rempli ou invalide, nous transmettons une page web présentant notre formulaire à l'Utilisateur
        return $this->render('index/dataform.html.twig',[
            'formName' => "Ajout de nouveaux membres",
            'dataForm' => $membreForm->createView(),
            'membre' => $membre,
        ]);
    }
}
