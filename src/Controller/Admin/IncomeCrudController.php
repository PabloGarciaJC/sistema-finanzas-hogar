<?php

namespace App\Controller\Admin;

use App\Entity\Income;
use App\Entity\Member;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class IncomeCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Income::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $months = $this->getMonthChoices();
        $years = $this->getYearChoices();

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),

            AssociationField::new('member', 'Miembro')
                ->setFormTypeOption('row_attr', $rowClass),

            MoneyField::new('amount', 'Monto')
                ->setCurrency('EUR')
                ->setFormTypeOption('row_attr', $rowClass),

            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnIndex(),

            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnDetail(),

            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->setFormTypeOption('data', 1)
                ->setFormTypeOption('row_attr', $rowClass)
                ->onlyOnForms(),

            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->setFormTypeOption('data', 2025)
                ->setFormTypeOption('row_attr', $rowClass)
                ->onlyOnForms(),

            ChoiceField::new('status', 'Estado')
                ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
                ->setFormTypeOption('placeholder', false)
                ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary'])
                ->setFormTypeOption('data', 'Activo')
                ->setFormTypeOption('row_attr', $rowClass),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $income = new Income();
        $income->setStatus('Activo');
        $income->setMonth(1);
        $income->setYear(2025);
        $income->setUser($this->getUser());
        return $income;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Income) {
            return;
        }

        // Calcular fecha combinando mes y año
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
