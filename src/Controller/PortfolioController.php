<?php

namespace App\Controller;

use App\Entity\PortfolioEntity;
use App\Form\PortfolioType;
use App\Repository\PortfolioEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/', name:'app_info')]
function phpinfoAction()
    {
    return new Response('<html><body>' . phpinfo() . '</body></html>');
}
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
                $ext = $path->guessExtension();
                if (in_array($ext, ['jpg', 'png'])) {
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
                } else {
                    $form->get('img')->addError(new FormError('Wrong extensions (allowed: jpg & png'));
                    $form->submit(null, false);
                }

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

#[Route('/portfolio/update/{id}', name:'app_p_update', methods:['GET', 'POST'])]
function update($id, Request $request, EntityManagerInterface $em, PortfolioEntityRepository $repo): Response
    {
    // 1 - Create new item
    $item = $repo->find($id);

    // 2 - create form
    $form = $this->createForm(PortfolioType::class, $item);
    //$showForm = $form->createView();
    //Add post in db
    // fetch data from input
    $form->handleRequest($request);
    // submit form
    $arrayData = $item->getImg();
   
   if ($form->isSubmitted() && $form->isValid()) {
        // stock data from user
        $newItem = $form->getData();
        // check if pics have been chosen
        $imgPath = $form->get('img')->getData();
        if ($imgPath) {
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
                    array_push($arrayData, $newFileName);
            }
            // send urls to db
            $newItem->setImg($arrayData);
        }
        // persists data from user entries
        $em->persist($newItem);
        $em->flush();

        // redirection
        //return $this->redirectToRoute('app_portfolio');
    }
    // 3 - send form to view
    return $this->render('portfolio/update.html.twig', [
        'showForm' => $form->createView(),
        'paths' => $item->getImg(),
        'id' => $id,
    ]);
}

#[Route('/portfolio/deleteImg/{id}/{name}', name:'app_p_deleteimg', methods:['GET', 'POST'])]
function deleteImg($id, $name, Request $request, EntityManagerInterface $em, PortfolioEntityRepository $repo)
{
    $item = $repo->find($id);
    $array = array_diff($item->getImg(), [$name]);
    $item->setImg($array);
    $em->flush();
    $form = $this->createForm(PortfolioType::class, $item);
    return $this->redirectToRoute('app_p_update', ['id' => $id]);
}
}
