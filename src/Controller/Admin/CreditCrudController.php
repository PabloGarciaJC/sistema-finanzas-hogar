<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CreditCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            AssociationField::new('member'),

            TextField::new('bank_entity', 'Banco'),

            MoneyField::new('total_amount', 'Monto total')->setCurrency('USD'),

            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Monthly' => 'Monthly',
                    'Bimonthly' => 'Bimonthly',
                    'Quarterly' => 'Quarterly',
                ]),

            DateField::new('start_date', 'Fecha de inicio'),

            MoneyField::new('monthly_payment', 'Pago mensual')->setCurrency('USD'),

            MoneyField::new('remaining_amount', 'Monto restante')->setCurrency('USD'),

            TextField::new('status', 'Estado'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Créditos')
            ->setEntityLabelInPlural('Créditos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Créditos')
            ->setSearchFields(['member.name', 'bankEntity', 'status']);
    }
    
}
