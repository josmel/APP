<?php

namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PlaceController extends AbstractRestfulController {

    protected $placeTable;

    public function getPlaceTable() {
        if (!$this->placeTable) {
            $sm = $this->getServiceLocator();
            $this->placeTable = $sm->get('Event\Model\PlaceTable');
        }
        return $this->placeTable;
    }

    public function get($lastUpdate) {
        $lastUpdate = $this->params()->fromQuery('lastUpdate', null);
        $categorias = $this->getPlaceTable()->place($lastUpdate);
        $valoresBlog[] = array();
        if ($categorias == null) {
            $valoresBlog = array('mensaje' => 'no existen datos');
        }
       for ($i = 0; $i < count($categorias); $i++) {
            $valoresBlog[$i]['idplace'] = (int) $categorias[$i]['idplace'];
            $valoresBlog[$i]['name'] = $categorias[$i]['name'];
            $valoresBlog[$i]['longitude'] = $categorias[$i]['longitude'];
            $valoresBlog[$i]['latitude'] = $categorias[$i]['latitude'];
            $valoresBlog[$i]['description'] = $categorias[$i]['description'];
            $valoresBlog[$i]['addrees'] = $categorias[$i]['addrees'];
        }
        $response = $this->getResponseWithHeader()
                ->setContent(json_encode($valoresBlog));
        return $response;
    }

    public function getList() {
        $categorias = $this->getPlaceTable()->placeFull();
        $valoresBlog[] = array();
        if ($categorias == null) {
            $valoresBlog = array('mensaje' => 'no existen datos');
        }
        for ($i = 0; $i < count($categorias); $i++) {
            $valoresBlog[$i]['idplace'] = (int) $categorias[$i]['idplace'];
            $valoresBlog[$i]['name'] = $categorias[$i]['name'];
            $valoresBlog[$i]['longitude'] = $categorias[$i]['longitude'];
            $valoresBlog[$i]['latitude'] = $categorias[$i]['latitude'];
            $valoresBlog[$i]['description'] = $categorias[$i]['description'];
            $valoresBlog[$i]['addrees'] = $categorias[$i]['addrees'];
        }
        $response = $this->getResponseWithHeader()
                ->setContent(json_encode($valoresBlog));
        return $response;
    }

    public function create($data) {
        $categorias = $this->getEventTable()->eventosFull();
        $response = $this->getResponseWithHeader()
                ->setContent(__METHOD__ . ' create new item of data :
                                                    <b>' . $data['name'] . '</b>');
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

}