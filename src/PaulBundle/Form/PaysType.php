<?php
namespace PaulBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
                                        'label' => 'name'
                ))
                ->add('drapeau', FileType::class, array(
                                        'label'      => 'flag',
                                        'data_class' => null
                ))
                ->add('save', SubmitType::class, array(
                                        'label'        => 'saveCountry'
                ));
    }

    public function getName()
    {
        return 'athlete';
    }
}