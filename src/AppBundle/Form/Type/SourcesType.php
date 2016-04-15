<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Source;
use AppBundle\Entity\SourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SourcesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => "AppBundle:SourceType",
                'choice_label' => 'name',
            ))
            ->add('name')
            ->add('slug')
            ->add('host')
            ->add('port', 'integer', array('required' => false))
            ->add('username')
            ->add('password')
            ->add('filepath')
        ;
    }

    public function getName()
    {
        return 'sources';
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Source'
        ));
    }
}
