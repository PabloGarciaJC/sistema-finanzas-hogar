<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CreditCrudController extends AbstractCrudController
{
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;

    public function __construct(
        MonthRepository $monthRepository,
        YearRepository $yearRepository
    ) {
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),

            AssociationField::new('member', 'Miembro')
                ->setFormTypeOption('row_attr', $rowClass),

            TextField::new('bankEntity', 'Banco')
                ->setFormTypeOption('row_attr', $rowClass),

            MoneyField::new('installmentAmount', 'Importe por cuota')
                ->setCurrency('EUR')
                ->setFormTypeOption('row_attr', $rowClass),

            IntegerField::new('installments', 'Número de cuotas')
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

            $this->createMonthChoiceField($pageName, $rowClass),

            $this->createYearChoiceField($pageName, $rowClass),

            MoneyField::new('totalAmount', 'Importe total')
                ->setCurrency('EUR')
                ->setFormTypeOption('row_attr', $rowClass),

            ChoiceField::new('status', 'Estado')
                ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
                ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary'])
                ->setFormTypeOption('row_attr', $rowClass),
        ];
    }


    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthsEntities = $this->monthRepository->findAll();
        $months = [];
        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
        }

        return ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);
    }

    private function createYearChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $yearsEntities = $this->yearRepository->findBy(['status' => 1]);
        $years = [];
        foreach ($yearsEntities as $yearEntity) {
            // Clave y valor iguales, el año numérico
            $years[$yearEntity->getYear()] = $yearEntity->getYear();
        }

        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            $yearField->setFormTypeOption('data', reset($years));
        }

        return $yearField;
    }


    public function createEntity(string $entityFqcn)
    {
        $credit = new Credit();
        $credit->setStatus('Activo');
        $credit->setFrequency('Mensual');
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
}
