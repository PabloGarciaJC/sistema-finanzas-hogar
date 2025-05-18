<?php

namespace App\Controller\Admin;

use App\Entity\Income;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

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
        $months = [
            'Enero' => 1, 'Febrero' => 2, 'Marzo' => 3, 'Abril' => 4,
            'Mayo' => 5, 'Junio' => 6, 'Julio' => 7, 'Agosto' => 8,
            'Septiembre' => 9, 'Octubre' => 10, 'Noviembre' => 11, 'Diciembre' => 12,
        ];

        $currentYear = (int) date('Y');
        $years = [];
        for ($i = $currentYear - 10; $i <= $currentYear + 10; $i++) {
            $years[$i] = $i;
        }

        return [
            AssociationField::new('member', 'Miembro'),
            MoneyField::new('amount', 'Monto')->setCurrency('EUR'),

            // Mostrar fecha solo en listado y detalle, en formato "Mes Año"
            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnIndex(),

            DateField::new('date', 'Fecha')
                ->setFormat('MMMM yyyy')
                ->onlyOnDetail(),

            // Campos virtuales para mes y año, solo en formularios
            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->onlyOnForms(),

            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->onlyOnForms(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return new Income();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ingreso')
            ->setEntityLabelInPlural('Ingresos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Ingresos');
    }
}
