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
use App\Controller\Admin\ServiceCrudController;
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

        // Datos de ejemplo para meses y gastos mensuales
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $gastosPorMes = [1200, 1500, 1000, 1300, 1250, 1400, 1100, 1600, 1350, 1450, 1550, 1700];

        // Ejemplo de mes actual y gasto total de ese mes
        $mesActualNombre = date('F'); // Esto devuelve mes en inglés, si quieres en español, deberías mapearlo
        // Para mapear a español:
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

        // Obtener el índice del mes actual para sacar el gasto
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
        yield MenuItem::linkToCrud('Resumen Mensual', 'fas fa-chart-bar', MonthlySummary::class)->setController(MonthlySummaryCrudController::class);
        yield MenuItem::linkToCrud('Ingresos', 'fas fa-dollar-sign', Income::class)->setController(IncomeCrudController::class);
        yield MenuItem::linkToCrud('Servicios', 'fas fa-briefcase', Goal::class)->setController(ServiceCrudController::class);
        yield MenuItem::linkToCrud('Pago al contado', 'fas fa-credit-card', SingleCreditPayment::class)->setController(SingleCreditPaymentController::class);
        yield MenuItem::linkToCrud('Créditos', 'fas fa-money-bill', Credit::class)->setController(CreditCrudController::class);




   

 
        yield MenuItem::linkToCrud('Metas', 'fas fa-bullseye', Goal::class)->setController(GoalCrudController::class);
        yield MenuItem::linkToCrud('Miembros', 'fas fa-users', Member::class)->setController(MemberCrudController::class);

        yield MenuItem::linkToRoute('Documentación', 'fas fa-book', 'app_admin_documentation');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addWebpackEncoreEntry('admin/monthly-summary');
    }
}
