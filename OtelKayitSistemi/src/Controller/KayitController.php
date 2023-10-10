<?php

namespace App\Controller;

use App\Entity\ClientEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 


class KayitController extends AbstractController{
    #[Route('/kayit', name: 'kayit')]
    public function addClient(Request $request) {
        $client = new ClientEntity();
        $form = $this->createFormBuilder($client) 
        ->add('isim', TextType::class)
        ->add('soyisim', TextType::class)
        ->add('oda_no', IntegerType::class)
        ->add('ek_bilgiler', TextareaType::class)
        ->add('save', SubmitType::class, array('label' => 'Ekle')) 
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $validate = $form->getData();
            $client->setIsim($validate->getIsim());
            $client->setSoyisim($validate->getSoyisim());
            $client->setOdaNo($validate->getOdaNo());
            $client->setEkBilgiler($validate->getEkBilgiler());
            $client->setKayitTarihi(time()); // Şu anki tarih ve saat
            
            $doct = $this->getDoctrine()->getManager();
            $doct->persist($client);
            $doct->flush(); 

            return new Response($this->renderView('main.html.twig'));
        }

        $content = $this->renderView('kayit.html.twig', array( 
            'form' => $form->createView(), 
         ));
        
        return new Response($content);
    }

}