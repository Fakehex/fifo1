<?php

namespace App\Form;

use App\Entity\BracketDirect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BracketDirectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('duels', CollectionType::class, [
        'entry_type' => DuelType::class,
        'entry_options' => ['label' => false],
    ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BracketDirect::class,
        ]);
    }
}
