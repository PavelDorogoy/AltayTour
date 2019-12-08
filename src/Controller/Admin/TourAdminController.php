<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class TourAdminController extends EasyAdminController
{
    public function createTourEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $formBuilder->add('instructor', EntityType::class, [
            'class' => 'App\Entity\User',
            'label' => 'Инструктор',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE \'%ROLE_INSTRUCTOR%\'');
            },
        ]);

        return $formBuilder;
    }
}