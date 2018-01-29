<?php

namespace HS\ListingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use HS\ListingBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use HS\ListingBundle\Repository\CategoryRepository;




class ListingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
        ->add('size')
        ->add('price')
        ->add('photo', FileType::class, array('label' => 'Image') )
        ->add('category', EntityType::class, 
            array(
                'class'=> "HS\ListingBundle\Entity\Category", 
                'label' => "Category"
                
            ))
        ->add('save',  SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HS\ListingBundle\Entity\Listing'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hs_listingbundle_listing';
    }



}
