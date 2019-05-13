<?php

namespace App\Form;

use App\Entity\CategorieMatiere;
use App\Entity\Duel;
use App\Entity\Inscrit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreInscrit1')
            ->add('scoreInscrit2')
            ->add('tour', HiddenType::class)
            ->add('inscrit1',EntityType::class,['class' => Inscrit::class, 'choice_label' => 'nom','required'  => false])
            ->add('inscrit2',EntityType::class,['class' => Inscrit::class, 'choice_label' => 'nom','required'  => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duel::class,
        ]);
    }
}
