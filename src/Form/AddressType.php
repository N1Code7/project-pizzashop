<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                "label" => "Votre ville :",
                "attr" => ["placeholder" => "ex : Paris"],
                "required" => true
            ])
            ->add('zipCode', NumberType::class, [
                "label" => "Votre code postal :",
                "scale" => 0,
                "attr" => ["placeholder" => "ex : 75000"],
                "required" => true
            ])
            ->add('street', TextType::class, [
                "label" => "Votre numéro et votre voie :",
                "attr" => ["placeholder" => "1, avenue de la République"],
                "required" => true
            ])
            ->add('supplement', TextareaType::class, [
                "label" => "Complément d'adresse :",
                "required" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
