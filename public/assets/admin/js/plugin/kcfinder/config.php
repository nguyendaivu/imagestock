<?php
/** This file is part of KCFinder project
  *
  *   @desc Base configuration file
  *   @package KCFinder
  *   @version 2.51
  *   @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  *   @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *   @link http://kcfinder.sunhater.com
  */


// IMPORTANT!!! Do not remove uncommented settings in this file even if

// you are using session configuration.

// See http://kcfinder.sunhater.com/install for setting descriptions

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

if (!defined('ROOT'))
    define('ROOT', dirname(dirname(dirname(__FILE__))));

$_CONFIG = array(
    'disabled'              => false,
    'denyZipDownload'       => false,
    'denyUpdateCheck'       => true,
    'denyExtensionRename'   => true,
    'theme'                 => 'oxygen',

    'uploadURL'             => '/assets/images',
    'uploadDir'             => ROOT.DS.'..'.DS.'..'.DS.'images'.DS,

    'dirPerms' => 0755,
    'filePerms' => 0644,

    'access' => array(
        'files' => array(
            'upload' => true,
            // 'delete' => true,
            'copy' => false,
            // 'move' => true,
            'rename' => false
        ),
        'dirs' => array(
            'create' => false,
            'delete' => false,
            'rename' => false
        )
    ),

    'deniedExts' => "exe com msi bat php phps phtml php3 php4 cgi js pl dll html",
    'types' => array(
        // CKEditor & FCKEditor types
        // 'files'   =>  "",
        // 'flash'   =>  "swf",
        'editor'     =>  "*img",
        

        // TinyMCE types
        // 'file'    =>  "",
        // 'media'   =>  "swf flv avi mpg mpeg qt mov wmv asf rm",
        // 'image'   =>  "*img",
    ),



    'filenameChangeChars' => array(
        ' ' => "_",
        ':' => "."
    ),

    'dirnameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'mime_magic' => "",

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,


    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'thumbsDir' => "thumbs",
    'jpegQuality' => 90,

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => md5(ROOT.'KCFINDER_'),



    // THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION CONFIGURATION

    '_check4htaccess' => true,
    //'_tinyMCEPath' => "/tiny_mce",


    '_sessionVar' => &$_SESSION['KCFINDER'],
    //'_sessionLifetime' => 30,
    //'_sessionDir' => "/full/directory/path",

    //'_sessionDomain' => ".mysite.com",
    //'_sessionPath' => "/my/path",
);

?>