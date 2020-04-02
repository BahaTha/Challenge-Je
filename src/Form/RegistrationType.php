<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     *  @param string $label
     * @param string $placeholder
     * $param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options=[])
    {
        return array_merge([
            'label' =>$label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options );
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Email')
            ->add('Username')
            ->add('Phone')
            ->add('Password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
