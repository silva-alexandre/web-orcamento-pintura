<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Orcamento;
use App\Entity\Servico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrcamentoCompletoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campos do Cliente
            ->add('nomeCliente', TextType::class, [
                'label' => 'Nome do Cliente',
                'mapped' => false // Não mapeado diretamente para a entidade Orcamento
            ])
            ->add('contatoCliente', TextType::class, [
                'label' => 'Contato',
                'mapped' => false // Não mapeado diretamente para a entidade Orcamento
            ])
            // Campos do Orçamento
            ->add('id_servico', TextType::class, [
                'mapped' => false
            ])
            ->add('qtd', NumberType::class, [
                'label' => 'Quantidade'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orcamento::class,
        ]);
    }
}
