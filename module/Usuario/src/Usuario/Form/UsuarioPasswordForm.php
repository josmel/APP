<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UsuarioPasswordForm extends Form {



    public function __construct($name =null) {
        if ($dbAdapter != null) {
            $this->setDbAdapter($dbAdapter);
        }
        parent::__construct('usuario');
        $this->setAttribute('method', 'post');
        $this->setAttribute('endtype', 'multipart/form-data');

        $this->add(array(
            'name' => 'iduser',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'iduser',
            ),
         ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'contraseña antigua…'
            ),
        ));

        $this->add(array(
            'name' => 'passwordone',
            'type' => 'Password',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'contraseña nueva... '
            ),
        ));

        $this->add(array(
            'name' => 'passwordtwo',
            'type' => 'Password',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'confirma contraseña nueva'
            ),
        ));
   $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Actualizar',
                'class' => 'btn btn-info btn-large',//'btn btn-primary'
//                'id' => 'submitbutton',
            ),
        ));

    }

}

