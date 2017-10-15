<?php
namespace PaulBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AthleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
                                        'label' => 'name'
                ))
                ->add('prenom', TextType::class, array(
                                        'label' => 'firstname'
                ))
                ->add('date_naissance', BirthdayType::class, array(
                                        'label' => 'birthdate'
                ))
                ->add('pays', EntityType::class, array(
                                        'label'        => 'country',
                                        'class'        => 'PaulBundle:Pays',
                                        'multiple'     => false,
                                        'choice_label' => 'nom',
                                        'expanded'     => false,
                                        'placeholder'  => "country"
                ))
                ->add('discipline', EntityType::class, array(
                                        'label'        => 'sport',
                                        'class'        => 'PaulBundle:Discipline',
                                        'choice_label' => 'nom',
                                        'multiple'     => false,
                                        'expanded'     => false
                ))
                ->add('photo', FileType::class, array(
                                        'label'      => 'photo',
                                        'data_class' => null
                ))
                ->add('save', SubmitType::class, array(
                                        'label'        => 'saveAthlete'
                ));
    }

    public function getName()
    {
        return 'athlete';
    }
}