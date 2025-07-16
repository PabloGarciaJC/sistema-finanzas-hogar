<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use App\Repository\CurrencyRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CreditController extends AbstractCrudController
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Credit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        return [
            AssociationField::new('member', 'Miembro')
                ->setQueryBuilder(function (QueryBuilder $qb) use ($user) {
                    return $qb->andWhere('entity.user = :user')
                        ->setParameter('user', $user);
                })
                ->setFormTypeOption('row_attr', $rowClass),

            TextField::new('bankEntity', 'Banco')
                ->setFormTypeOption('row_attr', $rowClass),

            NumberField::new('installmentAmount', 'Importe por cuota')
                ->setFormTypeOption('row_attr', $rowClass)
                ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : ''),


            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Mensual' => 'Mensual',
                    'Bimestral' => 'Bimestral',
                    'Trimestral' => 'Trimestral',
                    'Anual' => 'Anual',
                ])
                ->setFormTypeOption('placeholder', false)
                ->setFormTypeOption('row_attr', $rowClass),

            NumberField::new('totalAmount', 'Importe total')
                ->setFormTypeOption('row_attr', $rowClass)
                ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : ''),

            BooleanField::new('is_paid', 'Pagado')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass),

            BooleanField::new('status', 'Activo')
                ->renderAsSwitch(true)
                ->setFormTypeOption('row_attr', $rowClass),
        ];
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
            ->setSearchFields(['member.name', 'bankEntity', 'status'])
            ->setDefaultSort(['id' => 'DESC']);
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
        return $currency ? $currency->getSymbol() : '';
    }
}
