<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("previousPassword", PasswordType::class, [
                "label" => "Votre ancien mot de passe :",
                "required" => true
            ])
            ->add('password', PasswordType::class, [
                "label" => "Votre nouveau mot de passe :",
                "attr" => ["placeholder" => "8 caractères minimum"],
                "required" => true
            ])
            ->add("confirmPassword", PasswordType::class, [
                "label" => "Répétez votre nouveau mot de passe :",
                "attr" => ["placeholder" => "Confirmez votre mot de passe"],
                "required" => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
