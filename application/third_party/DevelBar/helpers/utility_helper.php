<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if (!function_exists('image_base64_encode')) {
    function image_base64_encode($image)
    {
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('check_for_new_version')) {
    function check_for_new_version()
    {
        $url = config_item('ci_update_uri');
        if(!$ci_version = file_get_contents($url))
            return FALSE;

        $ci_version = htmlentities($ci_version);

        preg_match("/CI_VERSION',\s'(.*)'\)/", $ci_version, $matches);

        if(count($matches) && version_compare($matches[1], CI_VERSION, '>'))
            return $matches[1];
    }
}