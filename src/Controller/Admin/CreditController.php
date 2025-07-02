<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class CreditController extends AbstractCrudController
{
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;
    private CurrencyRepository $currencyRepository;
    private EntityManagerInterface $em;

    public function __construct(MonthRepository $monthRepository, YearRepository $yearRepository, CurrencyRepository $currencyRepository, EntityManagerInterface $em)
    {
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
        $this->currencyRepository = $currencyRepository;
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),

            AssociationField::new('member', 'Miembro')
                ->setFormTypeOption('row_attr', $rowClass),

            TextField::new('bankEntity', 'Banco')
                ->setFormTypeOption('row_attr', $rowClass),

            NumberField::new('installmentAmount', 'Importe por cuota')
                ->setFormTypeOption('row_attr', $rowClass)
                ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : ''),

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

            NumberField::new('totalAmount', 'Importe total')
                ->setFormTypeOption('row_attr', $rowClass)
                ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : ''),

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

        // Seleccionar mes por defecto (Enero)
        $credit->setMonth(1);

        // Seleccionar año activo por defecto (similar a como haces en configureYearField)
        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $credit->setYear($activeYears[0]->getYear());
        }

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

    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        if ($currency) {
            $this->em->refresh($currency);
            return $currency->getSymbol();
        }

        return '';
    }
}
