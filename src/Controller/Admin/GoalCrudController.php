<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GoalCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Goal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $months = [
            'Enero' => 1,
            'Febrero' => 2,
            'Marzo' => 3,
            'Abril' => 4,
            'Mayo' => 5,
            'Junio' => 6,
            'Julio' => 7,
            'Agosto' => 8,
            'Septiembre' => 9,
            'Octubre' => 10,
            'Noviembre' => 11,
            'Diciembre' => 12,
        ];

        $currentYear = (int) date('Y');
        $years = [];
        for ($i = $currentYear - 10; $i <= $currentYear + 10; $i++) {
            $years[$i] = $i;
        }

        $descriptionField = TextEditorField::new('description', 'Descripción');

        if ($pageName === Crud::PAGE_INDEX) {
            // Mostrar texto sin etiquetas HTML en la lista
            $descriptionField = TextField::new('description', 'Descripción')
                ->formatValue(fn($value) => strip_tags($value));
        }

        return [
            AssociationField::new('member', 'Miembro')->setRequired(true),
            $descriptionField,
            MoneyField::new('targetAmount', 'Importe')->setCurrency('EUR'),
            ChoiceField::new('frequency', 'Frecuencia')
                ->setChoices([
                    'Mensual' => 'Mensual',
                    'Trimestral' => 'Trimestral',
                    'Semestral' => 'Semestral',
                    'Anual' => 'Anual',
                ]),
            DateField::new('startDate', 'Fecha de inicio')
                ->onlyOnDetail()
                ->setFormat('MMMM yyyy'),
            // En formulario, usar mes y año por separado
            ChoiceField::new('month', 'Mes')
                ->setChoices($months)
                ->onlyOnForms(),
            ChoiceField::new('year', 'Año')
                ->setChoices($years)
                ->onlyOnForms(),
            // Mostrar startDate solo en índice y detalle
            DateField::new('startDate', 'Fecha de inicio')
                ->onlyOnIndex()
                ->setFormat('MMMM yyyy'),
            ChoiceField::new('status', 'Estado')
                ->setChoices([
                    'En progreso' => 'In progress',
                    'Completado' => 'Completed',
                    'Cancelado' => 'Canceled',
                ])
                ->renderAsBadges([
                    'In progress' => 'warning',
                    'Completed' => 'success',
                    'Canceled' => 'secondary',
                ]),

        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Goal) {
            return;
        }

        $month = $entityInstance->getMonth();
        $year = $entityInstance->getYear();

        if ($month && $year) {
            $startDate = \DateTime::createFromFormat('Y-n-j', "$year-$month-1");
            $entityInstance->setStartDate($startDate);
        }

        if ($entityInstance->getMember() === null) {
            $user = $this->security->getUser();
            $member = $entityManager->getRepository(Member::class)->findOneBy(['user' => $user]);

            if ($member) {
                $entityInstance->setMember($member);
            } else {
                throw new \Exception('No se encontró un miembro asociado al usuario actual.');
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Meta')
            ->setEntityLabelInPlural('Metas')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Metas')
            ->setSearchFields(['member.name', 'description', 'status']);
    }
}
