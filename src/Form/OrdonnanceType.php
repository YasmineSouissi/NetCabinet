<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Ordonnance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medicaments', CollectionType::class, [
                'entry_type' => MedicamentType::class, // Le formulaire de type Medicament
                'allow_add' => true, // Permettre d'ajouter des médicaments
                'allow_delete' => true, // Permettre de supprimer des médicaments
                'by_reference' => false, // Passer par référence pour modifier les entités
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
