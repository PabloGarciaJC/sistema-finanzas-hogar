<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocumentationController extends AbstractController
{
    #[Route('/admin/documentation', name: 'app_admin_documentation')]
    public function index(): Response
    {
        return $this->render('admin/documentation/index.html.twig', [
            'controller_name' => 'Admin/DocumentationController',
        ]);
    }
}
