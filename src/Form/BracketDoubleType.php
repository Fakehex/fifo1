<?php

namespace App\Form;

use App\Entity\BracketDouble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BracketDoubleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('duels', CollectionType::class, [
            'entry_type' => DuelType::class,
            'entry_options' => ['label' => false],
        ])
            ->add('duelsPerdants', CollectionType::class, [
                'entry_type' => DuelType::class,
                'entry_options' => ['label' => false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BracketDouble::class,
        ]);
    }
}
