<?php

namespace App\Form;

use App\Entity\Inscrit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Maison;
use App\Entity\Evenement;



class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('maison', EntityType::class,['class' => Maison::class, 'choice_label' => 'nom'])
            ->add('evenement', EntityType::class,['class' => Evenement::class, 'choice_label' => 'titre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscrit::class,
            'empty_data' => null,
        ]);
    }
}
