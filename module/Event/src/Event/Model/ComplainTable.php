<?php

namespace Event\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class ComplaintTable {

    protected $tableGateway;
  
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getEvent($id) {
        //$id  = (int) $id;
        $row = $this->tableGateway->select(array('idevent' => $id));
        $row = $row->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function complaint($update=null) {
        $datos = $this->tableGateway->getAdapter()->query("SELECT * FROM  complaint where creatingDate >= '$update' ")->execute();
        foreach ($datos as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }
    
   public function complaintFull() {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('complaint')
                ->where(array('flagAct' => 1));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro denuncia");
        }
        $returnArray = array();
        foreach ($row as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }


    
       public function insertComplaint($data) {
                      var_dump($data);exit;
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    
    
    
}

