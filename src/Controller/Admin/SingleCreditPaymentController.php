<?php

namespace App\Controller\Admin;

use App\Entity\SingleCreditPayment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class SingleCreditPaymentController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return SingleCreditPayment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $descriptionField = $pageName === Crud::PAGE_INDEX
            ? TextField::new('description', 'Descripción')->formatValue(fn($value) => mb_strimwidth(strip_tags($value), 0, 100, '...'))
            : TextField::new('description', 'Descripción');

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),
            AssociationField::new('member', 'Miembro'),
            MoneyField::new('amount', 'Monto')->setCurrency('EUR'),
            $descriptionField,
            ChoiceField::new('status', 'Estado')
                ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
                ->setFormTypeOption('placeholder', false)
                ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary']),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $payment = new SingleCreditPayment();
        $payment->setStatus('Activo');
        $payment->setUser($this->getUser());
        return $payment;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Crédito al Contado')
            ->setEntityLabelInPlural('Créditos al Contado')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Créditos al Contado')
            ->setSearchFields(['description', 'member.name']);
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
