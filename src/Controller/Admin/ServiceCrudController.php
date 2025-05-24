<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
        $descriptionField = $pageName === Crud::PAGE_INDEX ? TextField::new('description', 'Descripción')->formatValue(fn($value) => mb_strimwidth(strip_tags($value), 0, 100, '...')) : TextField::new('description', 'Descripción');

        return [
            AssociationField::new('user', 'Familia'),
            AssociationField::new('member', 'Miembro'),
            MoneyField::new('amount', 'Monto')->setCurrency('EUR'),
            $descriptionField,
            ChoiceField::new('status', 'Estado')->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado',])->setFormTypeOption('placeholder', false)->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary',]),
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
            ->setEntityLabelInSingular('Servicio')
            ->setEntityLabelInPlural('Servicios')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Servicios')
            ->setSearchFields(['description', 'member.name']);
    }
}
