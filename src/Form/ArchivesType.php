<?php

namespace App\Form;

use App\Entity\Archives;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArchivesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('sujet', FileType::class, ['label' => 'Sujet (PDF file)', 'data_class' => null])
            ->add('matiere', EntityType::class,['class' => Matiere::class, 'choice_label' => 'titre'])
            ->add('date', DateType::class,['widget' => 'choice','attr' => array('class'=>'form-control')])
            ->add('secondeSession')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Archives::class,
        ]);
    }
}
