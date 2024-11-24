<?php

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'help' => 'Введите полное имя разработчика.',
            ])
            ->add('surname', TextType::class, [ // Новое поле для фамилии
                'label' => 'Фамилия',
                'help' => 'Введите фамилию разработчика.',
            ])
            ->add('fullname', TextType::class, [ // Новое поле для отчества
                'label' => 'Отчество',
                'help' => 'Введите отчество разработчика.',
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
        ]);
    }
}