<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                "label" => "Votre NOM :",
                "attr" => ["placeholder" => "ex : DUPONT"],
                "required" => true
            ])
            ->add('firstname', TextType::class, [
                "label" => "Votre Prénom :",
                "attr" => ["placeholder" => "ex : Arthur"],
                "required" => true
            ])
            ->add('email', EmailType::class, [
                "label" => "Votre email :",
                "attr" => ["placeholder" => "ex : arthur.dupont@mail.com"],
                "required" => true
            ])
            ->add('password', PasswordType::class, [
                "label" => "Votre mot de passe :",
                "attr" => ["placeholder" => "8 caractères minimum"],
                "required" => true
            ])
            ->add("confirmPassword", PasswordType::class, [
                "label" => "Répétez votre mot de passe :",
                "attr" => ["placeholder" => "Confirmez votre mot de passe"],
                "required" => true
            ])
            ->add('phone', TelType::class, [
                "label" => "Votre téléphone :",
                "attr" => ["placeholder" => "ex : 06 12 34 57 79"],
                "required" => true,
            ])
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
            ->add('streetAddress', TextType::class, [
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
            'data_class' => User::class,
        ]);
    }
}
