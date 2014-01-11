<?php
namespace Event\Form;

use Zend\Form\Form;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;



class ComplaintForm extends Form
{
//    protected $dbAdapter;
//    protected $idplato;
     public function __construct(AdapterInterface $dbAdapter)//$name = null
    {
        $this->setDbAdapter($dbAdapter);
//        $this->setId($id);
        parent::__construct('complaint');
        $this->setAttribute('method', 'post');
        $this->setAttribute('endtype', 'multipart/form-data');
        
        
     
   
       $this->add(array(
            'name' => 'picture',
            'type' => 'file'
        ));
        
      
    }

     }
   