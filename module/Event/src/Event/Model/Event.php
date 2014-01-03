<?php

namespace Event\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Event implements InputFilterAwareInterface
{
    public $idevent;
    public $flagAct;
    public $name;
    public $description;
    public $location;
    public $creatingDate;
    public $dateEvent;
    public $lastUpdate;
    public $user_iduser;
    public $picture;

    
   
    protected $inputFilter;   
    
    public function exchangeArray($data){
            $this->idevent= (!empty($data['idevent'])) ? $data['idevent'] : null;
            $this->flagAct= (!empty($data['flagAct'])) ? $data['flagAct'] : null;
            $this->name= (!empty($data['name'])) ? $data['name'] : null;
            $this->description= (!empty($data['description'])) ? $data['description'] : null;
            $this->location= (!empty($data['location'])) ? $data['location'] : null;
            $this->creatingDate= (!empty($data['creatingDate'])) ? $data['creatingDate'] : null;
            $this->dateEvent= (!empty($data['dateEvent'])) ? $data['dateEvent'] : null;
            $this->lastUpdate= (!empty($data['lastUpdate'])) ? $data['lastUpdate'] : null;
            $this->user_iduser= (!empty($data['user_iduser'])) ? $data['user_iduser'] : null;
             $this->picture= (!empty($data['picture'])) ? $data['picture'] : null;
 
         }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
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
                'name' => 'in_id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));
//            
//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'ta_grupo_in_id',
//                        'required' => true,
//                        'filters' => array(
//                            array('name' => 'Int'),
//                        ),
//                    )));    
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'va_latitud',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'va_longitud',
                'required' => false
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'va_nombre',
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
                'name'     => 'va_descripcion',
                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8'
                        ),
                    ),
                ),
            )));
            
             $inputFilter->add($factory->createInput(array(
                'name'     => 'va_fecha',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
//                'validators' => array(
//                    array(
//                        'name'    => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min'      => 3,
//                            'max'      => 200,
//                        ),
//                    ),
//                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'va_costo',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
              $inputFilter->add($factory->createInput(array(
                'name'     => 'va_direccion',
                'required' => false,
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
                'name'     => 'va_referencia',
                'required' => false,
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
            
//
//            
////              $inputFilter->add($factory->createInput(array(
////                'name'     => 'ta_categoria_in_id',
////                'required' => true,
////                'filters'  => array(
////                    array('name' => 'StripTags'),
////                    array('name' => 'StringTrim'),
////                ),
////            )));
//              
                $inputFilter->add($factory->createInput(array(
                'name'     => 'ta_ubigeo_in_id',//distrito
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));
                
             $inputFilter->add($factory->createInput(array(
                'name'     => 'va_tipo',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));
            
//           $inputFilter->add(
//                $factory->createInput(array(
//                    'name'     => 'va_imagen',
//                    'required' => false,
//                     'validators' => array(
//                    array(
//                        'name'    => 'filemimetype',
//                      //  'options' =>  array('mimeType' => 'image/png,image/x-png,image/jpg,image/gif,image/jpeg'),
//                        'options' =>  array('mimeType' => 'image/jpg,image/jpeg'),
//                    ),
//                    array(
//                        'name'    => 'filesize',
//                        'options' =>  array('max' => 204800),
//                    ),
//                  ),
//               ))
//            );
                $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    
}
