<?php

namespace App\Controller;

use App\Entity\PortfolioEntity;
use App\Form\PortfolioType;
use App\Repository\PortfolioEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name:'app_portfolio')]
function index(PortfolioEntityRepository $repo): Response
    {
    $items = $repo->findAll();
    return $this->render('portfolio/index.html.twig', compact('items'));
}

#[Route('/portfolio/create', name:'app_p_create', methods:['GET', 'POST'])]
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
        $imgPath = $form->get('img')->getData();
        if ($imgPath) {
            $array = [];
            foreach ($imgPath as $path) {
                $newFileName = uniqid() . '.' . $path->guessExtension();
                try {
                    // move picture in public/upload dir
                    $path->move(
                        $this->getParameter('kernel.project_dir') . '/public/upload',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                array_push($array, $newFileName);
            }

            // send urls to db
            $newItem->setImg($array);
        }
        // persists data from user entries
        $em->persist($newItem);
        $em->flush();

        // redirection
        return $this->redirectToRoute('app_portfolio');
    }
    // 3 - send form to view
    return $this->render('portfolio/create.html.twig', [
        'showForm' => $form->createView(),
    ]);
}

}
