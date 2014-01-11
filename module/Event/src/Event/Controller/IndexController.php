<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event\Controller;

use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use SanAuth\Controller\AuthController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $eventTable;
     protected $complaintTable;
    public function __construct() {
        $this->_options = new \Zend\Config\Config(include APPLICATION_PATH . '/config/autoload/global.php');
    }

  
    public function indexAction() {
        $this->layout()->module = 'Event';
        $this->layout()->controller = 'index';
        $this->layout()->action = 'index';

        $storage = new \Zend\Authentication\Storage\Session('Auth');
        $session = $storage->read();
        if (!$session) {
            return $this->redirect()->toUrl('/auth');
        }
        return new ViewModel();
    }
     
    public function jsonFechaAction() {
        $view = new ViewModel();
        header('Content-type: application/x-javascript');
        header("Status: 200");
        $start = $this->params()->fromQuery('start');
        $end = $this->params()->fromQuery('end');
        $dtms021 = date_create();
        date_timestamp_set($dtms021, $start);
        $startone = date_format($dtms021, 'Y-m-d H:i:s');
        $dtms022 = date_create();
        date_timestamp_set($dtms022, $end);
        $endone = date_format($dtms022, 'Y-m-d H:i:s');
        $eventosMolina[] = array();
        $eventos = $this->getEventTable()->getEventosxFecha($startone, $endone);
        $rutaImagen = $this->_options->host->rootImgDinamic;
        $four = array('heigth' => $this->_options->Picture->heightfour,
                            'width' => $this->_options->Picture->widthfour);
        if ($eventos == null) {
            $eventosMolina = array('mensaje' => 'no existen eventos');
        }
        for ($i = 0; $i < count($eventos); $i++) {
            $eventosMolina[$i]['id'] = (int) $eventos[$i]['idevent'];
            $eventosMolina[$i]['title'] = $eventos[$i]['name'];
            $eventosMolina[$i]['start'] = $eventos[$i]['start'];
            $eventosMolina[$i]['end'] = $eventos[$i]['end'];
            $eventosMolina[$i]['location'] = $eventos[$i]['location'];
            $eventosMolina[$i]['flagAct'] = $eventos[$i]['flagAct'];
            $eventosMolina[$i]['allDay'] = ($eventos[$i]['allDay'] === "1") ? true : false;
            $eventosMolina[$i]['description'] = $eventos[$i]['description'];
            $eventosMolina[$i]['coords'] = [$eventos[$i]['latitude'], $eventos[$i]['longitude']];
            $eventosMolina[$i]['img'] = $rutaImagen.'/event/'.$four['heigth'].'x'.$four['width'].'/'.$eventos[$i]['picture'];
            $eventosMolina[$i]['nameImg'] = $eventos[$i]['picture'];
            
            
        }
        echo json_encode($eventosMolina);
        exit();
        $view->setTerminal(true);
        return $view;
    }

    public function getEventTable() {
        if (!$this->eventTable) {
            $sm = $this->getServiceLocator();
            $this->eventTable = $sm->get('Event\Model\EventTable');
        }
        return $this->eventTable;
    }

    public function denunciaAction() {
        return new ViewModel();
    }

  

    public function insertPictureEventAction() {
       $view = new ViewModel();
        require './vendor/Utils/Core_Utils_Utils.php';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ruta = $this->_options->upload->images;
            $rutaImagen = $this->_options->host->rootImgDinamic;
            $File = $this->params()->fromFiles('imagen');
            if ($File['name'] != '') {
                $info = pathinfo($File['name']);
                $ee = new \Core_Utils_Utils();
                $code = $ee->getRamdomChars(15, 'A');
                $name = $code . '.' . $info['extension'];
                $newName = $ruta . "/event/origin/" . $name;
                move_uploaded_file($File['tmp_name'], $newName);
                        $one = array('heigth' => $this->_options->Picture->heightone,
                            'width' => $this->_options->Picture->widthone);
                        $two = array('heigth' => $this->_options->Picture->heighttwo,
                            'width' => $this->_options->Picture->widthtwo);
                        $three = array('heigth' => $this->_options->Picture->heightthree,
                            'width' => $this->_options->Picture->widththree);
                        $four = array('heigth' => $this->_options->Picture->heightfour,
                            'width' => $this->_options->Picture->widthfour);
                 $this->setReservation($name,$one,$two, $three, $four);
                 $imagenRuta = $rutaImagen.'/event/'.$four['heigth'].'x'.$four['width'].'/'.$name;
                $nombre = $name;
                $mensaje = 'ok';
                $state = 1;
            } else {
                $mensaje = 'la imagen no se pudo guardar';
                $state = 0;
            }
        }
        echo json_encode(array('msg' => $mensaje, 'state' => $state, 'urlImagen' => $imagenRuta, 'nombre' => $nombre));
        exit();
        $view->setTerminal(true);
        return $view;
    }

    
 
    
    public function agregarEventAction() {
        $view = new ViewModel();
        $storage = new \Zend\Authentication\Storage\Session('Auth');
        $session = $storage->read();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $fecha = date("Y-m-d h:m:s");
            $datos = $this->request->getPost();
            if (empty($datos['idevent'])) {
                $evento = array('name' => $datos['name'],
                    'description' => $datos['description'],
                    'location' => $datos['location'],
                    'start' => $datos['start'],
                    'flagAct' => $datos['flagAct'],
                    'end' => $datos['end'],
                    'user' => $session->iduser,
                    'CreatingDate' => $fecha,
                    'picture' => $datos['picture'],
                    'latitude' => $datos['latitude'],
                    'longitude' => $datos['longitude'],
                    'allDay' => $datos['allDay']);
                $resultado = $this->getEventTable()->InsertEvento($evento);
                if ($resultado == true) {
                    $mensaje = 'ok';
                    $state = 1;
                } else {
                    $mensaje = 'no se guardo el evento';
                    $state = 0;
                }
            } else {
                $evento = array('name' => $datos['name'],
                    'description' => $datos['description'],
                    'location' => $datos['location'],
                    'start' => $datos['start'],
                    'flagAct' => $datos['flagAct'],
                    'end' => $datos['end'],
                    'user' => $session->iduser,
                    'lastUpdate' => $fecha,
                    'picture' => $datos['picture'],
                    'latitude' => $datos['latitude'],
                    'longitude' => $datos['longitude'],
                    'allDay' => $datos['allDay']);
                $resultado = $this->getEventTable()->InsertEvento($evento, $datos['idevent']);
                if ($resultado == true) {
                    $mensaje = 'ok';
                    $state = 1;
                } else {
                    $mensaje = 'no se puede editar el evento';
                    $state = 0;
                }
            }
        }
        echo json_encode(array('msg' => $mensaje, 'state' => $state));exit();
        $view->setTerminal(true);
        return $view;
    }
    
       public function setReservation($nombre,$one,$two, $three, $four)
    {  require './vendor/Utils/Core_Utils_ResizeImage.php';
    $rutaImagen = $this->_options->upload->images;
                if(isset($one)) { 
                    $resize = new \Core_Utils_ResizeImage(
                            $rutaImagen.'/event/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $one['heigth'],$one['width'], 
                            'exact'
                        );
                 $destinyFolder = $rutaImagen.'/event/'.$one['heigth'].'x'.$one['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);

                 }
                 if(isset($two)) { 
                    $resize = new \Core_Utils_ResizeImage(
                            $rutaImagen.'/event/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $two['heigth'],$two['width'], 
                            'exact'
                        );
                    $destinyFolder = $rutaImagen.'/event/'.$two['heigth'].'x'.$two['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);

                 }
                 if(isset($three))  { 
                    $resize = new \Core_Utils_ResizeImage(
                            $rutaImagen.'/event/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $three['heigth'],$three['width'], 
                            'exact'
                        );
                 $destinyFolder = $rutaImagen.'/event/'.$three['heigth'].'x'.$three['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);

                 }
                 if(isset($four))  { 
                    $resize = new \Core_Utils_ResizeImage(
                            $rutaImagen.'/event/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $four['heigth'],$four['width'], 
                            'exact'
                        );
                 $destinyFolder = $rutaImagen.'/event/'.$four['heigth'].'x'.$four['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);

                 }
                
    }
  
}
