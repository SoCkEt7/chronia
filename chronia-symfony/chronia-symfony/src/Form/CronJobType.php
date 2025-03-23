<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CronJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('schedule', TextType::class, [
                'label' => 'Schedule',
                'help' => 'Enter a cron schedule expression (e.g. "0 * * * *" for every hour)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a schedule',
                    ]),
                ],
            ])
            ->add('schedule_type', ChoiceType::class, [
                'label' => 'Preset Schedules',
                'mapped' => false,
                'required' => false,
                'choices' => [
                    'Custom' => 'custom',
                    'Every Minute' => '* * * * *',
                    'Every Hour' => '0 * * * *',
                    'Every Day at Midnight' => '0 0 * * *',
                    'Every Week on Sunday' => '0 0 * * 0',
                    'Every Month on the 1st' => '0 0 1 * *',
                    'Every Year on January 1' => '0 0 1 1 *',
                ],
                'attr' => [
                    'class' => 'schedule-presets',
                ],
            ])
            ->add('command', TextType::class, [
                'label' => 'Command',
                'help' => 'The command to execute',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a command',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}