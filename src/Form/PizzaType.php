<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de la pizza :",
                "attr" => ["placeholder" => "ex : Margarita"],
                "required" => true
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description :",
                "required" => false
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix :",
                "attr" => ["placeholder" => "ex : 7,50 €"],
                "required" => true
            ])
            ->add('imageUrl', TextType::class, [
                "label" => "Url de l'image :",
                "attr" => ["placeholder" => "ex : https://www.image.fr"],
                "required" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
