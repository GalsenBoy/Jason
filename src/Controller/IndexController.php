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
        //Une fois que nous avons notre Entity Manager, nous créons une instance de Tag et nous la lions à un formulaire externalisé de type TagType
        $membre = new Personnage;
        $membreForm = $this->createForm(PersonnageType::class, $membre);
        //Nous appliquons la Request sur notre formulaire TagType, et si ce dernier est validé, nous le persistons au sein de notre base de données
        $membreForm->handleRequest($request);
        if($membreForm->isSubmitted() && $membreForm->isValid()){
            //Condition supplémentaire: on ne persiste que si l'affirmation que $title ET $text sont tous les deux null est INVALIDE
            $entityManager->persist($membre);
            $entityManager->flush();
        }
        //Si le formulaire n'est pas rempli ou valide, nous transmettons une page web présentant notre formulaire à l'Utilisateur
        return $this->render('index/dataform.html.twig',[
            'formName' => "Ajout de nouveaux membres",
            'dataForm' => $membreForm->createView(),
            'membre' => $membre,
        ]);
    }
}
