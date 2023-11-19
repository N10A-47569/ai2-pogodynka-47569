<?php

namespace App\Form;

use App\Entity\Forecast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('time', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('temperature', NumberType::class, [
                'html5' => true,

            ])
            ->add('wind_direction', ChoiceType::class, [
                'choices' => [
                    'NN' => 'NN',
                    'NE' => 'NE',
                    'NW' => 'NW',
                    'WW' => 'WW',
                    'WS' => 'WS',
                    'WN' => 'WN',
                    'SS' => 'SS',
                    'SE' => 'SE',
                    'SW' => 'SW',
                    'EE' => 'EE',
                    'EN' => 'EN',
                    'ES' => 'ES',

                ],
            ])
            ->add('wind_speed', NumberType::class, [
                'html5' => true,
        
            ])

            ->add('rain', NumberType::class, [
                'html5' => true,
        
            ])
            ->add('location', EntityType::class, [
                'class' => 'App\Entity\Location',
                'choice_label' => 'city',
            ])

            ->add('description', null, [
                'attr' => [
                    'placeholder' => 'Enter description',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}