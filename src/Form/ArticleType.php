<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,
                        ['label'=>'Nom'] )
            ->add('description',TextareaType::class,['label'=>"Description"])
            ->add('price',NumberType::class,['label'=>"Prix"])
            ->add('category',EntityType::class,[
                "class"=>Category::class,
                "choice_label"=>"name",
                "label"=>"Catégorie",        
            ])
            ->add('autre',CheckboxType::class,[
                'label'=>'Autre',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('category_name',TextType::class,[
                'label'=>'Nom catégorie',   
                'mapped'=>false,
                'required'=>false           
            ])
            ->add('Ajouter',SubmitType::class)// pour ajouter un bouton de type submit
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            
        ]);
    }
}
