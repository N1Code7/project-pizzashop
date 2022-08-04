<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add("address", AddressType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'cascade_validation' => true // to force the validation of AddressType through the RegistrationType validation
        ]);
    }
}
