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
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;

class CreditCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];

        $months = $this->getMonthChoices();
        $years = $this->getYearChoices();

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),

            AssociationField::new('member')
                ->setFormTypeOption('row_attr', $rowClass),

            TextField::new('bank_entity', 'Banco')
                ->setFormTypeOption('row_attr', $rowClass),

            MoneyField::new('monthly_payment', 'Importe')
                ->setCurrency('EUR')
                ->setFormTypeOption('row_attr', $rowClass),

            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Mensual' => 'Mensual',
                    'Bimestral' => 'Bimestral',
                    'Trimestral' => 'Trimestral',
                    'Anual' => 'Anual',
                ])
                ->setFormTypeOption('placeholder', false)
                ->setFormTypeOption('row_attr', $rowClass),

            DateField::new('start_date', 'Fecha de inicio')
                ->setFormat('MMMM yyyy')
                ->onlyOnIndex(),

            DateField::new('start_date', 'Fecha de inicio')
                ->setFormat('MMMM yyyy')
                ->onlyOnDetail(),

            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->onlyOnForms()
                ->setFormTypeOption('row_attr', $rowClass),

            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->setFormTypeOption('data', 2025)
                ->onlyOnForms()
                ->setFormTypeOption('row_attr', $rowClass),

            MoneyField::new('total_amount', 'Importe total')
                ->setCurrency('EUR')
                ->setFormTypeOption('row_attr', $rowClass),

            ChoiceField::new('status', 'Estado')
                ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
                ->setFormTypeOption('placeholder', false)
                ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary'])
                ->setFormTypeOption('row_attr', $rowClass),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $credit = new Credit();
        $credit->setStatus('Activo');
        $credit->setFrequency('Mensual');
        $credit->setYear(2025);
        $credit->setUser($this->getUser());
        return $credit;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Crédito')
            ->setEntityLabelInPlural('Créditos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Créditos')
            ->setSearchFields(['member.name', 'bankEntity', 'status']);
    }

    // Filtrar la lista para mostrar solo créditos del usuario logueado
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $user = $this->getUser();
        if ($user) {
            $qb->andWhere('entity.user = :currentUser')
               ->setParameter('currentUser', $user);
        }

        return $qb;
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
