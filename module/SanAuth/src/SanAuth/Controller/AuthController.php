<?php

namespace SanAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use SanAuth\Form\UserForm;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Mail\Message;
use Usuario\Model\Usuario;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController {

    protected $form;
    protected $storage;
    protected $authservice;
    protected $usuarioTable;

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

    public function getForm() {
        if (!$this->form) {
            $this->form = new \SanAuth\Form\UserForm(); // $builder->createForm($user);
        }

        return $this->form;
    }

    public function loginAction() {
  
        $view = new ViewModel();
        $this->layout('layout/layout-login');
              $this->layout()->module = 'SanAuth';
        $this->layout()->controller = 'Auth';
        $this->layout()->action = 'login';
        $renderer = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface');
        $renderer->inlineScript()
                ->prependFile($this->_options->host->base . '/js/main.js');

        $storage = new \Zend\Authentication\Storage\Session('Auth');
        // $session = $storage->read();
        $form = $this->getForm();
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            $mensajes = $flashMessenger->getMessages();
        }


        $view->setVariables(array(
            'form' => $form,
            'mensaje' => $mensaje,
            'messages' => $mensajes//$this->flashmessenger()->getMessages()
        ));
        return $view;
    }

    public function authenticateAction() {
        
        $form = $this->getForm();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {
                $correo = $request->getPost('userName');
                $contrasena = $request->getPost('password');
//                var_dump($contrasena);
//                var_dump($correo);exit;
                $this->getAuthService()
                        ->getAdapter()
                        ->setIdentity($correo)
                        ->setCredential($contrasena);


                $result = $this->getAuthService()->authenticate();
                foreach ($result->getMessages() as $message) {
                    if ($message) {
                        $this->flashmessenger()->addMessage('Usuario ó contraseña incorrecto');
                    }
                }
                if ($result->isValid()) {
                    $usuario = $this->getUsuarioTable()->usuario1($correo);
                    if ($usuario[0]['flagAct'] == '1') {

                        $storage = $this->getAuthService()->getStorage();
                        $storage->write($this->getServiceLocator()
                                        ->get('TableAuthService')
                                        ->getResultRowObject(array(
                                            'iduser',
                                            'userName',
                                            'name',
                                            'flagAct'
                        )));

                        return $this->redirect()->toUrl('/');
                    } else {

                        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/auth');
                    }
                } else {

                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/auth');
                }
            } else {
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/auth');
            }
        }
    }

    public function logoutAction() {
        session_destroy();
        if ($this->getAuthService()->hasIdentity()) {
            $this->getSessionStorage()->forgetMe();
            $this->getAuthService()->clearIdentity();
        } return $this->redirect()->toUrl('/');
    }

 
    public function getUsuarioTable() {
        if (!$this->usuarioTable) {
            $sm = $this->getServiceLocator();
            $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
        }
        return $this->usuarioTable;
    }

}