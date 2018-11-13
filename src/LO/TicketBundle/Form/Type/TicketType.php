<?php

namespace LO\TicketBundle\Form\Type;

use LO\TicketBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname',  TextType::class, array('label' => 'Prénom', 'required' => 'true'))
            ->add('lname',  TextType::class, array('label' => 'Nom', 'required' => 'true'))
            ->add('birthday',   DateType::class, array('label' => 'Date de naissance', 'years' => range(date('Y'),1902) ,'format' => 'dd-MM-yyyy', 'placeholder' => array('month' => date('00'),'day' =>date('00'))))
            ->add('country',    CountryType::class, array('label' => 'Pays', 'preferred_choices' => array('France')))
            ->add('reduc',  CheckboxType::class, array('label' => 'Réduction', 'required' => false))
            ->add('save',   SubmitType::class, array('label' => 'Valider'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
        ));
    }
}