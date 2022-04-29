<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Введите название заголовка сюда',
                    'class' => 'form-control'
                ]
            ])
            ->add('text', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Введите текст вопроса сюда',
                    'class' => 'form-control'
                ]
            ])
            ->add(
                'category',
                CategoryType::class,
                [
                    'label' => 'Категория вопроса',
                    'attr' => [
                        'placeholder' => 'Определите категорию',
                        'list' => 'category'
                    ],

                    'required' => true,
                ]
            )
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mb-2'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
