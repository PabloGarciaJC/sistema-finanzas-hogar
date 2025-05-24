<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CreditCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Opciones para los campos de selección
        $months = $this->getMonthChoices();
        $years = $this->getYearChoices();

        return [
            AssociationField::new('member'),
            TextField::new('bank_entity', 'Banco'),

            MoneyField::new('monthly_payment', 'Importe')
                ->setCurrency('EUR'),

            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Mensual' => 'Mensual',
                    'Bimestral' => 'Bimestral',
                    'Trimestral' => 'Trimestral',
                    'Anual' => 'Anual',
                ])
                ->setFormTypeOption('placeholder', false),

            DateField::new('start_date', 'Fecha de inicio')
                ->setFormat('MMMM yyyy')
                ->onlyOnIndex(),

            DateField::new('start_date', 'Fecha de inicio')
                ->setFormat('MMMM yyyy')
                ->onlyOnDetail(),

            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->onlyOnForms(),

            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->setFormTypeOption('data', 2025)
                ->onlyOnForms(),

            MoneyField::new('total_amount', 'Importe total')
                ->setCurrency('EUR'),

            ChoiceField::new('status', 'Estado')
                ->setChoices([
                    'Activo' => 'Activo',
                    'Cancelado' => 'Cancelado',
                ])
                ->setFormTypeOption('placeholder', false)
                ->renderAsBadges([
                    'Activo' => 'success',
                    'Cancelado' => 'secondary',
                ]),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $credit = new Credit();
        $credit->setStatus('Activo');
        $credit->setFrequency('Mensual');
        $credit->setYear(2025);

        return $credit;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Crédito')
            ->setEntityLabelInPlural('Créditos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Créditos')
            ->setSearchFields(['member.name', 'bankEntity', 'status']);
    }

    private function getMonthChoices(): array
    {
        return [
            'Enero' => 1, 'Febrero' => 2, 'Marzo' => 3, 'Abril' => 4,
            'Mayo' => 5, 'Junio' => 6, 'Julio' => 7, 'Agosto' => 8,
            'Septiembre' => 9, 'Octubre' => 10, 'Noviembre' => 11, 'Diciembre' => 12,
        ];
    }

    private function getYearChoices(): array
    {
        $currentYear = (int) date('Y');
        return array_combine(
            range($currentYear - 10, $currentYear + 10),
            range($currentYear - 10, $currentYear + 10)
        );
    }
}
