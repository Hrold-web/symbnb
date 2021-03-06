<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options=[]){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration(
                    'Titre',
                    'Tapez le titre de l\'annonce')
            )
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration(
                    'Adresse web',
                    'Tapez l\'adresse de votre annonce (automatique par défaut)',
                ['required' => false
                ])
            )
            ->add(
                'coverImage',
                UrlType::class,
                $this->getConfiguration(
                    'Url de l\'image principale',
                    'Mettez une image de votre annonce')
            )
            ->add(
                'introduction',
                TextType::class,
                $this->getConfiguration(
                    'Introduciton',
                    'Indiquez la description globale de l\'annonce')
            )
            ->add(
                'content',
                TextareaType::class,
                $this->getConfiguration(
                    'Description détaillée',
                    'Indiquez une description détaillée de votre bien')
            )
            ->add(
                'rooms',
                IntegerType::class,
                $this->getConfiguration(
                    'Nombre de chambres',
                    'Nombre de chambres dans votre bien')
            )
            ->add(
                'price',
                MoneyType::class,
                $this->getConfiguration(
                    'Prix par nuit',
                    'Indiquez le prix que vous souhaitez pour une nuit')
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
