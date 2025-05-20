<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class MonthlySummaryCrudController extends AbstractCrudController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;

    public function __construct(IncomeRepository $incomeRepository, ServiceRepository $serviceRepository)
    {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Valores por defecto
        $defaultIncomeValue = ($data = $this->incomeRepository->getIncomeOptions()) ? reset($data) / 100 : null;
        $defaultServiceValue = ($data = $this->serviceRepository->getTotalServiceSql()) ? reset($data) / 100 : null;
        $defaultRemainingBalanceValue = $defaultIncomeValue !== null && $defaultServiceValue !== null ? $defaultIncomeValue - $defaultServiceValue : null;

        // Meses
        $months = [
            'Enero' => 1,
            'Febrero' => 2,
            'Marzo' => 3,
            'Abril' => 4,
            'Mayo' => 5,
            'Junio' => 6,
            'Julio' => 7,
            'Agosto' => 8,
            'Septiembre' => 9,
            'Octubre' => 10,
            'Noviembre' => 11,
            'Diciembre' => 12,
        ];

        // Años
        $currentYear = (int) date('Y');
        $years = array_combine(range($currentYear - 10, $currentYear + 10), range($currentYear - 10, $currentYear + 10));

        $monthField = ChoiceField::new('month', 'Mes')->setChoices($months);
        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        $yearField = ChoiceField::new('year', 'Año')->setChoices($years);
        if ($pageName === Crud::PAGE_NEW) {
            $yearField->setFormTypeOption('data', $currentYear);
        }

        $totalIncomeField = NumberField::new('totalIncome', 'Ingresos Totales')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultIncomeValue !== null) {
            $totalIncomeField->setFormTypeOption('data', $defaultIncomeValue);
        }

        $remainingBalanceField = NumberField::new('remainingBalance', 'Saldo Restante')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultRemainingBalanceValue !== null) {
            $remainingBalanceField->setFormTypeOption('data', $defaultRemainingBalanceValue);
        }

        $serviceTotalField = NumberField::new('debt_total', 'Deuda Total')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceValue !== null) {
            $serviceTotalField->setFormTypeOption('data', $defaultServiceValue);
        }

        $bankDebtMenberOneField = NumberField::new('bankDebtMenberOne', 'Importe Banco Pablo')->setNumDecimals(2);
        $bankDebtMemberTwoField = NumberField::new('bankDebtMemberTwo', 'Importe Banco Vero')->setNumDecimals(2);

        return [
            $monthField,
            $yearField,
            $totalIncomeField,
            $remainingBalanceField,
            $serviceTotalField,
            $bankDebtMenberOneField,
            $bankDebtMemberTwoField,
        ];
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
                'bankDebtMenberOne',
                'bankDebtMemberTwo',
            ]);
    }
}
