<?php

namespace App\Controller;

use App\Entity\DevisEntity;
use App\Form\DevisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $emi): Response
    {
        $devis = new DevisEntity;
        $form = $this->createForm(DevisFormType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newDevis = $form->getData();
            // $newDevis->setClientName();
            // $newDevis->setClientEmail();
            // $newDevis->setDemandType();
            // $newDevis->setMessage();

            $emi->persist($newDevis);
            $emi->flush();

            return $this->redirectToRoute('app_home');
        }
        $this->addFlash('success', "Votre devis à été envoyé");
        return $this->render('devis/devis.html.twig', [
            'form' => $form->createView(),
            // 'message' => '$message',
        ]);
    }
}
