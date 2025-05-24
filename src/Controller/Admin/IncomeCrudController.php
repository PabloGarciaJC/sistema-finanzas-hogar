<?php

namespace App\Controller\Admin;

use App\Entity\Income;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
        $months = $this->getMonthChoices();
        $years = $this->getYearChoices();

        return [
            AssociationField::new('member', 'Miembro'),

            MoneyField::new('amount', 'Monto')
                ->setCurrency('EUR'),

            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnIndex(),

            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnDetail(),

            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->setFormTypeOption('data', 1)
                ->onlyOnForms(),

            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->setFormTypeOption('data', 2025)
                ->onlyOnForms(),

            ChoiceField::new('status', 'Estado')
                ->setChoices([
                    'Activo' => 'Activo',
                    'Cancelado' => 'Cancelado',
                ])
                ->setFormTypeOption('placeholder', false)
                ->renderAsBadges([
                    'Activo' => 'success',
                    'Cancelado' => 'secondary',
                ])
                ->setFormTypeOption('data', 'Activo'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $income = new Income();
        $income->setStatus('Activo');
        $income->setMonth(1);
        $income->setYear(2025);

        return $income;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ingreso')
            ->setEntityLabelInPlural('Ingresos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Ingresos');
    }

    // 🔒 Métodos auxiliares privados para mantener organizado
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
