<?php

namespace App\Form;

use App\Entity\Correction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Archives;


class CorrectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('correction',FileType::class, ['label' => 'Sujet (PDF file)', 'data_class' => null])
            ->add('date')
            ->add('pocebleu',HiddenType::class,['data' => 0])
            ->add('archive', EntityType::class,['class' => Archives::class, 'choice_label' => 'titre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Correction::class,
        ]);
    }
}
