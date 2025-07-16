<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoalController extends AbstractCrudController
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
        return Goal::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('Generar mes siguiente', 'Generar mes siguiente')
            ->linkToRoute('admin_goals_duplicate')
            ->createAsGlobalAction();

        return $actions->add(Crud::PAGE_INDEX, $duplicate);
    }

    /**
     * Ruta para duplicar los servicios predeterminados del usuario al siguiente mes disponible.
     */
    #[Route("/admin/goals/duplicate", name: "admin_goals_duplicate")]
    public function duplicateGoals(EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();

        // Obtiene objetivos predeterminados del usuario actual
        $goals = $entityManager->getRepository(Goal::class)->findBy([
            'user' => $user,
            'isDefault' => true,
        ]);

        // Busca el primer mes inactivo
        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC'], 1);

        if (!$firstInactiveMonth) {
            $this->addFlash('warning', 'No se encontró ningún mes inactivo para asignar.');
            return $this->redirectToRoute('admin_goal_index');
        }

        $targetMonthId = $firstInactiveMonth[0]->getId();

        // Verifica si ya existen objetivos generados para ese mes y usuario
        $existingGoals = $entityManager->getRepository(Goal::class)->findBy([
            'user' => $user,
            'month' => $targetMonthId,
            'isDefault' => false,
        ]);

        if (count($existingGoals) > 0) {
            $this->addFlash('warning', 'Ya se generaron objetivos para este mes.');
            return $this->redirectToRoute('admin_goal_index');
        }

        // Clona y guarda los objetivos para el nuevo mes
        foreach ($goals as $goal) {
            $newGoal = clone $goal;
            $newGoal->setUser($user);
            $newGoal->setMonth($targetMonthId);
            $newGoal->setIsDefault(false);
            $entityManager->persist($newGoal);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Los objetivos se han duplicado correctamente con el primer mes inactivo.');

        return $this->redirectToRoute('admin_goal_index');
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

        if ($pageName === Crud::PAGE_INDEX) {
            $descriptionField = TextField::new('description', 'Descripción')->formatValue(fn($value) => mb_strimwidth(strip_tags($value), 0, 100, '...'));
        } elseif ($pageName === Crud::PAGE_DETAIL) {
            $descriptionField = TextField::new('description', 'Descripción')->renderAsHtml();
        } else {
            $descriptionField = TextEditorField::new('description', 'Descripción')->setRequired(true)->setFormTypeOption('row_attr', $rowClass);
        }

        $statusField = BooleanField::new('status', 'Activo')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass);
        $isDefaultField = BooleanField::new('isDefault', 'Predeterminado')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass);
        $isPaidField = BooleanField::new('is_paid', 'Pagado')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $isDefaultField->setFormTypeOption('data', false);
            $isDefaultField->setFormTypeOption('disabled', true);
            $isPaidField->setFormTypeOption('data', false);
            $isPaidField->setFormTypeOption('disabled', true);
        }

        return [
            AssociationField::new('member', 'Miembro')
                ->setQueryBuilder(function ($qb) use ($user) {
                    return $qb->andWhere('entity.user = :user')->setParameter('user', $user);
                })
                ->setFormTypeOption('required', true)
                ->setFormTypeOption('row_attr', $rowClass),

            $this->createFormattedNumberField('amount', 'Cantidad', $pageName, 0.00, true, false, $rowClass, $currencySymbol),
            $descriptionField,
            $this->createPaymentDayField($rowClass),
            $this->createMonthChoiceField($pageName, $rowClass),
            $this->createYearChoiceField($pageName, $rowClass),
            $isDefaultField,
            $isPaidField,
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
        $goal = new Goal();
        $goal->setStatus(true);
        $goal->setUser($this->getUser());

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);

        if (!$firstInactiveMonth) {
            throw new \RuntimeException('Debes crear al menos un mes inactivo con status = 1 antes de crear un objetivo.');
        }
        $goal->setMonth($firstInactiveMonth[0]->getId());

        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $goal->setYear($activeYears[0]->getId());
        }

        $goal->setPaymentDay(1);
        $goal->setAmount(0.00);
        $goal->setIsDefault(false);

        return $goal;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Objetivo')
            ->setEntityLabelInPlural('Objetivos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Objetivos')
            ->setSearchFields(['description', 'member.name', 'amount']);
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

    private function createPaymentDayField(array $rowClass): ChoiceField
    {
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        return ChoiceField::new('paymentDay', 'Día')->setHelp('Día del mes (1–31)')->setChoices($days)->setFormTypeOption('row_attr', $rowClass);
    }

    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }
}
