<?php

namespace App\Form;

use App\Entity\PortfolioEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Webmozart\Assert\Assert as AssertAssert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('img', FileType::class, [
                //'mapped' => false,
                'label' => 'Add picture (multiple selection allowed)',
                'multiple' => true,
                'constraints' => new All([
                    new Image([
                        'mimeTypes' => ['image/jpg', 'image/png'] 
                    ])
                ])
            ])
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('content', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('category', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PortfolioEntity::class,
        ]);
    }
}
