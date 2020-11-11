<?php


class ResponseSerializer
{
    public static function RaiseError($message,$code = 401)
    {
        // set response code
        http_response_code($code);

        // tell the user login failed
        echo json_encode(array("message" => $message));
    }

    public static function Send($obj)
    {
        http_response_code(200);

        echo json_encode(
            array(
                "message" => "ok",
                "results" => $obj
            )
        );
    }
}