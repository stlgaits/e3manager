<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }


    public function __construct(
        UtilisateurRepository $utilisateurRepository
    ) {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
                IdField::new('id')->hideOnForm(),
                EmailField::new('email'),
                EmailField::new('username', 'Confirmez Email')->hideOnIndex(),
                TextField::new('nom'),
                TextField::new('prenom', 'Prénom'),
                TelephoneField::new('telephone', 'Téléphone'),
                ArrayField::new('roles', 'Rôles'),
                AssociationField::new('clients'),
                TextField::new('password', 'Mot de passe')->onlyWhenCreating(),
                AssociationField::new('fraisAll', 'Notes de frais'),
                // ->formatValue(function ($value, $entity) {
                //     return $entity->setPassword($value) ? $value : $encoder->encodePassword($entity, $value);
                // }),
                ChoiceField::new('locale', 'Langue')->setChoices([
                        'Français' => 'fr_FR',
                        'English' => 'en_US'
                    ])
            ];


        return $fields;
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
                ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
                ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
                 ->setPermission(Action::NEW, 'ROLE_ADMIN')
                ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN');
    }
}
