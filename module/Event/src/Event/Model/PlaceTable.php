<?php

namespace Event\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class PlaceTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

 

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function place($update=null) {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('place')
                ->where(array('flagAct' => 1, 'lastUpdate>=?' => $update));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro lugares");
        }
        $returnArray = array();
        foreach ($row as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }
    
    public function placeFull() {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('place')
                ->where(array('flagAct' => 1));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro lugares");
        }
        $returnArray = array();
        foreach ($row as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }


}

