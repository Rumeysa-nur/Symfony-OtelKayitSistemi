<?php

namespace App\Controller;

use App\Entity\ClientEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse;

class HomepageController extends AbstractController{
    #[Route('/home', name: 'home')]
    public function ajaxAction(Request $request) {
        $clients = $this->getClients();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0;  
            foreach($clients as $client) {  
                $temp = array(
                    'isim' => $client->getIsim(),
                    'soyisim' => $client->getSoyisim(),
                    'oda_no' => $client->getOdaNo(),
                    'ek_bilgiler' => $client->getEkBilgiler(),
                    'kayit_tarihi' => date('d/m/Y', $client->getKayitTarihi())
                );   
                $jsonData[$idx++] = $temp;  
                }
                return new JsonResponse($jsonData); 
        } else { 
            return $this->render('main.html.twig'); 
        }       
    }

    #[Route('/filter', name: 'filter')]
    public function filter() {
        $clients = $this->getClients();

        $jsonData = array();  
        $idx = 0;  
        foreach($clients as $client) {  
            $temp = array(
                'isim' => $client->getIsim(),
                'soyisim' => $client->getSoyisim(),
                'oda_no' => $client->getOdaNo(),
                'ek_bilgiler' => $client->getEkBilgiler(),
                'kayit_tarihi' => date('d/m/Y', $client->getKayitTarihi())
            );   
            $jsonData[$idx++] = $temp;  
            }
            return new JsonResponse($jsonData);       
    }

    private function getClients(){
        $repository = $this->getDoctrine()->getRepository('App\Entity\ClientEntity');
        $queryBuilder = $repository->createQueryBuilder('c');

        $parameters = [];

        // TO DO - Filtreleme işlemleri 'like' şeklinde yapıldığında sürekli hata verdiği için burası bu şekilde bırakıldı.
        if(!empty($_POST['isim'])){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('c.isim', ':isim'));
            $parameters['isim'] = $_POST['isim'];
        }
        if(!empty($_POST['soyisim'])){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('c.soyisim', ':soyisim'));
            $parameters['soyisim'] = $_POST['soyisim'];
        }
        if(!empty($_POST['oda_no'])){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('c.oda_no', ':oda_no'));
            $parameters['oda_no'] =  $_POST['oda_no'];
        }
        if(!empty($_POST['kayit_tarihi'])){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('c.kayit_tarihi', ':kayit_tarihi'));
            $parameters['kayit_tarihi'] = strtotime($_POST['kayit_tarihi']);
        }
        if(!empty($_POST['ek_bilgiler'])){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('c.ek_bilgiler', ':ek_bilgiler'));
            $parameters['ek_bilgiler'] = $_POST['ek_bilgiler'];
        }

        if(count($parameters)>0){
            $queryBuilder->setParameters($parameters);
        }
        $query = $queryBuilder
            ->orderBy('c.oda_no', 'ASC')
            ->getQuery();
        $clients = $query->getResult();

        return $clients;
    }

}