<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UsuarioForm extends Form {



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
            'name' => 'userName',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'usuario…'
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'nombre... '
            ),
        ));

        $this->add(array(
            'name' => 'lastName',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'span10',
                'placeholder' => 'apellido'
            ),
        ));
   $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Ingresar',
                'class' => 'btn btn-info btn-large',//'btn btn-primary'
//                'id' => 'submitbutton',
            ),
        ));

    }

}

