<?php

namespace App\Form;

use App\Entity\ZipCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ZipCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city' ,  CityType::class,[
                'constraints' => array(new Valid()),
                "label" => false
            ])
            ->add('code' ,TextType::class, [
                "label" => "zip code"
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ZipCode::class

        ]);
    }

}
