<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConfigurationController extends AbstractController
{
    #[Route('/admin/configuration', name: 'app_admin_configuration')]
    public function index(): Response
    {
        return $this->render('admin/configuration/index.html.twig', [
            'controller_name' => 'Admin/ConfigurationController',
        ]);
    }
}
