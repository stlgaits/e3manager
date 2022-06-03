<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LocaleField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function indexAction()
    {
        $url = $this->adminUrlGenerator
        ->setController(ClientCrudController::class)
        ->setAction('edit')
        // ->setEntityId($this->getId())
        ->generateUrl();
    }

    public static function getEntityFqcn(): string
    {
        return Client::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Client')
        ->setEntityLabelInPlural('Clients')
        ->setSearchFields(['id', 'prenom', 'nom', 'adresse', 'email', 'tel', 'addedBy']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom'),
            TextField::new('adresse'),
            EmailField::new('email'),
            TelephoneField::new('tel', 'Téléphone'),
            AssociationField::new('addedBy', 'Ajouté par')
                ->setTemplatePath('bundles/EasyAdminBundle/custom_field.html.twig')
        ];
    }
}
