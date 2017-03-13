<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VideoType
 * @package AppBundle\Form\Type
 */
class VideoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'name',
                'placeholder' => 'Choose a category..',
                'required' => false,
            ])
            ->add('author')
            ->add('channel')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'AppBundle\Entity\Video'
            ])
        ;
    }
}