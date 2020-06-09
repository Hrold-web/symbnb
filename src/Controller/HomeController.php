<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello")
     * @Route("/hello", name="hello_base")
     * @Route("/hello/{prenom}/{age}", name="hello_prenom_age")
     * @Route("/hello/{prenom}", name="hello_prenom")
     * @return Response
     *
     */
    public function hello($prenom="rien",$age=12){
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age,
            ]
        );
    }
    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        $prenoms = ["Machin" => 31,"Truc" => 12,"Bidule" => 5];
        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous",
                'age' => 31,
                'tableau' => $prenoms,
            ]
    );
    }
}