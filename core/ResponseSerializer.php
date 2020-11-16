<?php


class ResponseSerializer
{
    public static function RaiseError($message,$code = 401)
    {
        // set response code
        http_response_code($code);
        header('Content-Type: application/json');

        // tell the user login failed
        echo json_encode(array("message" => $message));
    }

    public static function Send($obj)
    {
        http_response_code(200);
        header('Content-Type: application/json');

        echo json_encode(
            array(
                "message" => "ok",
                "results" => $obj
            )
        );
    }
}