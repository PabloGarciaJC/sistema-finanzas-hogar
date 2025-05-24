<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
        $months = $this->getMonthChoices();
        $years = $this->getYearChoices();
        $descriptionField = $pageName === Crud::PAGE_INDEX ? TextField::new('description', 'Descripción')->formatValue(fn($value) => strip_tags($value)) : TextEditorField::new('description', 'Descripción');

        return [
            AssociationField::new('user', 'Familia')->hideOnForm(),
            AssociationField::new('member', 'Miembro')->setRequired(true),
            $descriptionField,
            MoneyField::new('targetAmount', 'Importe')->setCurrency('EUR'),
            ChoiceField::new('frequency', 'Frecuencia')->setChoices(['Mensual' => 'Mensual', 'Trimestral' => 'Trimestral', 'Semestral' => 'Semestral', 'Anual' => 'Anual',])->setFormTypeOption('placeholder', false)->setFormTypeOption('data', 'Mensual'),
            ChoiceField::new('month', 'Mes')->setChoices($months)->onlyOnForms(),
            ChoiceField::new('year', 'Año')->setChoices($years)->onlyOnForms(),
            DateField::new('startDate', 'Fecha de inicio')->setFormat('MMMM yyyy')->onlyOnIndex(),
            DateField::new('startDate', 'Fecha de inicio')->setFormat('MMMM yyyy')->onlyOnDetail(),
            ChoiceField::new('status', 'Estado')->setChoices(['Activo' => 'Activo', 'Cancelado' => 'Cancelado',])->setFormTypeOption('placeholder', false)->renderAsBadges(['Activo' => 'success', 'Cancelado' => 'secondary',]),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $goal = new Goal();
        $goal->setUser($this->getUser());
        $goal->setStatus('Activo');
        $goal->setFrequency('Mensual');
        return $goal;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Goal) {
            return;
        }

        // Calcular startDate desde mes y año
        if ($entityInstance->getMonth() && $entityInstance->getYear()) {
            $startDate = \DateTime::createFromFormat('Y-n-j', "{$entityInstance->getYear()}-{$entityInstance->getMonth()}-1");
            $entityInstance->setStartDate($startDate);
        }

        // Asignar miembro automáticamente si no se asigna
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

    private function getMonthChoices(): array
    {
        return ['Enero' => 1, 'Febrero' => 2, 'Marzo' => 3, 'Abril' => 4, 'Mayo' => 5, 'Junio' => 6, 'Julio' => 7, 'Agosto' => 8, 'Septiembre' => 9, 'Octubre' => 10, 'Noviembre' => 11, 'Diciembre' => 12,];
    }

    private function getYearChoices(): array
    {
        $currentYear = (int) date('Y');
        return array_combine(
            range($currentYear - 10, $currentYear + 10),
            range($currentYear - 10, $currentYear + 10)
        );
    }
}
