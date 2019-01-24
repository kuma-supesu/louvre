<?php

namespace LO\TicketBundle\Form\Type;

use LO\TicketBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname', TextType::class, array('label' => 'Prénom', 'required' => 'true'))
            ->add('lname', TextType::class, array('label' => 'Nom', 'required' => 'true'))
            ->add('birthday', DateType::class, array('label' => 'Date de naissance', 'widget' => 'single_text', 'html5' => false, 'attr' => ['class' => 'js-datepicker'], 'format' => 'dd-MM-yy'))
            ->add('country', CountryType::class, array('label' => 'Pays', 'preferred_choices' => array('FR')))
            ->add('reduc', CheckboxType::class, array('label' => 'Réduction', 'required' => false))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
        ));
    }
}