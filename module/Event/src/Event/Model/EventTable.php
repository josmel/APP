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

    public function getEventosxFecha($start, $end) {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('event')
                ->where(array('start<=?' => $end, 'start>=?' => $start));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro evento");
        }
        $returnArray = array();
        foreach ($row as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }

    public function InsertEvento($data, $id = null) {

        if ($id == null) {
            $adapter = $this->tableGateway->getAdapter();
            $sql = new Sql($adapter);
            $insert = $sql->insert()->into('event')->values($data);
            $selectString = $sql->getSqlStringForSqlObject($insert);
            $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
            if (!$row) {
                throw new \Exception("No se guardo evento");
                return false;
            }
            return true;
        } else {
            $update = $this->tableGateway->getSql()->update()->table('event')
                    ->set($data)
                    ->where(array('idevent' => $id));
            $selectStringUpdate = $this->tableGateway->getSql()->getSqlStringForSqlObject($update);
            $adapter = $this->tableGateway->getAdapter();
            $row = $adapter->query($selectStringUpdate, $adapter::QUERY_MODE_EXECUTE);
            if (!$row) {
                throw new \Exception("No se puede editar el evento");
            }
            return true;
        }
    }

    public function InsertEventPicture($data) {
        $this->tableGateway->update($data, array(
            'idevent' => $id
        ));
    }

 
    
      public function eventos($update=null) {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('event')
                ->where(array('flagAct' => 1, 'lastUpdate>=?' => $update));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro evento");
        }
        $returnArray = array();
        foreach ($row as $result) {
            $returnArray[] = $result;
        }
        return $returnArray;
    }
    
    
    public function eventosFull() {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()
                ->from('event')
                ->where(array('flagAct' => 1));
        $selectString = $this->tableGateway->getSql()->getSqlStringForSqlObject($selecttot);
        $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se encontro evento");
        }
        $returnArray = array();
        foreach ($row as $result) {
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
         $adapter = $this->tableGateway->getAdapter();
            $sql = new Sql($adapter);
            $insert = $sql->insert()->into('complaint')->values($data);
            $selectString = $sql->getSqlStringForSqlObject($insert);
            $row = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
            if (!$row) {
                throw new \Exception("No se guardo la denuncia");
                return false;
            }
            return true;
    }

}

