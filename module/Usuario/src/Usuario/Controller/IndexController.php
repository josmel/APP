<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Json\Json;
use Usuario\Model\Usuario;
use SanAuth\Controller\AuthController;
use Zend\Session\Container;
use Usuario\Model\UsuarioTable;
use Usuario\Form\UsuarioForm;
use Usuario\Form\UsuarioPasswordForm;
use Zend\Form\Element;
use Zend\Validator\File\Size;
use Zend\Http\Header;
use Zend\Db\Sql\Sql;
use Zend\Mail\Message;


class IndexController extends AbstractActionController {

    protected $usuarioTable;
    protected $_options;
    protected $storage;
    protected $authservice;

    public function __construct() {
        $this->_options = new \Zend\Config\Config(include APPLICATION_PATH . '/config/autoload/global.php');
    }

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

    public function getSessionStorage() {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()->get('SanAuth\Model\MyAuthStorage');
        }
        return $this->storage;
    }

    public function editarusuarioAction() {

        $storage = new \Zend\Authentication\Storage\Session('Auth');
        $id = $storage->read()->iduser;
        if (!$id) {
            return $this->redirect()->toUrl('/auth');
        }
        try {
            $usuario = $this->getUsuarioTable()->getUsuario($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toUrl('/auth');
        }
        $form = new UsuarioForm();
        $form->bind($usuario);
        $form->get('submit')->setAttribute('value', 'Actualizar');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsuarioTable()->guardarUsuario($usuario);
                $mensaje = 'Sus datos han sido guardador correctamente.';
            } else {
                foreach ($form->getInputFilter()->getInvalidInput() as $error) {
                    print_r($error->getMessages());
                    print_r($error->getName());
                }
            }
        }
        return new ViewModel(array('form' => $form, 'message' => $mensaje))
        ;
    }

    public function updatepassAction() {
        $storage = new \Zend\Authentication\Storage\Session('Auth');
        $id = $storage->read()->iduser;
        if (!$id) {
            return $this->redirect()->toUrl('/auth');
        }
        try {
            $usuario = $this->getUsuarioTable()->getUsuario($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toUrl('/auth');
        }
        $form = new UsuarioPasswordForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->request->getPost();
            $pass = sha1($data['password']);
            $usuario = $this->getUsuarioTable()->getUserPass($id, $pass);
            if ($usuario == null) {
                $mensaje = 'Contraseña incorrecta.';
            } else {
                if ($data['passwordone'] == $data['passwordtwo']) {
                    $passnueva = sha1($data['passwordone']);
                    $resultado = $this->getUsuarioTable()->updatePassword($id, $passnueva);
                    if ($resultado == true) {
                        $mensaje = 'Contraseña guardada correctamente.';
                    } else {
                        $mensaje = 'No se pudo cambiar la Contraseña.';
                    }
                } else {
                    $mensaje = 'Las contraseñas nuevas deben ser  iguales.';
                }
            }
        }
        return new ViewModel(array('form' => $form, 'message' => $mensaje))
        ;
    }

    public function getUsuarioTable() {
        if (!$this->usuarioTable) {
            $sm = $this->getServiceLocator();
            $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
        }
        return $this->usuarioTable;
    }

}
