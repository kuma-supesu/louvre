<?php

namespace LO\TicketBundle\Form\Type;

use LO\TicketBundle\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('booking', DateType::class, array('label' => 'Date de réservation', 'years' => range(date('Y'), 2100),'format' => 'dd-MM-yyyy', 'placeholder' => array('month' => date(' '),'day' =>date(' '))))
            ->add('booking_code', HiddenType::class)
            ->add('email', TextType::class, array('label' => 'Votre E-mail', 'required' => true))
            ->add('day',    CheckboxType::class, array('label' => 'Tarif demi journée', 'required' => false))
            ->add('ticket_number', IntegerType::class, array('label' => 'Nombre de ticket', 'required' => true))
            ->add('save', SubmitType::class, array('label' => 'Suivant'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Commande::class,
        ));
    }
}