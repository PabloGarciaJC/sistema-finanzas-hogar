<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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

        $rawOptionsIncome = $this->incomeRepository->getIncomeOptions();
        $defaultIncomeValue = !empty($rawOptionsIncome) ? reset($rawOptionsIncome) / 100 : null;

        $rawOptionService = $this->serviceRepository->getTotalServiceSql();
        $defaultServiceValue = !empty($rawOptionService) ? reset($rawOptionService) / 100 : null;

        $defaultServiceSavings =  $defaultIncomeValue - $defaultServiceValue;


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
        $years = [];
        for ($i = $currentYear - 10; $i <= $currentYear + 10; $i++) {
            $years[$i] = $i;
        }

        // Campos
        $monthField = ChoiceField::new('month', 'Mes')->setChoices($months);
        if ($pageName === Crud::PAGE_NEW) {
            $monthField = $monthField->setFormTypeOption('data', 1);
        }

        $yearField = ChoiceField::new('year', 'Año')->setChoices($years);
        if ($pageName === Crud::PAGE_NEW) {
            $yearField = $yearField->setFormTypeOption('data', $currentYear);
        }

        $totalIncomeField = NumberField::new('totalIncome', 'Ingresos Totales')
            ->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultIncomeValue !== null) {
            $totalIncomeField = $totalIncomeField->setFormTypeOption('data', $defaultIncomeValue);
        }

        $totalServiceField = NumberField::new('totalDebt', 'Deuda Total')
            ->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceValue !== null) {
            $totalServiceField = $totalServiceField->setFormTypeOption('data', $defaultServiceValue);
        }

        $totalServiceSavings = NumberField::new('savings', 'Ahorros')
            ->setNumDecimals(2);
        if ($pageName === Crud::PAGE_NEW && $defaultServiceSavings !== null) {
            $totalServiceSavings = $totalServiceSavings->setFormTypeOption('data', $defaultServiceSavings);
        }

        return [
            AssociationField::new('member', 'Miembro'),
            $monthField,
            $yearField,
            $totalIncomeField,
            $totalServiceField,
            $totalServiceSavings,
            MoneyField::new('balance', 'Balance')
                ->setCurrency('EUR')
                ->setStoredAsCents(false)
                ->setNumDecimals(2),
            TextEditorField::new('notes', 'Notas'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resumen Mensual')
            ->setEntityLabelInPlural('Resumen Mensual')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Resumen Mensual')
            ->setSearchFields(['member.name', 'month', 'year', 'notes']);
    }
}
