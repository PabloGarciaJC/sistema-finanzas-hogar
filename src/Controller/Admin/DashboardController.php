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

use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\CashPaymentRepository;
use App\Repository\CreditRepository;
use App\Repository\GoalRepository;
use App\Repository\MonthRepository;
use App\Repository\MemberRepository;
use App\Repository\MonthlySummaryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;
    private CashPaymentRepository $cashPaymentRepository;
    private CreditRepository $creditRepository;
    private GoalRepository $goalRepository;
    private MonthRepository $monthRepository;
    private MemberRepository $memberRepository;
    private MonthlySummaryRepository $monthlySummaryRepository;

    public function __construct(
        IncomeRepository $incomeRepository,
        ServiceRepository $serviceRepository,
        CashPaymentRepository $cashPaymentRepository,
        CreditRepository $creditRepository,
        GoalRepository $goalRepository,
        MonthRepository $monthRepository,
        MemberRepository $memberRepository,
        MonthlySummaryRepository $monthlySummaryRepository,
    ) {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
        $this->cashPaymentRepository = $cashPaymentRepository;
        $this->creditRepository = $creditRepository;
        $this->goalRepository = $goalRepository;
        $this->monthRepository = $monthRepository;
        $this->memberRepository = $memberRepository;
        $this->monthlySummaryRepository = $monthlySummaryRepository;
    }

    public function index(): Response
    {
        $monthsEntities = $this->monthRepository->findAll();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $totalMiembros = $this->memberRepository->getCountMember($user->getId());
        $totalIngresos = $this->incomeRepository->getIncomeOptions($user->getId());
        $totalCreditos = $this->creditRepository->getTotalCredit($user->getId());
        $totalServicios = $this->serviceRepository->getTotalServiceSql($user->getId());
        $totalPagosAlContado = $this->cashPaymentRepository->getTotalCashPayment($user->getId());
        $totalMetas = $this->goalRepository->getGoalTotal($user->getId());
        $bankDebtTotal = $totalServicios + $totalPagosAlContado + $totalCreditos + $totalMetas;
        $totalAhorros = (float) $totalIngresos - $bankDebtTotal;

        // Crear array de meses dinámicamente desde la BDD
        $months = [];
        $gastosPorMes = [];

        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
            $gastosPorMes[] = $this->monthlySummaryRepository->getDebtsByMonth(
                $user->getId(),
                $monthEntity->getId()
            );
        }
        // Construir array de nombres de mes
        $meses = array_keys($months);

        setlocale(LC_TIME, 'es_ES.UTF-8');
        $mesActualNombre = strftime('%B'); // Ej: "julio"
        $mesActualNombre = ucfirst($mesActualNombre);

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
            'totalPagosAnuales' => '1001',
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
