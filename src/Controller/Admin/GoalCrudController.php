<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

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
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('description', 'Descripción'),
            MoneyField::new('targetAmount', 'Monto objetivo')->setCurrency('USD'),
            TextField::new('targetMonth', 'Mes objetivo'),
            IntegerField::new('targetYear', 'Año objetivo'),
            TextField::new('status', 'Estado'),
            AssociationField::new('member', 'Miembro')->setRequired(true),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Goal) return;

        // Asigna automáticamente el miembro si no está definido
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
}
