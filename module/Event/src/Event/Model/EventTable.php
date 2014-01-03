<?php

namespace Event\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class EventTable {

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

    public function eventos() {
        $datos = $this->tableGateway->getAdapter()->query("SELECT * FROM event")->execute();
        $returnArray = array();
        foreach ($datos as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }

}

