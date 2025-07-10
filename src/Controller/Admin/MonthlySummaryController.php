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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

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
        $fields[] = AssociationField::new('user', 'Familia')->hideOnForm();
        $fields[] = $this->createFormattedNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaults['income'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('debt_total', 'Deuda Total', $pageName, $defaults['bankDebtTotal'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('savings', 'Ahorros', $pageName, $defaults['savings'], $currencySymbol, $rowClass);
        $fields[] = $this->createMonthChoiceField($pageName, $rowClass);
        $fields[] = $this->createYearChoiceField($pageName, $rowClass);

        // Servicios
        $services = $this->serviceRepository->getAllServiceSql($user->getId());
        if (count($services) > 0) {
            $lines = [];
            $total = 0;
            foreach ($services as $service) {
                $description = strip_tags($service['description']);
                $amountNumber = $service['amount'];
                $amount = number_format($amountNumber, 2, ',', '.');
                $lines[] = "{$description} ({$amount} {$currencySymbol})";
                $total += $amountNumber;
            }
            $formattedTotal = number_format($total, 2, ',', '.');
            $text = implode("\n", $lines) . "\nTotal: {$formattedTotal} {$currencySymbol}";
        } else {
            $text = "No hay Servicios";
        }

        $fields[] = TextareaField::new('services_list', 'Servicios')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('disabled', true)
            ->setFormTypeOption('data', trim($text))
            ->onlyOnForms();

        // Pagos al contado
        $cashPayments = $this->cashPaymentRepository->getAllCashPaymentSql($user->getId());
        if (count($cashPayments) > 0) {
            $lines = [];
            $total = 0;
            foreach ($cashPayments as $payment) {
                $description = strip_tags($payment['description']);
                $amountNumber = $payment['amount'];
                $amount = number_format($amountNumber, 2, ',', '.');
                $lines[] = "{$description} ({$amount} {$currencySymbol})";
                $total += $amountNumber;
            }
            $formattedTotal = number_format($total, 2, ',', '.');
            $text = implode("\n", $lines) . "\nTotal: {$formattedTotal} {$currencySymbol}";
        } else {
            $text = "No hay Pagos al Contado";
        }

        $fields[] = TextareaField::new('cash_payments_list', 'Pagos al Contado')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('disabled', true)
            ->setFormTypeOption('data', trim($text))
            ->onlyOnForms();

        // Créditos
        $credits = $this->creditRepository->getAllCreditSql($user->getId());

        if (count($credits) > 0) {
            $lines = [];
            $total = 0;

            foreach ($credits as $credit) {
                $bank = strip_tags($credit['bank_entity']);
                $installmentAmount = number_format($credit['installment_amount'], 2, ',', '.');
                $lines[] = "{$bank} ({$installmentAmount} {$currencySymbol})";
                $total += $credit['installment_amount'];
            }

            $formattedTotal = number_format($total, 2, ',', '.');
            $text = implode("\n", $lines) . "\nTotal: {$formattedTotal} {$currencySymbol}";
        } else {
            $text = "No hay Créditos";
        }

        $fields[] = TextareaField::new('credits_list', 'Créditos')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('disabled', true)
            ->setFormTypeOption('data', trim($text))
            ->onlyOnForms();

        // Metas
        $goals = $this->goalRepository->getAllGoalSql($user->getId());
        if (count($goals) > 0) {
            $lines = [];
            $total = 0;

            foreach ($goals as $goal) {
                $description = strip_tags($goal['description']);
                $amountNumber = $goal['amount'];
                $amount = number_format($amountNumber, 2, ',', '.');
                $lines[] = "{$description} ({$amount} {$currencySymbol})";
                $total += $amountNumber;
            }

            $formattedTotal = number_format($total, 2, ',', '.');
            $text = implode("\n", $lines) . "\nTotal: {$formattedTotal} {$currencySymbol}";
        } else {
            $text = "No hay Metas";
        }

        $fields[] = TextareaField::new('goals_list', 'Metas')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('disabled', true)
            ->setFormTypeOption('data', trim($text))
            ->onlyOnForms();

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
                'saving',
            ])
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
     * GUARDA EL JSON ANTES DE PERSISTIR
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof MonthlySummary) {
            return;
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $members = $this->memberRepository->findBy(['user' => $user->getId()]);

        $balances = [];
        $servicesAll = [];
        $cashPaymentAll = [];
        $creditAll = [];
        $goalAll = [];

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

        // TODOS LOS SERVICIOS DE ESTE MIEMBRO
        $servicesAll[] = ['services' => $this->serviceRepository->getAllServiceSql($user->getId())];
        $cashPaymentAll[] = ['cashPayment' => $this->cashPaymentRepository->getAllCashPaymentSql($user->getId())];
        $creditAll[] = ['credit' => $this->creditRepository->getAllCreditSql($user->getId())];
        $goalAll[] = ['goal' => $this->goalRepository->getAllGoalSql($user->getId())];

        $entityInstance->setBankBalance($balances);
        $entityInstance->setServices($servicesAll);
        $entityInstance->setCashPayment($cashPaymentAll);
        $entityInstance->setCredit($creditAll);
        $entityInstance->setGoal($goalAll);

        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * @Route("/admin/monthly-summary/view-details", name="admin_monthly_summary_view_details")
     */
    public function viewDetails(Request $request, EntityManagerInterface $em): Response
    {
        $id = $request->query->get('entityId');
        $monthlySummary = $em->getRepository(MonthlySummary::class)->find($id);
        return $this->render('admin/monthly_summary/details.html.twig', [
            'monthlySummary' => $monthlySummary,
            'currencySymbol' => $this->getActiveCurrencySymbol(),
        ]);
    }
}
