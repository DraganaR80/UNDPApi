<?php


class DB{

    private static $conn;
    public static function connectDB()
    {

        if (self::$conn == null)
            self::$conn = new mysqli('localhost', 'root', '', 'apibaza');
        return self::$conn;
            
        }
}





?>