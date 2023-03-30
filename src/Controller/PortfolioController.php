<?php

namespace App\Controller;

use App\Entity\PortfolioEntity;
use App\Form\PortfolioType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PortfolioEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name:'app_portfolio')]
function index(PortfolioEntityRepository $repo): Response
    {
    $items = $repo->findAll();
    return $this->render('portfolio/index.html.twig', compact('items'));
}

#[Route('/create', name:'app_create', methods:['GET', 'POST'])]
function create(Request $request, EntityManagerInterface $em): Response
    {
    // 1 - Create new item
    $item = new PortfolioEntity();
    // 2 - create form
    $form = $this->createForm(PortfolioType::class, $item);
    //$showForm = $form->createView();
    //Add post in db
    // fetch data from input
    $form->handleRequest($request);
    // submit form
    if ($form->isSubmitted() && $form->isValid()) {
        // stock data from user
        $newItem = $form->getData();
        // check if pics have been chosen
        $imgPath = $form->get('url_img')->getData();

        // if ($imgPath) {
        //     $newFileName = uniqid() . '.' . $imgPath->guessExtension();
        //     try {
        //         // move picture in public/upload dir
        //         $imgPath->move(
        //             $this->getParameter('kernel.project_dir') . '/public/upload',
        //             $newFileName
        //         );
        //     } catch (FileException $e) {
        //         return new Response($e->getMessage());
        //     }
        //     // send url to db
        //     $newPost->setUrlImg('/upload/' . $newFileName);
        // }
        // persists data from user entries
        $em->persist($item);
        $em->flush();

        // redirection
        return $this->redirectToRoute('app_home');
    }
    // 3 - send form to view
    return $this->render('blog/create.html.twig', [
        'showForm' => $form->createView(),
    ]);
}

}
