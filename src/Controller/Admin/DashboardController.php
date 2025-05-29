<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use App\Entity\Goal;
use App\Entity\Income;
use App\Entity\Member;
use App\Entity\MonthlySummary;
use App\Entity\Period;
use App\Entity\Saving;
use App\Entity\Service;
use App\Entity\SingleCreditPayment;


use App\Entity\User;

use App\Controller\Admin\CreditCrudController;
use App\Controller\Admin\GoalCrudController;
use App\Controller\Admin\IncomeCrudController;
use App\Controller\Admin\MemberCrudController;
use App\Controller\Admin\MonthlySummaryCrudController;
use App\Controller\Admin\PeriodCrudController;
use App\Controller\Admin\ServiceCrudController;
use App\Controller\Admin\SingleCreditPaymentCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $adminUrlGenerator->setController(MonthlySummaryCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('<i class="fas fa-wallet"></i> Finanzas Hogar');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Miembros', 'fas fa-users', Member::class)->setController(MemberCrudController::class);
        yield MenuItem::linkToCrud('Ingresos', 'fas fa-dollar-sign', Income::class)->setController(IncomeCrudController::class);
        yield MenuItem::linkToCrud('Servicios', 'fas fa-briefcase', Goal::class)->setController(ServiceCrudController::class);
        yield MenuItem::linkToCrud('Metas', 'fas fa-bullseye', Goal::class)->setController(GoalCrudController::class);
        yield MenuItem::linkToCrud('Créditos', 'fas fa-money-bill', Credit::class)->setController(CreditCrudController::class);
        yield MenuItem::linkToCrud('Créditos al Contado', 'fas fa-credit-card', SingleCreditPayment::class)->setController(SingleCreditPaymentController::class);
        yield MenuItem::linkToCrud('Resumen Mensual', 'fas fa-chart-bar', MonthlySummary::class)->setController(MonthlySummaryCrudController::class);
        yield MenuItem::linkToRoute('Documentación', 'fas fa-book', 'app_admin_documentation');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addWebpackEncoreEntry('admin/monthly-summary');
    }
}
