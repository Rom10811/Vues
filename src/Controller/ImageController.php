<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{

    //Definir chemin pour le répertoire images
    const PATH_IMG = __DIR__."/../../images";

    /**
     * @Route("/img/home", name="home")
     */
    public function home()
    {
        return $this->render('img/home.html.twig');
    }


    /**
     * @Route("/img/data/{nom}", name="affiche")
     * @param $nom
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function affiche($nom){
        $nomFichier = self::PATH_IMG."/$nom.jpg";
        if(!file_exists($nomFichier))
        {
            throw $this->createNotFoundException('Image inconnue');
        }
        else
        {
            return $this->file($nomFichier);
        }
    }

    /**
     * @Route("/img/menu", name="menu")
     * @return Response
     */
    public function menu(){
        $bibliothequeImages = scandir(self::PATH_IMG);
        foreach ( $bibliothequeImages as $clé => $chemin){
        if(is_dir($chemin))
        {
            unset( $bibliothequeImages[$clé]);
        }
        else
        {
            $bibliothequeImages[$clé] = substr($chemin, 0, -4);
        }
        }
        return $this->render('img/menu.html.twig',['url'=>'/img/data/', 'photos'=>$bibliothequeImages]);
    }
}
