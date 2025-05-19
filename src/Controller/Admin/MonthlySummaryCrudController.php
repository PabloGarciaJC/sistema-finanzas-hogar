<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Repository\IncomeRepository;

class MonthlySummaryCrudController extends AbstractCrudController
{

    private IncomeRepository $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $totalIncome = $this->incomeRepository->getTotalIncomeSql();

        $fields = [
            AssociationField::new('member', 'Miembro'),
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            TextField::new('totalIncomeCalculated', 'Ingreso total')
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('disabled', in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT]))
                ->setFormTypeOption('data', in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT]) ? $totalIncome . ' €' : null)
                ->formatValue(fn($value, $entity) => $value ?? $totalIncome . ' €'),
            NumberField::new('totalDebt', 'Deuda total'),
            NumberField::new('savings', 'Ahorros'),
            NumberField::new('balance', 'Balance'),
            TextEditorField::new('notes', 'Notas'),
        ];

        return $fields;
    }



    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resumen Mensual')
            ->setEntityLabelInPlural('Resumen Mensual')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Resumen Mensual')
            ->setSearchFields(['member.name', 'description', 'status',])
            ->setSearchFields(['member.name', 'month', 'year', 'notes',]);
    }
}
