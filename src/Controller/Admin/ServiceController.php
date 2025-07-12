<?php

namespace App\Controller\Admin;

use App\Entity\Service;
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

class ServiceController extends AbstractCrudController
{
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;
    private CurrencyRepository $currencyRepository;

    public function __construct(
        MonthRepository $monthRepository,
        YearRepository $yearRepository,
        CurrencyRepository $currencyRepository
    ) {
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('Generar mes siguiente', 'Generar mes siguiente')
            ->linkToRoute('admin_services_duplicate')
            ->createAsGlobalAction();

        return $actions->add(Crud::PAGE_INDEX, $duplicate);
    }

    /**
     * @Route("/admin/services/duplicate", name="admin_services_duplicate")
     */
    public function duplicateServices(EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();
        $services = $entityManager->getRepository(Service::class)->findBy(['user' => $user]);

        // 👉 Buscar primer mes inactivo (status = 0)
        $firstInactiveMonth = $this->monthRepository->findOneBy(['status' => 0], ['id' => 'ASC']);
        if (!$firstInactiveMonth) {
            $this->addFlash('warning', 'No se encontró ningún mes inactivo para asignar.');
            return $this->redirectToRoute('admin_service_index');
        }

        foreach ($services as $service) {
            $newService = clone $service;
            $newService->setUser($user);
            $newService->setMonth($firstInactiveMonth->getId()); // 👈 Asigna el mes inactivo
            $entityManager->persist($newService);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Los servicios se han duplicado correctamente con el primer mes inactivo.');

        return $this->redirectToRoute('admin_service_index');
    }


    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();

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
                ->setQueryBuilder(function ($qb) use ($user) {
                    return $qb
                        ->andWhere('entity.user = :user')
                        ->setParameter('user', $user);
                })
                ->setFormTypeOption('row_attr', $rowClass),

            $this->createFormattedNumberField('amount', 'Importe', $pageName, 0.00, true, false, $rowClass, $currencySymbol),
            $descriptionField,
            $this->createPaymentDayField($rowClass),
            $this->createMonthChoiceField($pageName, $rowClass),
            $this->createYearChoiceField($pageName, $rowClass),
            BooleanField::new('status', 'Activo')
                ->renderAsSwitch(true)
                ->setFormTypeOption('row_attr', $rowClass),
        ];
    }

    private function createFormattedNumberField(
        string $name,
        string $label,
        string $pageName,
        ?float $default = null,
        bool $mapped = true,
        bool $readonly = false,
        array $rowClass = [],
        string $currencySymbol = ''
    ): NumberField {
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
        $service = new Service();
        $service->setStatus(true);
        $service->setUser($this->getUser());
        $service->setMonth(1);
        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $service->setYear($activeYears[0]->getId());
        }
        $service->setPaymentDay(1);
        $service->setAmount(0.00);

        return $service;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Servicio')
            ->setEntityLabelInPlural('Servicios')
            ->setPageTitle(Crud::PAGE_INDEX, 'Servicios')
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

        // 👇 Fuerza a ordenar por ID descendente
        $qb->orderBy('entity.id', 'DESC');

        return $qb;
    }

    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        // Obtener meses con status = 0 ordenados por ID ascendente
        $monthsEntities = $this->monthRepository->findBy(['status' => 0], ['id' => 'ASC']);

        $months = [];
        $firstMonthId = null;

        foreach ($monthsEntities as $monthEntity) {
            $months[$monthEntity->getName()] = $monthEntity->getId();
            // Guardar el primer mes con status 0
            if ($firstMonthId === null) {
                $firstMonthId = $monthEntity->getId();
            }
        }

        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass);

        // Seleccionar el primer mes con status 0 por defecto en nuevo formulario
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Service) {
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
        if (!$entityInstance instanceof Service) {
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
