<?php

namespace App\Controller\Admin;

use App\Entity\Period;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PeriodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Period::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            TextField::new('status', 'Estado'),
        ];
    }
}
