<?php

namespace App\Controller;

use App\Repository\CommentsRepository;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * HomePage
     * @Route("/", name="homepage")
     */
    public function index(PropertiesRepository $repo, CommentsRepository $repoComment)
    {
        $lastProperties = $repo->findLastProperties(3,1);
        $lastComments = $repoComment->findLastComments(3, 1);

        return $this->render('home/index.html.twig', [
            'lastProperties' => $lastProperties,
            'lastComments' => $lastComments
        ]);
    }
}
