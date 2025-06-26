<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\CreditRepository;
use App\Repository\GoalRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MonthlySummaryCrudController extends AbstractCrudController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;
    private CreditRepository $creditRepository;
    private GoalRepository $goalRepository;

    public function __construct(
        IncomeRepository $incomeRepository,
        ServiceRepository $serviceRepository,
        CreditRepository $creditRepository,
        GoalRepository $goalRepository
    ) {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
        $this->creditRepository = $creditRepository;
        $this->goalRepository = $goalRepository;
    }

    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $defaultIncomeValue = $this->getDefaultValue($this->incomeRepository->getIncomeOptions());
        $defaultServiceValue = $this->getDefaultValue($this->serviceRepository->getTotalServiceSql());
        $defaultCreditMemberOne = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberOne());
        $defaultCreditMemberTwo = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberTwo());
        $defaultGoalTotalTwo = $this->getDefaultValue($this->goalRepository->getGoalTotal());
        $defaultRemainingBalance = $defaultIncomeValue - $defaultServiceValue - $defaultCreditMemberOne - $defaultCreditMemberTwo - $defaultGoalTotalTwo;
        $defaultBankDebtTotal = $defaultServiceValue + $defaultCreditMemberOne + $defaultCreditMemberTwo + $defaultGoalTotalTwo;
        $defaultBankDebtMemberOne = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberOne(), $defaultCreditMemberOne);
        $defaultBankDebtMemberTwo = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberTwo(), $defaultCreditMemberTwo);

        $fields = [];

        $fields[] = AssociationField::new('user', 'Familia')->hideOnForm();

        // Campos solo lectura con clases CSS aplicadas
        $fields[] = $this->createNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaultIncomeValue, true, true);
        $fields[] = $this->createNumberField('debt_total', 'Deuda Total', $pageName, $defaultBankDebtTotal, true, true);
        $fields[] = $this->createNumberField('remainingBalance', 'Saldo Restante', $pageName, $defaultRemainingBalance, true, true);
        $fields[] = $this->createNumberField('bankDebtMemberOne', 'Importe Banco Pablo', $pageName, $defaultBankDebtMemberOne, true, true);
        $fields[] = $this->createNumberField('bankDebtMemberTwo', 'Importe Banco Vero', $pageName, $defaultBankDebtMemberTwo, true, true);

        $months = array_combine(
            ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            range(1, 12)
        );
        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', ['class' => 'form-group col-md-4 col-xxl-7']);
        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }
        $fields[] = $monthField;

        $currentYear = (int) date('Y');
        $years = array_combine(range($currentYear - 10, $currentYear + 10), range($currentYear - 10, $currentYear + 10));
        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', ['class' => 'form-group col-md-4 col-xxl-7']);
        if ($pageName === Crud::PAGE_NEW) {
            $yearField->setFormTypeOption('data', $currentYear);
        }
        $fields[] = $yearField;

        return $fields;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Resumen Mensual')
            ->setSearchFields([
                'month',
                'year',
                'totalIncome',
                'remainingBalance',
                'bankDebtMemberOne',
                'bankDebtMemberTwo',
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

    private function calculateTotalMemberDebt($serviceData, $creditValue): ?float
    {
        $serviceValue = $this->getDefaultValue($serviceData);
        return ($serviceValue !== null && $creditValue !== null) ? $serviceValue + $creditValue : null;
    }

    private function createNumberField(
        string $name,
        string $label,
        string $pageName,
        ?float $default = null,
        bool $mapped = true,
        bool $readonly = false
    ): NumberField {
        $attr = ['class' => 'form-control'];
        if ($readonly) {
            $attr['readonly'] = true;
        }

        $field = NumberField::new($name, $label)
            ->setNumDecimals(2)
            ->setFormTypeOption('mapped', $mapped)
            ->setFormTypeOption('grouping', true)
            ->setFormTypeOption('attr', $attr)
            ->setFormTypeOption('label_attr', ['class' => 'form-control-label']);

        if ($pageName === Crud::PAGE_NEW && $default !== null) {
            $field->setFormTypeOption('data', $default);
        }

        return $field;
    }
}
