<?php

namespace App\Controller\Admin;

use App\Entity\StatutFrais;
use App\Repository\FraisRepository;
use App\Repository\StatutFraisRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class StatutFraisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StatutFrais::class;
    }

    public function __construct(
        FraisRepository $fraisRepository,
        StatutFraisRepository $statutFraisRepository
    ) {
        $this->statutFraisRepository = $statutFraisRepository;
        $this->fraisRepository = $fraisRepository;
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
                ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
                ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
                 ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN')
                ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN');
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label', 'Intitulé'),
            AssociationField::new('fraisCollection', 'Frais')
        ];
    }
}
