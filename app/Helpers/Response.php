<?php

class Response
{
    public static function json($data, $errno = 0, $errmsg = '')
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode(array('data' => $data, 'errno' => $errno, 'errmsg' => $errmsg));
        exit;
    }
}

?>