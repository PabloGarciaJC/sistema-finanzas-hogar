<?php

namespace App\Controller\Admin;

use App\Entity\Year;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Doctrine\ORM\EntityManagerInterface;

class YearController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Year::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('year', 'Año');
        yield BooleanField::new('status', 'Activo');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Year) {
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

        $this->addFlash('success', 'El año se ha creado correctamente.');

        parent::persistEntity($entityManager, $entityInstance);
    }
}
