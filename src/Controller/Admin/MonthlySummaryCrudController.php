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
        // Obtener valores por defecto desde los repositorios para prellenar el formulario
        $defaultIncomeValue = ($data = $this->incomeRepository->getIncomeOptions()) ? reset($data) / 100 : null;
        $defaultServiceValue = ($data = $this->serviceRepository->getTotalServiceSql()) ? reset($data) / 100 : null;
        $defaultRemainingBalanceValue = $defaultIncomeValue !== null && $defaultServiceValue !== null ? $defaultIncomeValue - $defaultServiceValue : null;
        $defaultServiceMemberOneValue = ($data = $this->serviceRepository->getTotalMemberOne()) ? reset($data) / 100 : null;
        $defaultServiceMemberTwoValue = ($data = $this->serviceRepository->getTotalMemberTwo()) ? reset($data) / 100 : null;

        // Definición de los meses para el campo de selección
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

        // Campo numérico para Ingresos Totales
        $totalIncomeField = NumberField::new('totalIncome', 'Ingresos Totales')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultIncomeValue !== null) {
            $totalIncomeField->setFormTypeOption('data', $defaultIncomeValue);
        }

        // Campo numérico para Deuda Total (servicios)
        $serviceTotalField = NumberField::new('debt_total', 'Deuda Total')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceValue !== null) {
            $serviceTotalField->setFormTypeOption('data', $defaultServiceValue);
        }

        // Campo numérico para Saldo Restante
        $remainingBalanceField = NumberField::new('remainingBalance', 'Saldo Restante')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultRemainingBalanceValue !== null) {
            $remainingBalanceField->setFormTypeOption('data', $defaultRemainingBalanceValue);
        }

        // Campo numérico para deuda del miembro uno
        $serviceMemberOneField = NumberField::new('bankDebtMenberOne', 'Importe Banco Pablo')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceMemberOneValue !== null) {
            $serviceMemberOneField->setFormTypeOption('data', $defaultServiceMemberOneValue);
        }

        // Campo numérico para deuda del miembro dos
        $serviceMemberTwoField = NumberField::new('bankDebtMemberTwo', 'Importe Banco Vero')->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceMemberTwoValue !== null) {
            $serviceMemberTwoField->setFormTypeOption('data', $defaultServiceMemberTwoValue);
        }

        // Campo de selección para el mes
        $monthField = ChoiceField::new('month', 'Mes')->setChoices($months);
        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        // Rango de años para el selector (desde 10 años atrás hasta 10 años adelante)
        $currentYear = (int) date('Y');
        $years = array_combine(
            range($currentYear - 10, $currentYear + 10),
            range($currentYear - 10, $currentYear + 10)
        );

        // Campo de selección para el año
        $yearField = ChoiceField::new('year', 'Año')->setChoices($years);
        if ($pageName === Crud::PAGE_NEW) {
            $yearField->setFormTypeOption('data', $currentYear);
        }

        return [
            $totalIncomeField,
            $serviceTotalField,
            $remainingBalanceField,
            $serviceMemberOneField,
            $serviceMemberTwoField,
            $monthField,
            $yearField,
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
