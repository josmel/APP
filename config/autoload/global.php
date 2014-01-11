    <?php

    /**
     * Global Configuration Override
     *
     * You can use this file for overriding configuration values from modules, etc.
     * You would place values in here that are agnostic to the environment and not
     * sensitive to security.
     *
     * @NOTE: In practice, this file will typically be INCLUDED in your source
     * control, so do not include passwords or other sensitive information in this
     * file.
     */
    return array(
        'db' => array(
            'driver' => 'Pdo',
            'username' => 'root',
            'password' => '123456',
            'dsn' => 'mysql:dbname=osp_molina;host=localhost',
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            )
        ),
        'upload' => array(
            'images' => APPLICATION_PATH . '/public/dinamic',
        ),

        'host' => array(
            'rootImgDinamic' => 'http://local.molina/dinamic',
            'base' => 'http://local.molina',
            'static' => 'http://local.molina',
            'images' => 'http://local.molina/imagenes',
            'img'=>'http://local.molina/img',
            'ruta' => 'http://local.molina',
            'version'=>1,
        ),
        
        'Picture' => array(
            'heightone' => 1080,
            'widthone' => 720,
            'heighttwo' => 720,
            'widthtwo' => 480,
            'heightthree'=>540,
            'widththree' => 360,
            'heightfour'=>360,
            'widthfour'=>240,
        ),

        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
            'aliases' => array(
                'translator' => 'MvcTranslator',
            ),
        ),

        'module_layouts' => array(
//         'Application' => 'layout/layout-portada',
         
        'SanAuth' => array(
            'default'=> 'layout/layout-login',
            'auth' => 'layout/layout-login'
        )
   )
  
    );
