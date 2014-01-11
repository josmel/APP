<?php
namespace Event\View\Helper;

use \Zend\View\Helper;
use \Zend\Form\View\Helper\AbstractHelper;
class Picture extends AbstractHelper
{
    public function setReservation($nombre,$one,$two)
    {
                if(isset($one)) { 
                    $resize = new Core_Utils_ResizeImage(
                            ROOT_IMG_DINAMIC.'/reservation/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $one['heigth'],$one['width'], 
                            'exact'
                        );
                 $destinyFolder = ROOT_IMG_DINAMIC.'/reservation/'.$one['heigth'].'x'.$one['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);
//                 if($picture!==null){unlink($destinyFolder.'/'.$picture);
//                 }
                 }
                 if(isset($two)) { 
                    $resize = new Core_Utils_ResizeImage(
                            ROOT_IMG_DINAMIC.'/reservation/origin/'.$nombre
                        );
                    $resize->resizeImage(
                            $two['heigth'],$two['width'], 
                            'exact'
                        );
                    $destinyFolder = ROOT_IMG_DINAMIC.'/reservation/'.$two['heigth'].'x'.$two['width'];
                    if(!file_exists($destinyFolder))
                        mkdir($destinyFolder, 0777, true);
                    $resize->saveImage($destinyFolder.'/'.$nombre);
//                     if($picture!==null){unlink($destinyFolder.'/'.$picture);
//                     }
                 }
                
    }
}