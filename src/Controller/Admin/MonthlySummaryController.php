<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    public function __construct(
        IncomeRepository $incomeRepository,
        ServiceRepository $serviceRepository,
        CreditRepository $creditRepository,
        GoalRepository $goalRepository,
        CurrencyRepository $currencyRepository,
        MonthRepository $monthRepository,
        YearRepository $yearRepository,
        MemberRepository $memberRepository,
        CashPaymentRepository $cashPaymentRepository
    ) {
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
            $services = $this->serviceRepository->getTotalServicesByMember($member->getId(), $user->getId());
            $cashPayment = $this->cashPaymentRepository->getTotalByMemberId($member->getId(), $user->getId());
            $credit = $this->creditRepository->getTotalCreditByMemberId($member->getId(), $user->getId());
            $goal = $this->goalRepository->getTotalGoalByMemberId($member->getId(), $user->getId());
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

    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        if ($pageName === Crud::PAGE_NEW) {
            // Obtener solo el primer mes desactivado (status = false)
            $monthsEntities = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);
        } else {
            // Todos los meses para otras páginas
            $monthsEntities = $this->monthRepository->findAll();
        }

        $months = [];
        $defaultMonthId = null;

        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
            if ($defaultMonthId === null) {
                $defaultMonthId = $monthEntity->getId();
            }
        }

        $field = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);

        // En creación, setear el primer mes desactivado como valor por defecto
        if ($pageName === Crud::PAGE_NEW && $defaultMonthId !== null) {
            $field->setFormTypeOption('data', $defaultMonthId);
        }

        return $field;
    }

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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$entityInstance instanceof MonthlySummary) {
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
            return; // ⬅️ DETIENE la persistencia
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

    public function configureActions(Actions $actions): Actions
    {
        $viewDetails = Action::new('viewDetails', 'Ver detalles', '')
            ->linkToCrudAction('viewDetails');

        return $actions
            ->add(Crud::PAGE_INDEX, $viewDetails)
            ->add(Crud::PAGE_EDIT, $viewDetails);
    }

    /**
     * @Route("/admin/monthly-summary/view-details", name="admin_monthly_summary_view_details")
     */
    public function viewDetails(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $members = $this->memberRepository->findBy(['user' => $user->getId()]);

        $balances = [];

        foreach ($members as $member) {
            $services = $this->serviceRepository->getTotalServicesByMember($member->getId(), $user->getId());
            $cashPayment = $this->cashPaymentRepository->getTotalByMemberId($member->getId(), $user->getId());
            $credit = $this->creditRepository->getTotalCreditByMemberId($member->getId(), $user->getId());
            $goal = $this->goalRepository->getTotalGoalByMemberId($member->getId(), $user->getId());
            $totalCombined = $services + $cashPayment + $credit + $goal;

            $balances[] = [
                'memberName' => $member->getName(),
                'bankBalance' => $totalCombined,
            ];
        }

        $id = $request->query->get('entityId');
        $monthlySummary = $em->getRepository(MonthlySummary::class)->find($id);

        return $this->render('admin/monthly_summary/details.html.twig', [
            'monthlySummary' => $monthlySummary,
            'currencySymbol' => $this->getActiveCurrencySymbol(),
            'balances' => $balances,
        ]);
    }
}
