<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{

    /**
     * @Route("/img/menu", name="menu")
     * @return Response
     */
    public function menu(){
        $bibliothequeImages = scandir(self::CHEMIN_IMAGE);
        foreach ( $bibliothequeImages as $index => $chemin){
            if(is_dir($chemin))
            {
                unset( $bibliothequeImages[$index]);
            }
            else
            {
                $bibliothequeImages[$index] = substr($chemin, 0, -4);
            }
        }
        return $this->render('img/menu.html.twig',['url'=>'/img/data/', 'photos'=>$bibliothequeImages]);
    }


    /**
     * @Route("/img/data/{nom}", name="affiche")
     * @param $nom
     * @return BinaryFileResponse
     */
    public function affiche($nom){
        $nomFichier = self::CHEMIN_IMAGE."/$nom.jpg";
        if(!file_exists($nomFichier))
        {
            throw $this->createNotFoundException('Image inconnue ou introuvable');
        }
        else
        {
            return $this->file($nomFichier);
        }
    }



    const CHEMIN_IMAGE = __DIR__."/../../images";

    /**
     * @Route("/img/home", name="home")
     */
    public function home()
    {
        return $this->render('img/home.html.twig');
    }
}
