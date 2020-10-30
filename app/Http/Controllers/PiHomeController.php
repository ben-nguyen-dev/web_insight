<?php 

namespace App\Http\Controllers;


class PiHomeController extends Controller {
    public function home() {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        $file = $protocol . $_SERVER['SERVER_NAME'].'/bi/launch/';
        $file_headers = get_headers($file);
        if(!strpos($file_headers[0], '404')){
            return file_get_contents($file);
        }
    }

}