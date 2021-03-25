<?php

namespace App\Form;

use App\Entity\User5;
use App\Entity\Videos;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\VideosType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('PostedAt',DateType::class)
            ->add('Author', EntityType::class, [
                'class' => User5::class,
                'choice_label' => 'email',
                
            ])
            ->add('Description')
            
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                
            ])
            ->add('Price')
            ->add('rating')
            ->add('Slug')
            ->add('image', FileType::class , [
                'label' => 'image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
