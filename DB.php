<?php
class DB
{
    private static function connect()
    {
        $pdo = new PDO('mysql:host=mars.iuk.hdm-stuttgart.de;dbname=u-ch126;charset=utf8', 'ch126', 'OhK5aepair');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array())
    {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        // $data = $statement->fetchAll();
        // return $data;
    }
}
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 07.07.17
 * Time: 20:27
 */