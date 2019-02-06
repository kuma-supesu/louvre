<?php

namespace LO\TicketBundle\Form\Type;

use LO\TicketBundle\Entity\Commande_Temp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('booking', DateType::class, array('widget' => 'single_text', 'label' => 'Date de Réservation', 'html5' => false, 'attr' => ['class' => 'js-datepicker'], 'format' => 'dd-MM-yy'))
            ->add('day',    CheckboxType::class, array('label' => 'Tarif demi journée', 'required' => false))
            ->add('ticket_number', IntegerType::class, array('label' => 'Nombre de ticket', 'required' => true))
            ->add('booking_code', HiddenType::class)
            ->add('email', RepeatedType::class, array('required' => true, 'first_options'  => array('label' => 'Entrez votre Email'), 'second_options' => array('label' => 'Vérification de votre Email'), 'invalid_message' => 'Les Emails ne correspondent pas.'))
            ->add('tickets', CollectionType::class, array('entry_type' => TicketType::class, 'label' => false))
            ->add('save', SubmitType::class, array('label' => 'Valider', 'attr' => array('class' => 'btn')))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Commande_Temp::class,
        ));
    }
}