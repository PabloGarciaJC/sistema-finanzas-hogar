<?php

namespace App\Controller\Admin;

use App\Entity\Year;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class YearController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Year::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('year', 'Año');
        yield BooleanField::new('status', 'Activo');
    }
}
