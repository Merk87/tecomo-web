<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Merkury
 * Date: 07/04/14
 * Time: 21:56
 * To change this template use File | Settings | File Templates.
 */

namespace Tecomo\LandingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', 'text', array(
                'attr' => array(
                    'pattern'     => '.{2,}', //minlength
                    'class' => 'form-control contact-input'
                )
            ))

            ->add('Email', 'email', array(
                'attr' => array(
                  'class' => 'form-control contact-input'
                )
            ))

            ->add('Asunto', 'text', array(
                'attr' => array(
                    'pattern'     => '.{3,}', //minlength
                    'class' => 'form-control contact-input'
                )
            ))

            ->add('Mensaje', 'textarea', array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'class' => 'form-control contact-textarea contact-input'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'Nombre' => array(
                new NotBlank(array('message' => 'Dínos como te llmas.')),
                new Length(array('min' => 2))
            ),
            'Email' => array(
                new NotBlank(array('message' => '¿No quieres que te contestemos?')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'Asunto' => array(
                new NotBlank(array('message' => '¿De que quieres hablarnos?')),
                new Length(array('min' => 3))
            ),
            'Mensaje' => array(
                new NotBlank(array('message' => 'Por lo menos dinos en que podemos ayudarte.')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }


    public function getName()
    {
        return 'tecomo_landing_contacttype';
    }

}