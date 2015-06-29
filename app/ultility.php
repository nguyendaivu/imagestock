<?php
    defined('DS') || define('DS', DIRECTORY_SEPARATOR);
    defined('ARTISAN') || define('ARTISAN', app_path().DS.'..'.DS.'artisan');
    defined('PHAMTOM_CONVERT') || define('PHAMTOM_CONVERT', app_path().DS.'phantomjs'.DS.'phantomjs '.app_path().DS.'phantomjs'.DS.'rasterize.js');
    defined('CACHED_DIR') || define('CACHED_DIR', app_path().DS.'storage'.DS.'cache');
    defined('CACHED_VIEW') || define('CACHED_VIEW', app_path().DS.'storage'.DS.'views');
     //=================================================================================
    $info = getInfo();
    defined('URL') || define('URL', $info['url']);
    defined('DB_HOST') || define('DB_HOST', $info['db_host']);

    defined('PUSHER_APP_ID') || define('PUSHER_APP_ID', $info['pusher_api_id']);
    defined('PUSHER_KEY') || define('PUSHER_KEY', $info['pusher_key']);
    defined('PUSHER_SECRET') || define('PUSHER_SECRET', $info['pusher_secret']);
    //=================================================================================

    function pr($value) {
        echo    '<pre>';
        print_r($value);
        echo    '</pre>';
    }

    function getInfo($key = '') {
        $server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
        $arrInfo = [];
        $arrConfigs = [
            //Pusher cua Tung
            'image-stock.com'         => [
                                            'url'       => 'http://image-stock.com',
                                            'db_host'   => 'image-stock.com',
                                            'jt_db'     => 'jobtraq-demo.anvyonline.com',

                                            'pusher_api_id' => '102747',
                                            'pusher_key'    => '08025e712a12829abe94',
                                            'pusher_secret' => '56620386dd3816159b30',
                                        ],
            //Pusher cua Minh
            'image-stock.localhost'         => [
                                            'url'       => 'http://image-stock.localhost',
                                            'db_host'   => 'image-stock.localhost',

                                            'pusher_api_id' => '102747',
                                            'pusher_key'    => '08025e712a12829abe94',
                                            'pusher_secret' => '56620386dd3816159b30',
                                        ],

            //Pusher cua anh Vu
            'image-stock.anvyonline.com'    => [
                                            'url'       => 'http://image-stock.anvyonline.com',
                                            'db_host'   => 'image-stock.anvyonline.com',

                                            'pusher_api_id' => '117461',
                                            'pusher_key'    => 'd92f9b7a4493b5cd0638',
                                            'pusher_secret' => 'df184f38a14ff1d0b0b9',
                                        ],
            //Pusher cua anh Vu
            'vi2.anvyonline.com'    => [
                                            'url'       => 'http://vi2.anvyonline.com',
                                            'db_host'   => 'vi2.anvyonline.com',
                                            'jt_db'     => 'jobtraq-demo.anvyonline.com',
                                            'pusher_api_id' => '117461',
                                            'pusher_key'    => 'd92f9b7a4493b5cd0638',
                                            'pusher_secret' => 'df184f38a14ff1d0b0b9',
                                        ],
        ];
        if( php_sapi_name() === 'cli' ) {
            if( DS == '\\' ) {
                $arrInfo = $arrConfigs['image-stock.com'];
            } else {
                $arrInfo = $arrConfigs['vi2.anvyonline.com'];
            }
        } else {
            $arrInfo = $arrConfigs[$server_name];
        }

        if( in_array($server_name, ['image-stock.com', 'image-stock.localhost']) ) {
            Config::set('app.debug', true);
        } else {
            Config::set('app.debug', false);
        }
        if( !empty($key) && isset($arrInfo[$key]) ) {
            return $arrInfo[$key];
        }
        return $arrInfo;
    }

    function clearCached() {
        // clearProcess(CACHED_DIR);
        clearProcess(CACHED_VIEW);
    }

    function clearProcess($dir){
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if(in_array($object, array('.','..','.gitignore'))) continue;
                if (filetype($dir.DS.$object) == 'dir')
                    clearProcess($dir.DS.$object);
                else
                    unlink($dir.DS.$object);
            }
            unset($objects);
            @rmdir($dir);
        }
    }

    function getMimeType($ext) {
        $mimeType = [
            'ai' => 'application/postscript', 'bcpio' => 'application/x-bcpio', 'bin' => 'application/octet-stream',
            'ccad' => 'application/clariscad', 'cdf' => 'application/x-netcdf', 'class' => 'application/octet-stream',
            'cpio' => 'application/x-cpio', 'cpt' => 'application/mac-compactpro', 'csh' => 'application/x-csh',
            'csv' => 'application/csv', 'dcr' => 'application/x-director', 'dir' => 'application/x-director',
            'dms' => 'application/octet-stream', 'doc' => 'application/msword', 'drw' => 'application/drafting',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'one' => 'application/onenote',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'dvi' => 'application/x-dvi', 'dwg' => 'application/acad', 'dxf' => 'application/dxf',
            'dxr' => 'application/x-director', 'eot' => 'application/vnd.ms-fontobject', 'eps' => 'application/postscript',
            'exe' => 'application/octet-stream', 'ez' => 'application/andrew-inset',
            'flv' => 'video/x-flv', 'gtar' => 'application/x-gtar', 'gz' => 'application/x-gzip',
            'bz2' => 'application/x-bzip', '7z' => 'application/x-7z-compressed', 'hdf' => 'application/x-hdf',
            'hqx' => 'application/mac-binhex40', 'ico' => 'image/vnd.microsoft.icon', 'ips' => 'application/x-ipscript',
            'ipx' => 'application/x-ipix', 'js' => 'application/x-javascript', 'latex' => 'application/x-latex',
            'lha' => 'application/octet-stream', 'lsp' => 'application/x-lisp', 'lzh' => 'application/octet-stream',
            'man' => 'application/x-troff-man', 'me' => 'application/x-troff-me', 'mif' => 'application/vnd.mif',
            'ms' => 'application/x-troff-ms', 'nc' => 'application/x-netcdf', 'oda' => 'application/oda',
            'otf' => 'font/otf', 'pdf' => 'application/pdf',
            'pgn' => 'application/x-chess-pgn', 'pot' => 'application/mspowerpoint', 'pps' => 'application/mspowerpoint',
            'ppt' => 'application/mspowerpoint', 'ppz' => 'application/mspowerpoint', 'pre' => 'application/x-freelance',
            'prt' => 'application/pro_eng', 'ps' => 'application/postscript', 'roff' => 'application/x-troff',
            'scm' => 'application/x-lotusscreencam', 'set' => 'application/set', 'sh' => 'application/x-sh',
            'shar' => 'application/x-shar', 'sit' => 'application/x-stuffit', 'skd' => 'application/x-koan',
            'skm' => 'application/x-koan', 'skp' => 'application/x-koan', 'skt' => 'application/x-koan',
            'smi' => 'application/smil', 'smil' => 'application/smil', 'sol' => 'application/solids',
            'spl' => 'application/x-futuresplash', 'src' => 'application/x-wais-source', 'step' => 'application/STEP',
            'stl' => 'application/SLA', 'stp' => 'application/STEP', 'sv4cpio' => 'application/x-sv4cpio',
            'sv4crc' => 'application/x-sv4crc', 'svg' => 'image/svg+xml', 'svgz' => 'image/svg+xml',
            'swf' => 'application/x-shockwave-flash', 't' => 'application/x-troff',
            'tar' => 'application/x-tar', 'tcl' => 'application/x-tcl', 'tex' => 'application/x-tex',
            'texi' => 'application/x-texinfo', 'texinfo' => 'application/x-texinfo', 'tr' => 'application/x-troff',
            'tsp' => 'application/dsptype', 'ttf' => 'font/ttf',
            'unv' => 'application/i-deas', 'ustar' => 'application/x-ustar',
            'vcd' => 'application/x-cdlink', 'vda' => 'application/vda', 'xlc' => 'application/vnd.ms-excel',
            'xll' => 'application/vnd.ms-excel', 'xlm' => 'application/vnd.ms-excel', 'xls' => 'application/vnd.ms-excel',
            'xlw' => 'application/vnd.ms-excel', 'zip' => 'application/zip', 'aif' => 'audio/x-aiff', 'aifc' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff', 'au' => 'audio/basic', 'kar' => 'audio/midi', 'mid' => 'audio/midi',
            'midi' => 'audio/midi', 'mp2' => 'audio/mpeg', 'mp3' => 'audio/mpeg', 'mpga' => 'audio/mpeg',
            'ra' => 'audio/x-realaudio', 'ram' => 'audio/x-pn-realaudio', 'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin', 'snd' => 'audio/basic', 'tsi' => 'audio/TSP-audio', 'wav' => 'audio/x-wav',
            'asc' => 'text/plain', 'c' => 'text/plain', 'cc' => 'text/plain', 'css' => 'text/css', 'etx' => 'text/x-setext',
            'f' => 'text/plain', 'f90' => 'text/plain', 'h' => 'text/plain', 'hh' => 'text/plain', 'htm' => 'text/html',
            'html' => 'text/html', 'm' => 'text/plain', 'rtf' => 'text/rtf', 'rtx' => 'text/richtext', 'sgm' => 'text/sgml',
            'sgml' => 'text/sgml', 'tsv' => 'text/tab-separated-values', 'tpl' => 'text/template', 'txt' => 'text/plain',
            'xml' => 'text/xml', 'avi' => 'video/x-msvideo', 'fli' => 'video/x-fli', 'mov' => 'video/quicktime',
            'movie' => 'video/x-sgi-movie', 'mpe' => 'video/mpeg', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg',
            'qt' => 'video/quicktime', 'viv' => 'video/vnd.vivo', 'vivo' => 'video/vnd.vivo', 'gif' => 'image/gif',
            'ief' => 'image/ief', 'jpe' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg',
            'pbm' => 'image/x-portable-bitmap', 'pgm' => 'image/x-portable-graymap', 'png' => 'image/png',
            'pnm' => 'image/x-portable-anymap', 'ppm' => 'image/x-portable-pixmap', 'ras' => 'image/cmu-raster',
            'rgb' => 'image/x-rgb', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'xbm' => 'image/x-xbitmap',
            'xpm' => 'image/x-xpixmap', 'xwd' => 'image/x-xwindowdump', 'ice' => 'x-conference/x-cooltalk',
            'iges' => 'model/iges', 'igs' => 'model/iges', 'mesh' => 'model/mesh', 'msh' => 'model/mesh',
            'silo' => 'model/mesh', 'vrml' => 'model/vrml', 'wrl' => 'model/vrml',
            'mime' => 'www/mime', 'pdb' => 'chemical/x-pdb', 'xyz' => 'chemical/x-pdb'];
        return isset($mimeType[$ext]) ? $mimeType[$ext] : 'text/plain';
    }

    function showQuery($last = false)
    {
        $queries = DB::getQueryLog();
        if( $last )
            pr( end($queries) );
        else
            pr( $queries );
    }

    function human_filesize($bytes, $decimals = 2) {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .' '. @$size[$factor];
    }