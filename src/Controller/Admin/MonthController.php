<?php

namespace App\Controller\Admin;

use App\Entity\Month;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Doctrine\ORM\EntityManagerInterface;

class MonthController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Month::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $idField = IdField::new('id', 'ID')
            ->onlyOnIndex()
            ->onlyOnDetail();

        $nameField = TextField::new('name', 'Nombre')
            ->setRequired(true);

        $statusField = BooleanField::new('status', 'Activo')
            ->renderAsSwitch(true);

        if ($pageName === Crud::PAGE_INDEX) {
            return [$idField, $nameField, $statusField];
        }

        return [$nameField, $statusField];
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Mes')
            ->setEntityLabelInPlural('Meses')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestión de Meses')
            ->setSearchFields(['name']);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Month) {
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

        $this->addFlash('success', 'El mes se ha creado correctamente.');

        parent::persistEntity($entityManager, $entityInstance);
    }
}
