<?php

namespace App\Form;

use App\DTO\Payment;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("address", AddressType::class)
            ->add("cardNumber", TextType::class, [
                "label" => "Numéro de CB",
                "attr" => ["placeholder" => "XXXX XXXX XXXX XXXX"],
                "required" => true
            ])
            ->add("expirationMonth", TextType::class, [
                "label" => "Expiration",
                "attr" => ["placeholder" => "01"],
                "required" => true
            ])
            ->add("expirationYear", TextType::class, [
                "label" => false,
                "attr" => ["placeholder" => "10"],
                "required" => true
            ])
            ->add("cvc", TextType::class, [
                "label" => "Cryptogramme",
                "attr" => ["placeholder" => "XXX"],
                "required" => true
            ])
            ->add("submit", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Payment::class
        ]);
    }
}
