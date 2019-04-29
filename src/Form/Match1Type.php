<?php

namespace App\Form;

use App\Entity\Match;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Match1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreEquipe1')
            ->add('scoreEquipe2')
            ->add('tour')
            ->add('inscrit1')
            ->add('inscrit2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Match::class,
        ]);
    }
}
