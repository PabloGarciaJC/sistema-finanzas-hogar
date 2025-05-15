<?php

namespace App\Controller\Admin;

use App\Entity\Saving;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SavingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Saving::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('member', 'Miembro'), // si tienes una relación con la entidad Member
            IntegerField::new('month', 'Mes'),
            IntegerField::new('year', 'Año'),
            MoneyField::new('amount', 'Monto')->setCurrency('USD'),
        ];
    }
}
