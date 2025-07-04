<?php

namespace App\Controller\Admin;

use App\Entity\Period;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PeriodController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Period::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            TextField::new('status', 'Estado'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Periodos')
            ->setEntityLabelInPlural('Periodos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Periodos');
    }
}
