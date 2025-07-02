<?php

namespace App\Controller\Admin;

use App\Entity\CashPayment;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
use App\Repository\CurrencyRepository;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class CashPaymentController extends AbstractCrudController
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
        return CashPayment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        // Campo descripción
        if ($pageName === Crud::PAGE_INDEX) {
            $descriptionField = TextField::new('description', 'Descripción')
                ->formatValue(fn($value) => mb_strimwidth(strip_tags($value), 0, 100, '...'));
        } elseif ($pageName === Crud::PAGE_DETAIL) {
            $descriptionField = TextField::new('description', 'Descripción')
                ->renderAsHtml();
        } else {
            $descriptionField = TextEditorField::new('description', 'Descripción')
                ->setRequired(true)
                ->setFormTypeOption('row_attr', $rowClass);
        }

        return [
            AssociationField::new('member', 'Miembro')
                ->setQueryBuilder(function (QueryBuilder $qb) use ($user) {
                    return $qb->andWhere('entity.user = :user')
                        ->setParameter('user', $user);
                })
                ->setFormTypeOption('row_attr', $rowClass),
            $this->createFormattedNumberField('amount', 'Importe', $pageName, 0.00, true, false, $rowClass, $currencySymbol),
            $descriptionField,
            $this->createPaymentDayField($rowClass),
            $this->createMonthChoiceField($pageName, $rowClass),
            $this->createYearChoiceField($pageName, $rowClass),
            ChoiceField::new('status', 'Estado')
                ->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado'])
                ->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary'])
                ->setFormTypeOption('row_attr', $rowClass),
        ];
    }

    private function createFormattedNumberField(string $name, string $label, string $pageName, ?float $default = null, bool $mapped = true, bool $readonly = false, array $rowClass = [], string $currencySymbol = ''): NumberField
    {
        $inputAttributes = ['class' => 'form-control'];
        if ($readonly) {
            $inputAttributes['readonly'] = true;
        }

        $field = NumberField::new($name, $label)
            ->setNumDecimals(2)
            ->setFormTypeOption('mapped', $mapped)
            ->setFormTypeOption('grouping', true)
            ->setFormTypeOption('attr', $inputAttributes)
            ->setFormTypeOption('label_attr', ['class' => 'form-control-label'])
            ->setFormTypeOption('row_attr', $rowClass)
            ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : '');

        if ($pageName === Crud::PAGE_NEW && $default !== null) {
            $field->setFormTypeOption('data', $default);
        }

        return $field;
    }

    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthsEntities = $this->monthRepository->findAll();
        $months = [];
        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
        }

        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        return $monthField;
    }

    private function createYearChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $activeYearsEntities = $this->yearRepository->findBy(['status' => 1]);

        $years = [];
        foreach ($activeYearsEntities as $yearEntity) {
            $years[$yearEntity->getYear()] = $yearEntity->getId();
        }

        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            $defaultYearId = reset($years);
            $yearField->setFormTypeOption('data', $defaultYearId);
        }

        return $yearField;
    }

    private function createPaymentDayField(array $rowClass): ChoiceField
    {
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        return ChoiceField::new('paymentDay', 'Día de Pago')
            ->setHelp('Día del mes en que se paga (1–31)')
            ->setChoices($days)
            ->setFormTypeOption('row_attr', $rowClass);
    }

    public function createEntity(string $entityFqcn)
    {
        $cashPayment = new CashPayment();
        $cashPayment->setStatus('Activo');
        $cashPayment->setUser($this->getUser());
        $cashPayment->setMonth(1);
        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $cashPayment->setYear($activeYears[0]->getId());
        }
        $cashPayment->setPaymentDay(1);
        $cashPayment->setAmount(0.00);

        return $cashPayment;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Pago al Contado')
            ->setEntityLabelInPlural('Pagos al Contado')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pagos al Contado')
            ->setSearchFields(['description', 'member.name', 'amount']);
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof CashPayment) {
            return;
        }

        $monthId = $entityInstance->getMonth();
        $monthEntity = $this->monthRepository->find($monthId);
        if (!$monthEntity) {
            throw new \RuntimeException('Mes inválido');
        }

        $yearId = $entityInstance->getYear();
        $yearEntity = $this->yearRepository->find($yearId);
        if (!$yearEntity) {
            throw new \RuntimeException('Año inválido');
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof CashPayment) {
            return;
        }

        $monthId = $entityInstance->getMonth();
        $monthEntity = $this->monthRepository->find($monthId);
        if (!$monthEntity) {
            throw new \RuntimeException('Mes inválido');
        }

        $yearId = $entityInstance->getYear();
        $yearEntity = $this->yearRepository->find($yearId);
        if (!$yearEntity) {
            throw new \RuntimeException('Año inválido');
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }
}
