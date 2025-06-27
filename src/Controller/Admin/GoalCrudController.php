<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Repository\CurrencyRepository;
use App\Repository\YearRepository;
use App\Repository\MonthRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Bundle\SecurityBundle\Security;

class GoalCrudController extends AbstractCrudController
{
    private Security $security;
    private CurrencyRepository $currencyRepository;
    private YearRepository $yearRepository;
    private MonthRepository $monthRepository;
    private EntityManagerInterface $em;

    public function __construct(
        Security $security,
        CurrencyRepository $currencyRepository,
        YearRepository $yearRepository,
        MonthRepository $monthRepository,
        EntityManagerInterface $em
    ) {
        $this->security = $security;
        $this->currencyRepository = $currencyRepository;
        $this->yearRepository = $yearRepository;
        $this->monthRepository = $monthRepository;
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Goal::class;
    }

    // Aquí el método para asignar el usuario al crear la entidad
    public function createEntity(string $entityFqcn)
    {
        $goal = new Goal();
        $goal->setUser($this->security->getUser()); // asigna usuario actual
        return $goal;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Meta')
            ->setEntityLabelInPlural('Metas')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Metas')
            ->setSearchFields(['member.name', 'description', 'status']);
    }

    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        $descriptionField = $pageName === Crud::PAGE_INDEX
            ? TextField::new('description', 'Descripción')->formatValue(fn ($value) => strip_tags($value))
            : TextEditorField::new('description', 'Descripción');

        $fields = [
            AssociationField::new('user', 'Familia')->hideOnForm(),

            AssociationField::new('member', 'Miembro')
                ->setRequired(true)
                ->setFormTypeOption('row_attr', $rowClass),

            $descriptionField->setFormTypeOption('row_attr', $rowClass),

            NumberField::new('targetAmount', 'Importe')
                ->setFormTypeOption('row_attr', $rowClass)
                ->formatValue(fn ($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : ''),

            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Mensual' => 'Mensual',
                    'Trimestral' => 'Trimestral',
                    'Semestral' => 'Semestral',
                    'Anual' => 'Anual',
                ])
                ->setFormTypeOption('placeholder', false)
                ->setFormTypeOption('data', 'Mensual')
                ->setFormTypeOption('row_attr', $rowClass),

            $this->createMonthChoiceField($pageName, $rowClass),

            $this->createYearChoiceField($pageName, $rowClass),

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
                ->setFormTypeOption('row_attr', $rowClass),
        ];

        return $fields;
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
            $yearField->setFormTypeOption('data', reset($years));
        }

        return $yearField;
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
