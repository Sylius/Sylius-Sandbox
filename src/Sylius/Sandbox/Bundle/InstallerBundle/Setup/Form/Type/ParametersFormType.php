<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Form\Type;

use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Form\AbstractType;

class ParametersFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('secret')

            ->add('databaseDriver', 'choice', array(
              'choices' => array(
                    'pdo_mysql'  => 'MySQL',
                    'pdo_sqlite' => 'SQLite',
                    'pdo_pgsql'  => 'PosgreSQL',
                    'pdo_oci'    => 'Oracle',
                    'pdo_ibm'    => 'IBM DB2',
                    'pdo_sqlsrv' => 'SQLServer'
            )))
            ->add('databaseHost')
            ->add('databasePort', 'text', array('required' => false))
            ->add('databaseName')
            ->add('databaseUser')
            ->add('databasePassword', 'password', array('required' => false))

            ->add('locale', 'choice', array('choices' => array(
                'en' => 'English',
                'pl' => 'Polski'
            )))

            ->add('mailerTransport', 'choice', array(
                'choices' => array(
                    'smtp' => 'SMTP',
            )))
            ->add('mailerHost')
            ->add('mailerUser', 'text', array('required' => false))
            ->add('mailerPassword', 'password', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'sylius_sandbox_installer_parameters';
    }
}
