<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\CreditRepository;
use App\Repository\GoalRepository;
use App\Repository\CurrencyRepository;
use App\Repository\MonthRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Repository\YearRepository;

class MonthlySummaryCrudController extends AbstractCrudController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;
    private CreditRepository $creditRepository;
    private GoalRepository $goalRepository;
    private CurrencyRepository $currencyRepository;
    private MonthRepository $monthRepository;
    private YearRepository $yearRepository;


    public function __construct(IncomeRepository $incomeRepository, ServiceRepository $serviceRepository, CreditRepository $creditRepository, GoalRepository $goalRepository, CurrencyRepository $currencyRepository, MonthRepository $monthRepository,  YearRepository $yearRepository)
    {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
        $this->creditRepository = $creditRepository;
        $this->goalRepository = $goalRepository;
        $this->currencyRepository = $currencyRepository;
        $this->monthRepository = $monthRepository;
        $this->yearRepository = $yearRepository;
    }


    /**
     * Devuelve la clase de la entidad administrada.
     */
    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    /**
     * Configura los campos visibles en los formularios y listados.
     */
    public function configureFields(string $pageName): iterable
    {
        $rowClass = ['class' => 'col-md-10 cntn-inputs'];
        $currencySymbol = $this->getActiveCurrencySymbol();
        $defaults = $this->calculateDefaultValues();
        $fields = [];

        // Campo relación usuario, oculto en formulario
        $fields[] = AssociationField::new('user', 'Familia')->hideOnForm();

        // Campos numéricos con formato moneda
        $fields[] = $this->createFormattedNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaults['income'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('debt_total', 'Deuda Total', $pageName, $defaults['bankDebtTotal'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('remainingBalance', 'Saldo Restante', $pageName, $defaults['remainingBalance'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('bankDebtMemberOne', 'Importe Banco Pablo', $pageName, $defaults['bankDebtMemberOne'], $currencySymbol, $rowClass);
        $fields[] = $this->createFormattedNumberField('bankDebtMemberTwo', 'Importe Banco Vero', $pageName, $defaults['bankDebtMemberTwo'], $currencySymbol, $rowClass);

        // Campos de selección para mes y año
        $fields[] = $this->createMonthChoiceField($pageName, $rowClass);
        $fields[] = $this->createYearChoiceField($pageName, $rowClass);

        return $fields;
    }

    /**
     * Calcula valores por defecto a mostrar en los campos numéricos,
     * sumando y restando datos de distintos repositorios.
     */
    private function calculateDefaultValues(): array
    {
        $income = $this->getDefaultValue($this->incomeRepository->getIncomeOptions());
        $service = $this->getDefaultValue($this->serviceRepository->getTotalServiceSql());
        $creditMemberOne = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberOne());
        $creditMemberTwo = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberTwo());
        $goalTotal = $this->getDefaultValue($this->goalRepository->getGoalTotal());

        $remainingBalance = $income - $service - $creditMemberOne - $creditMemberTwo - $goalTotal;
        $bankDebtTotal = $service + $creditMemberOne + $creditMemberTwo + $goalTotal;
        $bankDebtMemberOne = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberOne(), $creditMemberOne);
        $bankDebtMemberTwo = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberTwo(), $creditMemberTwo);

        return [
            'income' => $income,
            'service' => $service,
            'creditMemberOne' => $creditMemberOne,
            'creditMemberTwo' => $creditMemberTwo,
            'goalTotal' => $goalTotal,
            'remainingBalance' => $remainingBalance,
            'bankDebtTotal' => $bankDebtTotal,
            'bankDebtMemberOne' => $bankDebtMemberOne,
            'bankDebtMemberTwo' => $bankDebtMemberTwo,
        ];
    }

    /**
     * Crea un campo NumberField con formato para mostrar moneda,
     * incluyendo símbolo y formato de número.
     */
    private function createFormattedNumberField(string $name, string $label, string $pageName, ?float $default, string $currencySymbol, array $rowClass): NumberField
    {
        return $this->createNumberField($name, $label, $pageName, $default, true, true, $rowClass)
            ->formatValue(fn($value) => $value !== null ? number_format((float)$value, 2, ',', '.') . ' ' . $currencySymbol : '');
    }

    /**
     * Genera el campo ChoiceField para seleccionar mes, con opciones
     * provenientes de la base de datos.
     */
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

        // Valor por defecto en formulario de creación
        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }

        return $monthField;
    }

    /**
     * Crea un campo de selección (ChoiceField) para el año,
     * mostrando únicamente los años que tienen `status = 1` (años activos).
     */
    private function createYearChoiceField(string $pageName, array $rowClass): ChoiceField
    {
        // Traemos sólo los años con status = 1
        $activeYearsEntities = $this->yearRepository->findBy(['status' => 1]);

        $years = [];
        foreach ($activeYearsEntities as $yearEntity) {
            $years[$yearEntity->getYear()] = $yearEntity->getId();
        }

        $yearField = ChoiceField::new('year', 'Año')
            ->setChoices($years)
            ->setFormTypeOption('row_attr', $rowClass);

        // Valor por defecto en formulario de creación, si hay uno
        if ($pageName === Crud::PAGE_NEW && count($years) > 0) {
            // Selecciona el primer año activo como valor por defecto
            $defaultYearId = reset($years);
            $yearField->setFormTypeOption('data', $defaultYearId);
        }

        return $yearField;
    }

    /**
     * Crea una nueva instancia de MonthlySummary y asigna el usuario actual.
     */
    public function createEntity(string $entityFqcn)
    {
        $entity = new MonthlySummary();
        $entity->setUser($this->getUser());
        return $entity;
    }

    /**
     * Configura etiquetas y título para la interfaz CRUD.
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resumen Mensual')
            ->setEntityLabelInPlural('Resumen Mensuales')
            ->setPageTitle(Crud::PAGE_INDEX, 'Resumen Mensual')
            ->setSearchFields([
                'month',
                'year',
                'totalIncome',
                'remainingBalance',
                'bankDebtMemberOne',
                'bankDebtMemberTwo',
            ]);
    }

    /**
     * Modifica la query para que solo muestre los registros del usuario actual.
     */
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

    /**
     * Convierte un valor numérico recibido en centavos a formato float en moneda.
     */
    private function getDefaultValue($data): ?float
    {
        return $data ? reset($data) / 100 : null;
    }

    /**
     * Calcula la deuda total de un miembro sumando servicios y créditos.
     */
    private function calculateTotalMemberDebt($serviceData, $creditValue): ?float
    {
        $serviceValue = $this->getDefaultValue($serviceData);
        return ($serviceValue !== null && $creditValue !== null) ? $serviceValue + $creditValue : null;
    }

    /**
     * Crea un campo NumberField configurado con opciones comunes,
     * como número de decimales, atributos y modo solo lectura.
     */
    private function createNumberField(string $name, string $label, string $pageName, ?float $default = null, bool $mapped = true, bool $readonly = false, array $rowClass = []): NumberField
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
            ->setFormTypeOption('row_attr', $rowClass);

        // Asignar valor por defecto solo al crear un nuevo registro
        if ($pageName === Crud::PAGE_NEW && $default !== null) {
            $field->setFormTypeOption('data', $default);
        }

        return $field;
    }

    /**
     * Obtiene el símbolo de la moneda activa en la configuración.
     */
    private function getActiveCurrencySymbol(): string
    {
        $currency = $this->currencyRepository->findOneBy(['status' => 1]);
        return $currency ? $currency->getSymbol() : '';
    }
}
