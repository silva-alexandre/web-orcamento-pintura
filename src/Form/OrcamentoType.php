<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Orcamento;
use App\Entity\Servico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrcamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qtd')
            ->add('valor_total')
            ->add('data', null, [
                'widget' => 'single_text',
            ])
            ->add('id_cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => 'id',
            ])
            ->add('id_servico', EntityType::class, [
                'class' => Servico::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orcamento::class,
        ]);
    }
}
