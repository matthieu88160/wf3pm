<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'comment', 
                TextareaType::class,
                [
                    'required' => false
                ]
            )->add(
                'files',
                CollectionType::class,
                [
                    'entry_type' => CommentFileType::class,
                    'allow_add' => true
                ]
            );

        if ($options['stateless']){
            $builder->add('submit', SubmitType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_type', Comment::class);
        $resolver->setDefault('stateless', false);
    }

}

