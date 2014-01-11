<?php
namespace SanAuth\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\InputFilter;

class UserForm extends Form
{
     public function __construct($name = null)
    {
        parent::__construct('usuario');
        $this->setAttribute('method', 'post');
        $this->setAttribute('endtype', 'multipart/form-data');
   
         $this->add(array(
            'name' => 'userName',
            'type' => 'Text',
            'attributes' => array(               
                'id' => 'userName',
                'placeholder'=>'Ingrese el usuario'
            )
        ));  
         $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'attributes' => array(
                'id'=>'password',
                'placeholder'=>'Ingrese la contraseña'
            )
        ));
        
        $this->setInputFilter($this->validadores());
    }
    
    public function validadores(){
        $inputFilter = new InputFilter();
        
        $inputFilter->add(array(
            'name' => 'userName',
            'required' => true,
        
        ));
     
        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
        ));
        
//        $inputFilter->add(array(
//            'name' => 'Remenber',
//            'required' => false,
//        ));
        
        return $inputFilter;
        
    }
}

