<?php

namespace App\Controller\Admin;

use App\Entity\MonthlySummary;
use App\Repository\IncomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\CreditRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class MonthlySummaryCrudController extends AbstractCrudController
{
    private IncomeRepository $incomeRepository;
    private ServiceRepository $serviceRepository;
    private CreditRepository $creditRepository;

    public function __construct(IncomeRepository $incomeRepository, ServiceRepository $serviceRepository, CreditRepository $creditRepository,)
    {
        $this->incomeRepository = $incomeRepository;
        $this->serviceRepository = $serviceRepository;
        $this->creditRepository = $creditRepository;
    }

    public static function getEntityFqcn(): string
    {
        return MonthlySummary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Obtener valores predeterminados
        $defaultIncomeValue = $this->getDefaultValue($this->incomeRepository->getIncomeOptions());
        $defaultServiceValue = $this->getDefaultValue($this->serviceRepository->getTotalServiceSql());
        $defaultCreditMemberOne = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberOne());
        $defaultCreditMemberTwo = $this->getDefaultValue($this->creditRepository->getCreditTotalMemberTwo());

        // Calcular saldo restante
         $defaultRemainingBalance = $defaultIncomeValue - $defaultServiceValue - $defaultCreditMemberOne - $defaultCreditMemberTwo;

        // Calcular Deuda Total
        $defaultBankDebtTotal = $defaultServiceValue + $defaultCreditMemberOne + $defaultCreditMemberTwo;

        // Calcular importes por miembro
        $defaultBankDebtMemberOne = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberOne(), $defaultCreditMemberOne);
        $defaultBankDebtMemberTwo = $this->calculateTotalMemberDebt($this->serviceRepository->getTotalMemberTwo(), $defaultCreditMemberTwo);

        // Campos
        $fields = [];

        $fields[] = $this->createNumberField('totalIncome', 'Ingresos Totales', $pageName, $defaultIncomeValue);
        $fields[] = $this->createNumberField('debt_total', 'Deuda Total', $pageName, $defaultBankDebtTotal);
        $fields[] = $this->createNumberField('remainingBalance', 'Saldo Restante', $pageName, $defaultRemainingBalance, false, true);
        $fields[] = $this->createNumberField('bankDebtMemberOne', 'Importe Banco Pablo', $pageName, $defaultBankDebtMemberOne);
        $fields[] = $this->createNumberField('bankDebtMemberTwo', 'Importe Banco Vero', $pageName, $defaultBankDebtMemberTwo);

        // Campo Mes
        $months = array_combine(
            ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            range(1, 12)
        );
        $monthField = ChoiceField::new('month', 'Mes')->setChoices($months);
        if ($pageName === Crud::PAGE_NEW) {
            $monthField->setFormTypeOption('data', 1);
        }
        $fields[] = $monthField;

        // Campo Año
        $currentYear = (int) date('Y');
        $years = array_combine(range($currentYear - 10, $currentYear + 10), range($currentYear - 10, $currentYear + 10));
        $yearField = ChoiceField::new('year', 'Año')->setChoices($years);
        if ($pageName === Crud::PAGE_NEW) {
            $yearField->setFormTypeOption('data', $currentYear);
        }
        $fields[] = $yearField;

        return $fields;
    }

    /**
     * Extrae el primer valor de un arreglo y lo divide entre 100 si es numérico.
     */
    private function getDefaultValue($data): ?float
    {
        return $data ? reset($data) / 100 : null;
    }

    /**
     * Calcula la deuda total del miembro sumando servicio y crédito.
     */
    private function calculateTotalMemberDebt($serviceData, $creditValue): ?float
    {
        $serviceValue = $this->getDefaultValue($serviceData);
        return ($serviceValue !== null && $creditValue !== null) ? $serviceValue + $creditValue : null;
    }

    /**
     * Crea un campo numérico reutilizable.
     */
    private function createNumberField(string $name, string $label, string $pageName, ?float $default = null, bool $mapped = true, bool $disabled = false)
    {
        $field = NumberField::new($name, $label)
            ->setNumDecimals(2)
            ->setFormTypeOption('mapped', $mapped)
            ->setDisabled($disabled);

        if ($pageName === Crud::PAGE_NEW && $default !== null) {
            $field->setFormTypeOption('data', $default);
        }

        return $field;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resumen Mensual')
            ->setEntityLabelInPlural('Resumen Mensuales')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Resumen Mensual')
            ->setSearchFields([
                'month',
                'year',
                'totalIncome',
                'remainingBalance',
                'bankDebtMemberOne',
                'bankDebtMemberTwo',
            ]);
    }
}
