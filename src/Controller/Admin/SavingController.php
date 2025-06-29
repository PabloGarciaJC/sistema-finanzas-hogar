<?php

namespace App\Controller\Admin;

use App\Entity\Saving;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SavingController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Saving::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('member', 'Miembro'),
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            MoneyField::new('amount', 'Monto')->setCurrency('EUR'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ahorros')
            ->setEntityLabelInPlural('Ahorros')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Ahorros')
            ->setSearchFields(['member.name', 'month', 'year']);
    }
}
