<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class,[
                'choices' => $this->getChoice(),
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('adress')
            ->add('codePostal')
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    private function getChoice()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $key => $value){
            $output[$value] = $key;
        }
        return $output;
    }
}
