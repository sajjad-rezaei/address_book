<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\ZipCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname' , TextType::class)
            ->add('lastName' , TextType::class)
            ->add('fullAddress' , TextType::class)
            ->add('phoneNumber', TelType::class)
            ->add('email' ,  EmailType::class)
            ->add('zipCode' ,  ZipCodeType::class,[
                'constraints' => array(new Valid()),
                "label" => false
            ])
            ->add('birthDay' , DateType::class , [

                    "widget" => "single_text"
            ])
            ->add('pic', FileType::class, [
                'required' => false,
                "attr" => [
                    'accept'=>"image/*"
                ],
                "label" => "profile image",
                "data_class" => null
            ])
            ->add('save', SubmitType::class,
                [
                    "label" => "Create",
                    "attr" => [
                        "class" => "btn btn-primary float-right btnSubmit"
                    ]
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class

        ]);
    }

}
