<?php

namespace App\Controller\Admin;

use App\Entity\Aswer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aswer::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('question'),
            DateTimeField::new('date'),
            TextareaField::new('text'),
            BooleanField::new('status'),
            AssociationField::new('user'),

        ];
    }

}
