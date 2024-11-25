<?php

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'help' => 'Введите полное имя разработчика.',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Фамилия',
                'help' => 'Введите фамилию разработчика.',
            ])
            ->add('fullname', TextType::class, [
                'label' => 'Отчество',
                'help' => 'Введите отчество разработчика.',
            ])
            ->add('birthdate', TextType::class, [
                'label' => 'Дата рождения',
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Пожалуйста, укажите дату рождения.']),
                    new DateTime([
                        'format' => 'd.m.Y',
                        'message' => 'Дата должна быть в формате дд.мм.гггг.',
                    ]),
                ],
            ])
            ->add('position', TextType::class, [
                'label' => 'Должность',
                'help' => 'Введите должность разработчика.',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Электронная почта',
                'help' => 'Введите действительный адрес электронной почты.',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Номер телефона',
                'help' => 'Введите номер телефона разработчика.',
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Проекты',
                'help' => 'Выберите проекты, с которыми связан разработчик.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
            'projects' => [],
        ]);
    }
}