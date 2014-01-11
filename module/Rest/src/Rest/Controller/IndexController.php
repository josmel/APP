<?php

namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulController {

    protected $eventTable;
    protected $complaintTable;

    public function __construct() {
        $this->_options = new \Zend\Config\Config(include APPLICATION_PATH . '/config/autoload/global.php');
    }

    public function get($lastUpdate) {
        $lastUpdate = $this->params()->fromQuery('lastUpdate', null);
        $categorias = $this->getEventTable()->eventos($lastUpdate);
        $valoresBlog[] = array();
        if ($categorias == null) {
            $valoresBlog = array('mensaje' => 'no existen datos');
        }
        for ($i = 0; $i < count($categorias); $i++) {
            $valoresBlog[$i]['idevent'] = (int) $categorias[$i]['idevent'];
            $valoresBlog[$i]['name'] = $categorias[$i]['name'];
            $valoresBlog[$i]['description'] = $categorias[$i]['description'];
            $valoresBlog[$i]['location'] = $categorias[$i]['location'];
            $valoresBlog[$i]['dateEvent'] = $categorias[$i]['start'];
            $valoresBlog[$i]['picture'] = $categorias[$i]['picture'];
        }
        $response = $this->getResponseWithHeader()
                ->setContent(json_encode($valoresBlog));
        return $response;
    }

    public function getList() {
        $categorias = $this->getEventTable()->eventosFull();
        $valoresBlog[] = array();
        if ($categorias == null) {
            $valoresBlog = array('mensaje' => 'no existen datos');
        }
        for ($i = 0; $i < count($categorias); $i++) {
            $valoresBlog[$i]['idevent'] = (int) $categorias[$i]['idevent'];
            $valoresBlog[$i]['name'] = $categorias[$i]['name'];
            $valoresBlog[$i]['description'] = $categorias[$i]['description'];
            $valoresBlog[$i]['location'] = $categorias[$i]['location'];
            $valoresBlog[$i]['dateEvent'] = $categorias[$i]['start'];
            $valoresBlog[$i]['picture'] = $categorias[$i]['picture'];
        }
        $response = $this->getResponseWithHeader()
                ->setContent(json_encode($valoresBlog));
        return $response;
    }

    public function create($data) {
        require './vendor/Utils/Core_Utils_Utils.php';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $datos = $this->request->getPost();
            $ruta = $this->_options->upload->images;
            $File = $this->params()->fromFiles('picture');
            if ($File['name'] != '') {
                $fecha = date("Y-m-d h:m:s");
                $info = pathinfo($File['name']);
                $ee = new \Core_Utils_Utils();
                $code = $ee->getRamdomChars(15, 'A');
                $name = $code . '.' . $info['extension'];
                $newName = $ruta . "/complaint/origin/" . $name;
                move_uploaded_file($File['tmp_name'], $newName);
            }
            $dat = array('latitude' => $datos['latitude'], 'longitude' => $datos['longitude'],
                'description' => $datos['description'], 'flagAct' => 1, 'picture' => $name, 'CreatingDate' => $fecha);
            $resultado = $this->getEventTable()->insertComplaint($dat);
            if ($resultado == true) {
                $mensaje = 'ok';
            } else {
                $mensaje = 'no se guardo el evento';
            }
        }
        $response = $this->getResponseWithHeader()
                ->setContent(json_encode(array('mensaje' => $mensaje)));
        return $response;
    }

    public function update($id, $data) {
        $response = $this->getResponseWithHeader()
                ->setContent(__METHOD__ . ' update current data with id =  ' . $id .
                ' with data of name is ' . $data['name']);
        return $response;
    }

    public function delete($id) {
        $response = $this->getResponseWithHeader()
                ->setContent(__METHOD__ . ' delete current data with id =  ' . $id);
        return $response;
    }

    // configure response
    public function getResponseWithHeader() {
        $response = $this->getResponse();
        $response->getHeaders()
                //make can accessed by *   
                ->addHeaderLine('Access-Control-Allow-Origin', '*')
                //set allow methods
                ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');

        return $response;
    }

    public function getEventTable() {
        if (!$this->eventTable) {
            $sm = $this->getServiceLocator();
            $this->eventTable = $sm->get('Event\Model\EventTable');
        }
        return $this->eventTable;
    }

    public function getComplaintTable() {
        if (!$this->complaintTable) {
            $sm = $this->getServiceLocator();
            $this->complaintTable = $sm->get('Event\Model\ComplaintTable');
        }
        return $this->complaintTable;
    }

}