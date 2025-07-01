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
use App\Repository\MonthlySummaryRepository;
use App\Repository\CashPaymentRepository;






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
use App\Repository\MemberRepository;

class MonthlySummaryController extends AbstractCrudController
{
    private MonthlySummaryRepository $monthlySummaryRepository;
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
        MonthlySummaryRepository $monthlySummaryRepository,
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
        $this->monthlySummaryRepository = $monthlySummaryRepository;
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
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();
        $defaults = $this->calculateDefaultValues();

        $fields = [];

        $fields[] = AssociationField::new('user', 'Familia')->hideOnForm();

        $fields[] = $this->createFormattedNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaults['income'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('debt_total', 'Deuda Total', $pageName, $defaults['bankDebtTotal'], $currencySymbol, $rowClass);

        $fields[] = $this->createNumberField('remainingBalance', 'Saldo Restante', $pageName, $defaults['remainingBalance'], false, true, $rowClass)
            ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : '');

        $fields[] = $this->createMonthChoiceField($pageName, $rowClass);
        $fields[] = $this->createYearChoiceField($pageName, $rowClass);

        return $fields;
    }

    private function calculateDefaultValues(): array
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $income = $this->incomeRepository->getIncomeOptions($user->getId());
        $service = $this->serviceRepository->getTotalServiceSql($user->getId());
        $cashPayment = $this->cashPaymentRepository->getTotalCashPayment($user->getId());
        $credit = $this->creditRepository->getTotalCredit($user->getId());
        $goalTotal = $this->goalRepository->getGoalTotal($user->getId());
        $bankDebtTotal = $service + $cashPayment + $credit + $goalTotal;
        
        $remainingBalance = (float) $income - $bankDebtTotal;

        return [
            'income' => $income,
            'bankDebtTotal' => $bankDebtTotal,
            'remainingBalance' => $remainingBalance,
        ];
    }

    private function createFormattedNumberField(string $name, string $label, string $pageName, ?float $default, string $currencySymbol, array $rowClass): NumberField
    {
        return $this->createNumberField($name, $label, $pageName, $default, true, true, $rowClass)
            ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : '');
    }

    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthsEntities = $this->monthRepository->findAll();
        $months = [];
        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
        }

        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        return $monthField;
    }

    private function createYearChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $activeYearsEntities = $this->yearRepository->findBy(['status' => 1]);
        $years = [];
        foreach ($activeYearsEntities as $yearEntity) {
            $years[$yearEntity->getYear()] = $yearEntity->getId();
        }

        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            $defaultYearId = reset($years);
            $yearField->setFormTypeOption('data', $defaultYearId);
        }

        return $yearField;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new MonthlySummary();
        $entity->setUser($this->getUser());
        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resumen Mensual')
            ->setEntityLabelInPlural('Resumen Mensuales')
            ->setPageTitle(Crud::PAGE_INDEX, 'Resumen Mensual')
            ->setSearchFields([
                'month',
                'year',
                'totalIncome',
                'remainingBalance',
            ]);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $user = $this->getUser();

        if ($user) {
            $qb->andWhere('entity.user = :currentUser')
                ->setParameter('currentUser', $user);
        }

        return $qb;
    }

    private function getDefaultValue($data): ?float
    {
        return $data ? reset($data) / 100 : null;
    }

    private function createNumberField(
        string $name,
        string $label,
        string $pageName,
        ?float $default = null,
        bool $mapped = true,
        bool $readonly = false,
        array $rowClass = []
    ): NumberField {
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

    // --- Acción personalizada "Ver detalles" ---
    public function configureActions(Actions $actions): Actions
    {
        $viewDetails = Action::new('viewDetails', 'Ver detalles', '')
            ->linkToCrudAction('viewDetails');

        return $actions
            ->add(Crud::PAGE_INDEX, $viewDetails)
            ->add(Crud::PAGE_EDIT, $viewDetails);
    }

    /**
     * @Route("/admin/monthly-summary/{id}/view-details", name="admin_monthly_summary_view_details")
     */
    public function viewDetails(MonthlySummary $monthlySummary): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $members = $this->memberRepository->findBy(['user' => $user->getId()]);

        $servicesByMember = [];

        foreach ($members as $member) {
            $services = $this->serviceRepository->getTotalServicesByMember($member->getId(), $user->getId());
            $cashPayment = $this->cashPaymentRepository->getTotalByMemberId($member->getId(), $user->getId());
            $credit = $this->creditRepository->getTotalCreditByMemberId($member->getId(), $user->getId());
            $goal = $this->goalRepository->getTotalGoalByMemberId($member->getId(), $user->getId());
            $totalCombined = $services + $cashPayment + $credit + $goal;
            $servicesByMember[$member->getId()] = [
                'totalCombined' => $totalCombined,
            ];
        }

        // Totales generales
        $income = $this->incomeRepository->getIncomeOptions($user->getId());
        $service = $this->serviceRepository->getTotalServiceSql($user->getId());
        $cashPayment = $this->cashPaymentRepository->getTotalCashPayment($user->getId());
        $credit = $this->creditRepository->getTotalCredit($user->getId());
        $goalTotal = $this->goalRepository->getGoalTotal($user->getId());
        $bankDebtTotal = $service + $cashPayment + $credit + $goalTotal;
        $remainingBalance = (float) $income - $bankDebtTotal;

        $servicesByMember['totals'] = [
            'income' => $income,
            'bankDebtTotal' => $bankDebtTotal,
            'remainingBalance' => $remainingBalance,
        ];

        return $this->render('admin/monthly_summary/details.html.twig', [
            'monthlySummary' => $monthlySummary,
            'members' => $members,
            'servicesByMember' => $servicesByMember,
            'currencySymbol' => $this->getActiveCurrencySymbol(),
        ]);
    }
}
