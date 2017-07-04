<?php
// src/SF/PlatformBundle/Form/AdvertEditType.php

namespace SF\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdvertEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->remove('date')
		->add('skills', CollectionType::class, array(
		        'entry_type'    => AdvertSkillType::class,
		        'allow_add'     => true,
		        'allow_delete'  => true,
		        'label'         => 'Ajouter des skills',
		        // 'data'          => $options['defaultAdvertSelection']
        ));
	}

	public function getParent()
	{
		return AdvertType::class;
	}

}
