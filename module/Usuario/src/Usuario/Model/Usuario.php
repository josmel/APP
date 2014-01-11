<?php


namespace Usuario\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Usuario implements InputFilterAwareInterface{
    
    public $iduser;
    public $userName;
    public $password;  
    public $name;
    public $lastName;
    public $lastUpdate;
    public $flagAct;
 
    

    protected $inputFilter;  
    
    public function exchangeArray($data){
            $this->iduser= (!empty($data['iduser'])) ? $data['iduser'] : null;
            $this->userName= (!empty($data['userName'])) ? $data['userName'] : null;
            $this->password= (!empty($data['password'])) ? $data['password'] : null;
            $this->name = (!empty($data['name'])) ? $data['name'] : null;
            $this->lastName = (!empty($data['lastName'])) ? $data['lastName'] : null;
            $this->lastUpdate= (!empty($data['lastUpdate'])) ? $data['lastUpdate'] : null;
            $this->flagAct= (!empty($data['flagAct'])) ? $data['flagAct'] : null;
         }

    public function setInputFilter(InputFilterInterface $inputFilter) {
         throw new \Exception("Not used");
    }
    
      
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
     public function getInputFilter()
    {
         
         if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
         $inputFilter->add($factory->createInput(array(
                        'name' => 'iduser',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'userName',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
               $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
              $inputFilter->add($factory->createInput(array(
                'name'     => 'lastName',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
           
              
             $this->inputFilter = $inputFilter;
         }
        
         return $this->inputFilter;
         
    }
    
    
   
}