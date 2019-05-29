<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class,  array('attr' => array('class' => 'form-control')))
            ->add('nom', TextType::class,  array('attr' => array('class' => 'form-control')))
            ->add('email',EmailType::class, array('attr' => array('class' => 'form-control')))
            ->add('statut',ChoiceType::class, array('attr' => array('class' => 'form-control'),'choices' => ['Etudiant' => 'Etudiant', 'Professeur' => 'Professeur','Externe' => 'Externe']))
            ->add('Mettre a jour le profile',SubmitType::class, array('attr' => array('class' => 'btnSecondary btn-dark m-2')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
