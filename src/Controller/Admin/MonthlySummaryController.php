<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Entity\Service;
use App\Entity\CashPayment;
use App\Entity\Income;
use App\Entity\Goal;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\CreditRepository;
use App\Repository\GoalRepository;
use App\Repository\CurrencyRepository;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
use App\Repository\CashPaymentRepository;
use App\Repository\MemberRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MonthlySummaryController extends AbstractCrudController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;
    private CreditRepository $creditRepository;
    private GoalRepository $goalRepository;
    private CurrencyRepository $currencyRepository;
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;
    private MemberRepository $memberRepository;
    private CashPaymentRepository $cashPaymentRepository;

    public function __construct(IncomeRepository $incomeRepository, ServiceRepository $serviceRepository, CreditRepository $creditRepository, GoalRepository $goalRepository, CurrencyRepository $currencyRepository, MonthRepository $monthRepository, YearRepository $yearRepository, MemberRepository $memberRepository, CashPaymentRepository $cashPaymentRepository,)
    {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
        $this->creditRepository = $creditRepository;
        $this->goalRepository = $goalRepository;
        $this->currencyRepository = $currencyRepository;
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
        $this->memberRepository = $memberRepository;
        $this->cashPaymentRepository = $cashPaymentRepository;
    }

    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();
        $defaults = $this->calculateDefaultValues();
        $fields = [];
        $fields[] = $this->createFormattedNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaults['income'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('debt_total', 'Deuda Total', $pageName, $defaults['bankDebtTotal'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('savings', 'Ahorros', $pageName, $defaults['savings'], $currencySymbol, $rowClass);
        $fields[] = $this->createMonthChoiceField($pageName, $rowClass);
        $fields[] = $this->createYearChoiceField($pageName, $rowClass);

        return $fields;
    }

    private function calculateDefaultValues(): array
    {

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC'], 1);

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $income = $this->incomeRepository->getIncomeOptionsByMonth($user->getId(), $firstInactiveMonth[0]->getId());
        $service = $this->serviceRepository->getTotalServiceSqlByMonth($user->getId(), $firstInactiveMonth[0]->getId());
        $cashPayment = $this->cashPaymentRepository->getTotalCashPaymentByMonth($user->getId(), $firstInactiveMonth[0]->getId());
        $credit = $this->creditRepository->getTotalCredit($user->getId(), $firstInactiveMonth[0]->getId());
        $goalTotal = $this->goalRepository->getGoalTotalByMonth($user->getId(), $firstInactiveMonth[0]->getId());
        $bankDebtTotal = $service + $cashPayment + $credit + $goalTotal;
        $saving = (float) $income - $bankDebtTotal;

        $members = $this->memberRepository->findBy(['user' => $user->getId()]);
        $memberBalances = [];

        foreach ($members as $member) {
            $services = $this->serviceRepository->getTotalServicesByMember($member->getId(), $user->getId(), $firstInactiveMonth[0]->getId());
            $cashPayment = $this->cashPaymentRepository->getTotalByMemberId($member->getId(), $user->getId(), $firstInactiveMonth[0]->getId());
            $credit = $this->creditRepository->getTotalCreditByMemberId($member->getId(), $user->getId());
            $goal = $this->goalRepository->getTotalGoalByMemberId($member->getId(), $user->getId(), $firstInactiveMonth[0]->getId());
            $totalCombined = $services + $cashPayment + $credit + $goal;

            $memberBalances[] = [
                'memberName' => $member->getName(),
                'bankBalance' => $totalCombined,
            ];
        }

        return [
            'income' => $income,
            'bankDebtTotal' => $bankDebtTotal,
            'savings' => $saving,
            'bank_balance' => $memberBalances
        ];
    }

    private function createFormattedNumberField(string $name, string $label, string $pageName, ?float $default, string $currencySymbol, array $rowClass): NumberField
    {
        return $this->createNumberField($name, $label, $pageName, $default, true, true, $rowClass)
            ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : '');
    }

    /**
     * Crea el campo de selección de mes para el formulario.
     */
    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthEntities = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);

        $months = [];
        foreach ($monthEntities as $month) {
            $months[$month->getName()] = $month->getId();
        }

        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass)
            ->setFormTypeOption('placeholder', 'Seleccione un mes');

        if ($pageName === Crud::PAGE_NEW && count($monthEntities) > 0) {
            $monthField->setFormTypeOption('data', $monthEntities[0]->getId());
        }

        return $monthField;
    }

    /**
     * Crea el campo de selección de año para el formulario.
     */

    private function createYearChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        if ($pageName === Crud::PAGE_NEW) {
            // Obtener solo el primer año activo (status = 1), orden ascendente, limitar a 1
            $yearsEntities = $this->yearRepository->findBy(['status' => 1], ['year' => 'ASC'], 1);
        } else {
            // Para otras páginas, obtener todos los años activos
            $yearsEntities = $this->yearRepository->findBy(['status' => 1], ['year' => 'ASC']);
        }

        $years = [];
        $defaultYearId = null;

        foreach ($yearsEntities as $yearEntity) {
            $years[$yearEntity->getYear()] = $yearEntity->getId();
            if ($defaultYearId === null) {
                $defaultYearId = $yearEntity->getId();
            }
        }

        $field = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        // En creación, setear el primer año activo como valor por defecto
        if ($pageName === Crud::PAGE_NEW && $defaultYearId !== null) {
            $field->setFormTypeOption('data', $defaultYearId);
        }

        return $field;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new MonthlySummary();
        $entity->setUser($this->getUser());
        return $entity;
    }

    // public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     /** @var \App\Entity\User $user */
    //     $user = $this->getUser();

    //     if (!$entityInstance instanceof MonthlySummary) {
    //         return;
    //     }

    //     $month = $entityInstance->getMonth();
    //     $year = $entityInstance->getYear();

    //     $existing = $entityManager->getRepository(MonthlySummary::class)->findOneBy([
    //         'user' => $user,
    //         'month' => $month,
    //         'year' => $year,
    //     ]);

    //     if ($existing) {
    //         $this->addFlash('warning', 'Ya existe un resumen mensual para este mes y año.');
    //         return;
    //     }

    //     $this->addFlash('success', 'Se ha generado un resumen mensual para este mes y año.');

    //     parent::persistEntity($entityManager, $entityInstance);
    // }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof MonthlySummary) {
            return;
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true) && $user->getStatus()) {
            $this->addFlash('warning', '
                <div class="custom-flash-message">
                    <strong>Acceso Restringido</strong><br>
                    Para autorizar el acceso a los módulos, contáctame a través de cualquiera de mis redes sociales:<br><br>
                    <a href="https://www.facebook.com/PabloGarciaJC" class="custom-link" target="_blank" title="Facebook" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a> |
                    <a href="https://www.instagram.com/pablogarciajc" class="custom-link" target="_blank" title="Instagram" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-instagram"></i> Instagram
                    </a> |
                    <a href="https://www.linkedin.com/in/pablogarciajc" class="custom-link" target="_blank" title="LinkedIn" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a> |
                    <a href="https://www.youtube.com/channel/UC5I4oY7BeNwT4gBu1ZKsEhw" class="custom-link" target="_blank" title="YouTube" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-youtube"></i> YouTube
                    </a>
                </div>
            ');
            return;
        }

        $month = $entityInstance->getMonth();
        $year = $entityInstance->getYear();

        $existing = $entityManager->getRepository(MonthlySummary::class)->findOneBy([
            'user' => $user,
            'month' => $month,
            'year' => $year,
        ]);

        if ($existing) {
            $this->addFlash('warning', 'Ya existe un resumen mensual para este mes y año.');
            return;
        }


        $this->addFlash('success', 'Se ha generado un resumen mensual para este mes y año.');

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Informe Mensual')
            ->setEntityLabelInPlural('Informe Mensuales')
            ->setPageTitle(Crud::PAGE_INDEX, 'Informe Mensual')
            ->setSearchFields(['month', 'year', 'totalIncome', 'saving'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $user = $this->getUser();

        if ($user) {
            $qb->andWhere('entity.user = :currentUser')->setParameter('currentUser', $user);
        }

        return $qb;
    }

    private function createNumberField(string $name, string $label, string $pageName, ?float $default = null, bool $mapped = true, bool $readonly = false, array $rowClass = []): NumberField
    {
        $inputAttributes = ['class' => 'form-control'];
        if ($readonly) {
            $inputAttributes['readonly'] = true;
        }

        $field = NumberField::new($name, $label)
            ->setNumDecimals(2)
            ->setFormTypeOption('mapped', $mapped)
            ->setFormTypeOption('grouping', true)
            ->setFormTypeOption('attr', $inputAttributes)
            ->setFormTypeOption('label_attr', ['class' => 'form-control-label'])
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && $default !== null) {
            $field->setFormTypeOption('data', $default);
        }

        return $field;
    }

    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }

    private function sumTotalAmounts(array $items): float
    {
        $sum = 0.0;
        foreach ($items as $item) {
            $sum += (float) ($item['total_amount'] ?? 0);
        }
        return $sum;
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewDetails = Action::new('viewDetails', 'Ver detalles')
            ->linkToCrudAction('viewDetails');

        $duplicate = Action::new('Generar mes siguiente', 'Generar mes siguiente')
            ->linkToRoute('admin_prepare_next_month')
            ->createAsGlobalAction();

        return $actions
            ->add(Crud::PAGE_INDEX, $viewDetails)
            ->add(Crud::PAGE_EDIT, $viewDetails)
            ->add(Crud::PAGE_INDEX, $duplicate);
    }

    /**
     * Ruta para preparar todos los registros necesarios para el mes siguiente.
     */
    #[Route("/admin/prepare-next-month", name: "admin_prepare_next_month")]
    public function prepareNextMonth(EntityManagerInterface $entityManager): RedirectResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // APLICA LA MISMA VALIDACIÓN AQUÍ
        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true) && $user->getStatus()) {
            $this->addFlash('warning', '
            <div class="custom-flash-message">
                <strong>Acceso Restringido</strong><br>
                Para autorizar el acceso a los módulos, contáctame a través de cualquiera de mis redes sociales:<br><br>
                <a href="https://www.facebook.com/PabloGarciaJC" class="custom-link" target="_blank" title="Facebook" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-facebook"></i> Facebook
                </a> |
                <a href="https://www.instagram.com/pablogarciajc" class="custom-link" target="_blank" title="Instagram" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-instagram"></i> Instagram
                </a> |
                <a href="https://www.linkedin.com/in/pablogarciajc" class="custom-link" target="_blank" title="LinkedIn" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a> |
                <a href="https://www.youtube.com/channel/UC5I4oY7BeNwT4gBu1ZKsEhw" class="custom-link" target="_blank" title="YouTube" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-youtube"></i> YouTube
                </a>
            </div>
        ');
            return $this->redirectToRoute('admin_monthly_summary_index');
        }
        // Obtiene el primer mes inactivo
        $targetMonth = $this->getFirstInactiveMonth();
        if (!$targetMonth) {
            $this->addFlash('warning', 'No se encontró ningún mes inactivo para asignar.');
            return $this->redirectToRoute('admin_monthly_summary_index');
        }

        $targetMonthId = $targetMonth->getId();

        try {
            // Procesar servicios
            $this->cloneEntitiesForNextMonth(
                $entityManager,
                Service::class,
                $user,
                $targetMonthId,
                'servicios',
                'admin_service_index'
            );

            // Procesar pagos al contado
            $this->cloneEntitiesForNextMonth(
                $entityManager,
                CashPayment::class,
                $user,
                $targetMonthId,
                'pagos al contado',
                'admin_cash_payment_index'
            );

            // Procesar ingresos
            $this->cloneEntitiesForNextMonth(
                $entityManager,
                Income::class,
                $user,
                $targetMonthId,
                'ingresos',
                'admin_income_index'
            );

            // Procesar objetivos
            $this->cloneEntitiesForNextMonth(
                $entityManager,
                Goal::class,
                $user,
                $targetMonthId,
                'objetivos',
                'admin_goal_index'
            );
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());
            return $this->redirectToRoute('admin_monthly_summary_index');
        }

        $this->addFlash('success', '¡Listo! los meses se han generado correctamente');
        return $this->redirectToRoute('admin_monthly_summary_index');
    }

    /**
     * Obtiene el primer mes inactivo (status = 1) ordenado descendente por id
     */
    private function getFirstInactiveMonth()
    {
        $months = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC'], 1);
        return $months ? $months[0] : null;
    }

    /**
     * Clona y persiste entidades para el siguiente meses
     */
    private function cloneEntitiesForNextMonth(EntityManagerInterface $entityManager, string $entityClass, $user, int $monthId, string $entityName, string $redirectRoute): void
    {
        $repository = $entityManager->getRepository($entityClass);

        // Obtiene registros predeterminados del usuario
        $defaults = $repository->findBy([
            'user' => $user,
            'isDefault' => true,
        ]);

        // Verifica si ya existen registros generados para ese mes y usuario
        $existing = $repository->findBy([
            'user' => $user,
            'month' => $monthId,
            'isDefault' => false,
        ]);

        if (count($existing) > 0) {
            throw new \Exception("Ya se han generado datos para los meses.");
        }

        // Clona y guarda los registros para el nuevo mes
        foreach ($defaults as $entity) {
            $newEntity = clone $entity;
            $newEntity->setUser($user);
            $newEntity->setMonth($monthId);
            $newEntity->setIsDefault(false);
            $entityManager->persist($newEntity);
        }

        $entityManager->flush();
    }

    /**
     * @Route("/admin/monthly-summary/view-details", name="admin_monthly_summary_view_details")
     */
    public function viewDetails(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $members = $this->memberRepository->findBy(['user' => $user->getId()]);

        $id = $request->query->get('entityId');
        $monthlySummary = $em->getRepository(MonthlySummary::class)->find($id);

        $balances = [];
        $services = [];
        $credit = [];
        $goal = [];

        foreach ($members as $member) {
            $services = $this->serviceRepository->getTotalServicesByMember($member->getId(), $user->getId(), $monthlySummary->getMonth());
            $cashPayment = $this->cashPaymentRepository->getTotalByMemberId($member->getId(), $user->getId(), $monthlySummary->getMonth());
            $credit = $this->creditRepository->getTotalCreditByMemberId($member->getId(), $user->getId());
            $goal = $this->goalRepository->getTotalGoalByMemberId($member->getId(), $user->getId(), $monthlySummary->getMonth());
            $totalCombined = $services + $cashPayment + $credit + $goal;

            $balances[] = [
                'memberName' => $member->getName(),
                'bankBalance' => $totalCombined,
            ];
        }

        $services = $this->serviceRepository->getTotalServicesGroupedByMonthAndMember($user->getId(), $monthlySummary->getMonth());
        $cashPayment = $this->cashPaymentRepository->getCashPaymentsByMonthAndMember($user->getId(), $monthlySummary->getMonth());
        $goal = $this->goalRepository->getGoalsGroupedByMonthAndMember($user->getId(), $monthlySummary->getMonth());
        $credit = $this->creditRepository->getCreditsByUserAndMember($user->getId());

        return $this->render('admin/monthly_summary/details.html.twig', [
            'monthlySummary' => $monthlySummary,
            'currencySymbol' => $this->getActiveCurrencySymbol(),
            'balances' => $balances,
            'services' => $services,
            'cashPayments' => $cashPayment,
            'goals' => $goal,
            'credits' => $credit,

        ]);
    }
}
