<?php

namespace App\Controller\Admin;

use App\Entity\Month;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MonthController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Month::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $idField = IdField::new('id', 'ID')
            ->onlyOnIndex()
            ->onlyOnDetail();

        $nameField = TextField::new('name', 'Nombre')
            ->setRequired(true);

        if ($pageName === Crud::PAGE_INDEX) {
            return [$idField, $nameField];
        }

        return [$nameField];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Mes')
            ->setEntityLabelInPlural('Meses')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Meses')
            ->setSearchFields(['name']);
    }
}
