<?php
// AppBundle/Form/Type/SupplierType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormEvent,
    Symfony\Component\Form\FormEvents,
    Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    private $boundlessAccess;

    public function __construct($boundlessAccess)
    {
        $this->boundlessAccess = $boundlessAccess;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'supplier.name.label',
                'attr'  => [
                    'placeholder' => 'supplier.name.placeholder'
                ]
            ])
            ->add('nameLegal', 'text', [
                'label' => 'supplier.name_legal.label',
                'attr'  => [
                    'placeholder' => 'supplier.name_legal.placeholder'
                ]
            ])
            ->add('descriptionShort', 'text', [
                'label' => 'supplier.description_short.label',
                'attr'  => [
                    'placeholder' => 'supplier.description_short.placeholder'
                ]
            ])
            ->add('description', 'textarea', [
                'label' => 'supplier.description.label',
                'attr'  => [
                    'placeholder' => 'supplier.description.placeholder'
                ]
            ])
            ->add('uploadedSupplierImages', 'file', [
                'required' => FALSE,
                'label'    => 'supplier.image_supplier_file.label',
                'attr'     => [
                    'accept'   => 'image/png, image/jpeg, image/pjpeg, image/gif',
                    'multiple' => TRUE
                ]
            ])
            ->add('phoneNumberSupplier', 'text', [
                'required' => FALSE,
                'label'    => 'supplier.phone_number_supplier.label',
                'attr'     => [
                    'placeholder' => 'supplier.phone_number_supplier.placeholder'
                ]
            ])
            ->add('emailSupplier', 'email', [
                'required' => FALSE,
                'label'    => 'supplier.email_supplier.label',
                'attr'     => [
                    'placeholder' => 'supplier.email_supplier.placeholder'
                ]
            ])
            ->add('nameContact', 'text', [
                'required' => FALSE,
                'label'    => 'supplier.name_contact.label',
                'attr'     => [
                    'placeholder' => 'supplier.name_contact.placeholder'
                ]
            ])
            ->add('phoneNumberContact', 'text', [
                'required' => FALSE,
                'label'    => 'supplier.phone_number_contact.label',
                'attr'     => [
                    'placeholder' => 'supplier.phone_number_contact.placeholder'
                ]
            ])
            ->add('emailContact', 'email', [
                'required' => FALSE,
                'label'    => 'supplier.email_contact.label',
                'attr'     => [
                    'placeholder' => 'supplier.email_contact.placeholder'
                ]
            ])
            ->add('contractNumber', 'text', [
                'required' => FALSE,
                'label'    => 'supplier.contract_number.label',
                'attr'     => [
                    'placeholder' => 'supplier.contract_number.placeholder'
                ]
            ])
            ->add('contractDateStart', 'date', [
                'required' => FALSE,
                'widget'   => 'single_text',
                'format'   => 'dd-MM-yy',
                'label'    => 'supplier.contract_date_start.label',
                'attr'     => [
                    'placeholder' => 'supplier.contract_date_start.placeholder'
                ]
            ])
            ->add('contractDateEnd', 'date', [
                'required' => FALSE,
                'widget'   => 'single_text',
                'format'   => 'dd-MM-yy',
                'label'    => 'supplier.contract_date_end.label',
                'attr'     => [
                    'placeholder' => 'supplier.contract_date_end.placeholder'
                ]
            ])
        ;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)
            {
                $supplier = $event->getData();

                $form = $event->getForm();

                if( $supplier && $supplier->getId() !== NULL )
                {
                    $form
                        ->add('logoFile', 'file', [
                            'required' => FALSE,
                            'label'    => 'supplier.logo_file.label',
                            'attr'     => [
                                'accept' => 'image/png, image/jpeg, image/pjpeg, image/gif'
                            ]
                        ])
                        ->add('update', 'submit', ['label' => 'common.update.label']);

                    if( $this->boundlessAccess )
                        $form->add('update_and_return', 'submit', ['label' => 'common.update_and_return.label']);
                } else {
                    $form
                        ->add('logoFile', 'file', [
                            'required' => TRUE,
                            'label'    => 'supplier.logo_file.label',
                            'attr'     => [
                                'accept' => 'image/png, image/jpeg, image/pjpeg, image/gif'
                            ]
                        ])
                        ->add('create', 'submit', ['label' => 'common.create.label']);

                    if( $this->boundlessAccess )
                        $form->add('create_and_return', 'submit', ['label' => 'common.create_and_return.label']);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'AppBundle\Entity\Supplier\Supplier',
            'translation_domain' => 'forms',
            'cascade_validation' => TRUE,
        ]);
    }

    public function getName()
    {
        return 'supplier';
    }
}