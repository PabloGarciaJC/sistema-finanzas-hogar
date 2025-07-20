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

    public function __construct(MonthRepository $monthRepository, YearRepository $yearRepository, CurrencyRepository $currencyRepository)
    {
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Devuelve la clase de entidad que maneja este CRUD.
     */
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    /**
     * Configura las acciones del CRUD (añade acción para duplicar servicios).
     */
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('Generar mes siguiente', 'Generar mes siguiente')
            ->linkToRoute('admin_services_duplicate')
            ->createAsGlobalAction();

        return $actions->add(Crud::PAGE_INDEX, $duplicate);
    }

    /**
     * Ruta para duplicar los servicios predeterminados del usuario al siguiente mes disponible.
     */
    #[Route("/admin/services/duplicate", name: "admin_services_duplicate")]
    public function duplicateServices(EntityManagerInterface $entityManager): RedirectResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // APLICA LA MISMA VALIDACIÓN AQUÍ
        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true) && $user->getStatus()) {
            $this->addFlash('warning', '
            <div class="custom-flash-message">
                <strong>Acceso Restringido</strong><br>
                Para autorizar el acceso a los módulos de esta red social, contáctame a través de cualquiera de mis redes sociales:<br><br>
                <a href="https://www.facebook.com/PabloGarciaJC" class="custom-link" target="_blank" title="Facebook" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-facebook"></i> Facebook
                </a> |
                <a href="https://www.instagram.com/pablogarciajc" class="custom-link" target="_blank" title="Instagram" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-instagram"></i> Instagram
                </a> |
                <a href="https://www.linkedin.com/in/pablogarciajc" class="custom-link" target="_blank" title="LinkedIn" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a> |
                <a href="https://www.youtube.com/channel/UC5I4oY7BeNwT4gBu1ZKsEhw" class="custom-link" target="_blank" title="YouTube" style="font-size: 15px !important; color: inherit;">
                    <i class="fab fa-youtube"></i> YouTube
                </a>
            </div>
        ');
            return $this->redirectToRoute('admin_service_index');
        }

        // Obtiene servicios predeterminados del usuario actual
        $services = $entityManager->getRepository(Service::class)->findBy([
            'user' => $user,
            'isDefault' => true,
        ]);

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC'], 1);

        if (!$firstInactiveMonth) {
            $this->addFlash('warning', 'No se encontró ningún mes inactivo para asignar.');
            return $this->redirectToRoute('admin_service_index');
        }

        $targetMonthId = $firstInactiveMonth[0]->getId();

        // Verifica si ya existen servicios generados para ese mes y usuario
        $existingServices = $entityManager->getRepository(Service::class)->findBy([
            'user' => $user,
            'month' => $targetMonthId,
            'isDefault' => false,
        ]);

        if (count($existingServices) > 0) {
            $this->addFlash('warning', 'Ya se generaron servicios para este mes');
            return $this->redirectToRoute('admin_service_index');
        }

        // Clona y guarda los servicios para el nuevo mes
        foreach ($services as $service) {
            $newService = clone $service;
            $newService->setUser($user);
            $newService->setMonth($targetMonthId);
            $newService->setIsDefault(false);
            $entityManager->persist($newService);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Los servicios se han duplicado correctamente con el primer mes inactivo.');

        return $this->redirectToRoute('admin_service_index');
    }

    /**
     * Define los campos del formulario y lista para cada página del CRUD.
     */
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
        $isDefaultField = BooleanField::new('is_default', 'Predeterminado')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass);
        $isPaidField = BooleanField::new('is_paid', 'Pagado')->renderAsSwitch(true)->setFormTypeOption('row_attr', $rowClass);

        if ($pageName === Crud::PAGE_NEW) {
            $isDefaultField->setFormTypeOption('data', false);
            $isDefaultField->setFormTypeOption('disabled', true);
            $isPaidField->setFormTypeOption('data', false);
            $isPaidField->setFormTypeOption('disabled', true);
        }

        return [
            AssociationField::new('member', 'Miembro')->setQueryBuilder(function ($qb) use ($user) {
                return $qb->andWhere('entity.user = :user')->setParameter('user', $user);
            })->setFormTypeOption('row_attr', $rowClass),
            $this->createFormattedNumberField('amount', 'Importe', $pageName, 0.00, true, false, $rowClass, $currencySymbol),
            $descriptionField,
            $this->createPaymentDayField($rowClass),
            $this->createMonthChoiceField($pageName, $rowClass),
            $this->createYearChoiceField($pageName, $rowClass),
            $isDefaultField,
            $isPaidField,
            $statusField,
        ];
    }

    /**
     * Crea un campo numérico con formato para el formulario.
     */
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

    /**
     * Crea una nueva instancia de Service con valores predeterminados.
     */
    public function createEntity(string $entityFqcn)
    {
        $service = new Service();
        $service->setStatus(true);
        $service->setUser($this->getUser());

        $firstInactiveMonth = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);

        if (!$firstInactiveMonth) {
            throw new \RuntimeException('Debes crear al menos un mes inactivo con status = 1 antes de crear un servicio.');
        }
        $service->setMonth($firstInactiveMonth[0]->getId());

        $activeYears = $this->yearRepository->findBy(['status' => 1]);
        if ($activeYears) {
            $service->setYear($activeYears[0]->getId());
        }

        $service->setPaymentDay(1);
        $service->setAmount(0.00);
        $service->setIsDefault(false);

        return $service;
    }

    /**
     * Configura títulos, etiquetas y campos de búsqueda del CRUD.
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Servicio')
            ->setEntityLabelInPlural('Servicios')
            ->setPageTitle(Crud::PAGE_INDEX, 'Servicios')
            ->setSearchFields(['description', 'member.name', 'amount']);
    }

    /**
     * Crea el query builder para listar solo servicios del usuario actual.
     */
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

    /**
     * Crea el campo de selección de mes para el formulario.
     */
    private function createMonthChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        $monthEntities = $this->monthRepository->findBy(['status' => 1], ['id' => 'DESC']);

        $months = [];
        foreach ($monthEntities as $month) {
            $months[$month->getName()] = $month->getId();
        }

        $monthField = ChoiceField::new('month', 'Mes')
            ->setChoices($months)
            ->setFormTypeOption('row_attr', $rowClass)
            ->setFormTypeOption('placeholder', 'Seleccione un mes');

        if ($pageName === Crud::PAGE_NEW && count($monthEntities) > 0) {
            $monthField->setFormTypeOption('data', $monthEntities[0]->getId());
        }

        return $monthField;
    }

    /**
     * Crea el campo de selección de año para el formulario.
     */
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

    /**
     * Crea el campo de selección del Día (1-31).
     */
    private function createPaymentDayField(array $rowClass): ChoiceField
    {
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        return ChoiceField::new('paymentDay', 'Día')->setHelp('Día del mes en que se paga (1–31)')->setChoices($days)->setFormTypeOption('row_attr', $rowClass);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Service) {
            return;
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true) && $user->getStatus()) {
            $this->addFlash('warning', '
                <div class="custom-flash-message">
                    <strong>Acceso Restringido</strong><br>
                    Para autorizar el acceso a los módulos de esta red social, contáctame a través de cualquiera de mis redes sociales:<br><br>
                    <a href="https://www.facebook.com/PabloGarciaJC" class="custom-link" target="_blank" title="Facebook" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a> |
                    <a href="https://www.instagram.com/pablogarciajc" class="custom-link" target="_blank" title="Instagram" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-instagram"></i> Instagram
                    </a> |
                    <a href="https://www.linkedin.com/in/pablogarciajc" class="custom-link" target="_blank" title="LinkedIn" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a> |
                    <a href="https://www.youtube.com/channel/UC5I4oY7BeNwT4gBu1ZKsEhw" class="custom-link" target="_blank" title="YouTube" style="font-size: 15px !important; color: inherit;">
                        <i class="fab fa-youtube"></i> YouTube
                    </a>
                </div>
            ');
            return;
        }

        $this->addFlash('success', 'El servicio se ha creado correctamente.');

        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * Valida y actualiza una entidad existente.
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Service) {
            return;
        }

        if (!$this->monthRepository->find($entityInstance->getMonth())) {
            throw new \RuntimeException('Mes inválido');
        }

        if (!$this->yearRepository->find($entityInstance->getYear())) {
            throw new \RuntimeException('Año inválido');
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    /**
     * Obtiene el símbolo de la moneda activa.
     */
    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }
}
