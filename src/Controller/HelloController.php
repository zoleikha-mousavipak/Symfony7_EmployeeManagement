<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    private $message = "Welcome to Employee Management Web Application!";

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'message' => $this->message
        ]);
    }
}
