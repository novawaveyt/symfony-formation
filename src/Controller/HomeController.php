<?php

namespace App\Controller;

use App\Controller\HomeController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @route("/hello/{prenom}/{age}",name="hello")
     * @route("/hello",name="hello_base")
     * @route("/hello/{prenom}",name="hello_prenom")
     * Montre la page qui dit bonjour
     *
     * @return void
     */
    public function hello($prenom = "anonyme", $age = 0) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }
    /**
     * Undocumented function
     *
     * @Route("/", name="homepage")
     */
    public function home() {
        $prenoms = ["Lior" => 31,"Philippe" => 49,"Géraldine" => 12];
        return $this->render(
            'home.html.twig',
            [   'title' => "Bonjour à tous",
                'age' => 12,
                'tableau' => $prenoms ]
        );
    }
}
?>
