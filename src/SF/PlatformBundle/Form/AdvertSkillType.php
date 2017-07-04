<?php

namespace SF\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdvertSkillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('skill', EntityType::class, array(
          'class'        => 'SFPlatformBundle:Skill',
          'choice_label' => 'name',
          'multiple'     => false
        ))
        // ->add('advert', EntityType::class, array(
        //   'class'        => 'SFPlatformBundle:Advert',
        //   'choice_label' => 'id',
        //   'multiple'     => false,
        // ))
        ->add('level', TextType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SF\PlatformBundle\Entity\AdvertSkill'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sf_platformbundle_advertSkill';
    }


}
