<?php

namespace App\Controller\Admin;

use App\Entity\Income;
use App\Repository\CurrencyRepository;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class IncomeCrudController extends AbstractCrudController
{
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;
    private CurrencyRepository $currencyRepository;

    public function __construct(MonthRepository $monthRepository, YearRepository $yearRepository, CurrencyRepository $currencyRepository)
    {
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Income::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];

        $months = $this->getMonthChoicesFromEntity();
        $years = $this->getYearChoicesFromEntity();

        $fields = [];

        // Obtener código de moneda activa desde la base de datos (por ejemplo 'USD')
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        $currencyCode = $currency ? $currency->getCode() : 'USD';

        // Relación con usuario, oculta en formularios y en lista (index)
        $fields[] = AssociationField::new('user', 'Familia')
            ->hideOnForm()
            ->hideOnIndex();

        // Relación con miembro
        $fields[] = AssociationField::new('member', 'Miembro')
            ->setFormTypeOption('row_attr', $rowClass);

        // Campo monto con formato moneda usando el código real (USD, EUR, etc.)
        $fields[] = MoneyField::new('amount', 'Monto')
            ->setCurrency($currencyCode)
            ->setFormTypeOption('row_attr', $rowClass);

        // Fecha
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = \EasyCorp\Bundle\EasyAdminBundle\Field\DateField::new('date', 'Fecha')->setFormat('MMMM yyyy');
        }

        // Campo mes
        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            $fields[] = $monthField;
        }

        // Campo año
        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            $defaultYearId = reset($years);
            $yearField->setFormTypeOption('data', $defaultYearId);
        }

        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            $fields[] = $yearField;
        }

        // Campo estado
        $fields[] = ChoiceField::new('status', 'Estado')
            ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
            ->setFormTypeOption('placeholder', false)
            ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary'])
            ->setFormTypeOption('data', 'Activo')
            ->setFormTypeOption('row_attr', $rowClass);

        return array_filter($fields);
    }

    public function createEntity(string $entityFqcn)
    {
        $income = new Income();
        $income->setStatus('Activo');
        $income->setMonth(1);

        $years = $this->getYearChoicesFromEntity();
        $defaultYearId = reset($years) ?: 2025;
        $income->setYear($defaultYearId);

        $income->setUser($this->getUser());
        return $income;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Income) {
            return;
        }

        if ($entityInstance->getMonth() && $entityInstance->getYear()) {
            $date = \DateTime::createFromFormat('Y-n-j', "{$entityInstance->getYear()}-{$entityInstance->getMonth()}-1");
            $entityInstance->setDate($date);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ingreso')
            ->setEntityLabelInPlural('Ingresos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Ingresos');
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

    private function getMonthChoicesFromEntity(): array
    {
        $monthsEntities = $this->monthRepository->findAll();
        $months = [];
        foreach ($monthsEntities as $month) {
            $months[$month->getName()] = $month->getId();
        }
        return $months;
    }

    private function getYearChoicesFromEntity(): array
    {
        $activeYearEntities = $this->yearRepository->findBy(['status' => 1]);
        $years = [];
        foreach ($activeYearEntities as $year) {
            $years[$year->getYear()] = $year->getId();
        }
        return $years;
    }
}
