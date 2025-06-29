<?php

namespace App\Controller\Admin;

use App\Entity\CashPayment;
use App\Entity\Credit;
use App\Entity\Goal;
use App\Entity\Income;
use App\Entity\Member;
use App\Entity\MonthlySummary;
use App\Entity\Period;
use App\Entity\Saving;
use App\Entity\Service;

use App\Entity\User;

use App\Controller\Admin\CreditController;
use App\Controller\Admin\GoalController;
use App\Controller\Admin\IncomeController;
use App\Controller\Admin\MemberController;
use App\Controller\Admin\MonthlySummaryController;
use App\Controller\Admin\ServiceController;
use App\Controller\Admin\CashPaymentController;
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
        $totalMiembros = 10;
        $totalIngresos = 25;
        $totalCreditos = 10;
        $totalServicios = 8;
        $totalMetas = 5;
        $totalAhorros = 12;
        $totalPagosAlContado = 4;

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $gastosPorMes = [1200, 1500, 1000, 1300, 1250, 1400, 1100, 1600, 1350, 1450, 1550, 1700];

        $mesActualNombre = date('F');
        $mesesEsp = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];
        $mesActualNombre = $mesesEsp[$mesActualNombre];

        $indiceMesActual = array_search($mesActualNombre, $meses);
        $gastoTotalMesActual = $gastosPorMes[$indiceMesActual] ?? 0;

        return $this->render('admin/dashboard/index.html.twig', [
            'totalMiembros' => $totalMiembros,
            'totalIngresos' => $totalIngresos,
            'totalCreditos' => $totalCreditos,
            'totalServicios' => $totalServicios,
            'totalMetas' => $totalMetas,
            'totalAhorros' => $totalAhorros,
            'totalPagosAlContado' => $totalPagosAlContado,

            'meses' => $meses,
            'gastosPorMes' => $gastosPorMes,
            'mesActualNombre' => $mesActualNombre,
            'gastoTotalMesActual' => $gastoTotalMesActual,
            'gastosAnuales' => '100',
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('<i class="fas fa-wallet"></i> Finanzas Hogar');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Resumen Mensual', 'fas fa-chart-bar', MonthlySummary::class)->setController(MonthlySummaryController::class);
        yield MenuItem::linkToCrud('Ingresos', 'fas fa-dollar-sign', Income::class)->setController(IncomeController::class);
        yield MenuItem::linkToCrud('Servicios', 'fas fa-briefcase', Goal::class)->setController(ServiceController::class);
        yield MenuItem::linkToCrud('Pago al contado', 'fas fa-credit-card', CashPayment::class)->setController(CashPaymentController::class);
        yield MenuItem::linkToCrud('Créditos', 'fas fa-money-bill', Credit::class)->setController(CreditController::class);
        yield MenuItem::linkToCrud('Metas', 'fas fa-bullseye', Goal::class)->setController(GoalController::class);
        yield MenuItem::linkToCrud('Miembros', 'fas fa-users', Member::class)->setController(MemberController::class);
        yield MenuItem::linkToRoute('Documentación', 'fas fa-book', 'app_admin_documentation');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addWebpackEncoreEntry('admin/monthly-summary');
    }
}
