<?php

namespace App\Controller\Admin;

use App\Entity\Income;
use App\Repository\MonthRepository;
use App\Repository\YearRepository;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IncomeController extends AbstractCrudController
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

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('Generar mes siguiente', 'Generar mes siguiente')
            ->linkToRoute('admin_income_duplicate')
            ->createAsGlobalAction();

        return $actions->add(Crud::PAGE_INDEX, $duplicate);
    }

    #[Route("/admin/incomes/duplicate", name: "admin_income_duplicate")]
    public function duplicateIncomes(EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();

        $incomes = $entityManager->getRepository(Income::class)->findBy([
            'user' => $user,
            'isDefault' => true,
        ]);

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC'], 1);

        if (!$firstInactiveMonth) {
            $this->addFlash('warning', 'No se encontró ningún mes inactivo para asignar.');
            return $this->redirectToRoute('admin_income_index');
        }

        foreach ($incomes as $income) {
            $newIncome = clone $income;
            $newIncome->setUser($user);
            $newIncome->setMonth($firstInactiveMonth[0]->getId());
            $newIncome->setIsDefault(false);
            $entityManager->persist($newIncome);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Los ingresos se han duplicado correctamente con el primer mes inactivo.');

        return $this->redirectToRoute('admin_income_index');
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        $isDefaultField = BooleanField::new('isDefault', 'Predeterminado')
            ->renderAsSwitch(true)
            ->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $isDefaultField->setFormTypeOption('data', false);
            $isDefaultField->setFormTypeOption('disabled', true);
        }

        $statusField = BooleanField::new('status', 'Activo')
            ->renderAsSwitch(true)
            ->setFormTypeOption('row_attr', $rowClass);

        return [
            AssociationField::new('member', 'Miembro')
                ->setQueryBuilder(function ($qb) use ($user) {
                    return $qb->andWhere('entity.user = :user')->setParameter('user', $user);
                })
                ->setFormTypeOption('required', true)
                ->setFormTypeOption('row_attr', $rowClass),

            $this->createFormattedNumberField('amount', 'Monto', $pageName, 0.00, true, false, $rowClass, $currencySymbol),

            $this->createMonthChoiceField($pageName, $rowClass),
            $this->createYearChoiceField($pageName, $rowClass),

            $isDefaultField,
            $statusField,
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

    public function createEntity(string $entityFqcn)
    {
        $income = new Income();
        $income->setStatus(true);
        $income->setUser($this->getUser());

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);

        if (!$firstInactiveMonth) {
            throw new \RuntimeException('Debes crear al menos un mes inactivo con status = 1 antes de crear un ingreso.');
        }
        $income->setMonth($firstInactiveMonth[0]->getId());

        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $income->setYear($activeYears[0]->getId());
        }

        $income->setAmount(0.00);
        $income->setIsDefault(false);

        return $income;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ingreso')
            ->setEntityLabelInPlural('Ingresos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Ingresos')
            ->setSearchFields(['member.name', 'amount', 'month', 'year', 'status']);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $user = $this->getUser();
        if ($user) {
            $qb->andWhere('entity.user = :currentUser')->setParameter('currentUser', $user);
        }

        $qb->orderBy('entity.id', 'DESC');

        return $qb;
    }

    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthsEntities = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);
        $months = [];
        $firstMonthId = null;

        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
            if ($firstMonthId === null) {
                $firstMonthId = $monthEntity->getId();
            }
        }

        $monthField = ChoiceField::new('month', 'Mes')->setChoices($months)->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && $firstMonthId !== null) {
            $monthField->setFormTypeOption('data', $firstMonthId);
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

        $yearField = ChoiceField::new('year', 'Año')->setChoices($years)->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            $yearField->setFormTypeOption('data', reset($years));
        }

        return $yearField;
    }

    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }
}
