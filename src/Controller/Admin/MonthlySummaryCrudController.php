<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MonthlySummaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('member', 'Miembro'),
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            NumberField::new('totalIncome', 'Ingreso total'),
            NumberField::new('totalDebt', 'Deuda total'),
            NumberField::new('savings', 'Ahorros'),
            NumberField::new('balance', 'Balance'),
            TextEditorField::new('notes', 'Notas'),
        ];
    }
}
