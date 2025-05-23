<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ServiceCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('member', 'Miembro'),
            MoneyField::new('amount', 'Monto')->setCurrency('EUR'),
            $pageName === Crud::PAGE_INDEX
                ? TextField::new('description', 'Descripción')
                    ->formatValue(function ($value, $entity) {
                        return mb_strimwidth(strip_tags($value), 0, 100, '...');
                    })
                : TextField::new('description', 'Descripción'),
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
        $service = new Service();
        $service->setStatus('Activo');
        return $service;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Servicios')
            ->setEntityLabelInPlural('Servicios')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Servicios')
            ->setSearchFields(['description', 'member.name']);
    }
}
