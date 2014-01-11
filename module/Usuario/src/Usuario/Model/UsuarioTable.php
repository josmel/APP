<?php

namespace Usuario\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Usuario\Controller\IndexController;

class UsuarioTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getUsuario($id) {
        $id = (int) $id;
        $row = $this->tableGateway->select(array(
            'iduser' => $id
        ));

        if (!$row) {
            throw new \Exception("No existe el Usuario cpn el id : $id");
        }
        return $row->current();
        ;
    }

    public function getUserPass($id, $pass) {
        $id = (int) $id;
        $row = $this->tableGateway->select(array(
            'iduser' => $id,
            'password' => $pass,
        ));

        if (!$row) {
            throw new \Exception("No existe el Usuario cpn el id : $id");
        }
        return $row->current();
        ;
    }

     public function updatePassword($id, $pass) {
        $update = $this->tableGateway->getSql()->update()->table('user')
                ->set(array('password'=>$pass))
                ->where(array('iduser' => $id));
        $selectStringUpdate = $this->tableGateway->getSql()->getSqlStringForSqlObject($update);
        $adapter = $this->tableGateway->getAdapter();
        $row = $adapter->query($selectStringUpdate, $adapter::QUERY_MODE_EXECUTE);
        if (!$row) {
            throw new \Exception("No se puede editar el usuario");
        }
        return true;
    }

    public function guardarUsuario(Usuario $usuario) {
        $fecha = date("Y-m-d h:m:s");
        $usuarioInsert = array(
            'userName' => $usuario->userName,
            'name' => $usuario->name,
            'lastName' => $usuario->lastName,
            'lastUpdate' => $fecha
        );
        $id = (int) $usuario->iduser;
        if ($id == 0) {
            $this->tableGateway->insert($usuarioInsert);
        } else {
            if ($this->getUsuario($id)) {
                $this->tableGateway->update($usuarioInsert, array('iduser' => $id));
            } else {
                throw new \Exception('El Usuario no existe');
            }
        }
    }

    public function usuario1($correo) {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $selecttot = $sql->select()->from('user')
                ->where(array('userName' => $correo));
        $selectString = $sql->getSqlStringForSqlObject($selecttot);
        $resultSet = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet->toArray();
    }

}
