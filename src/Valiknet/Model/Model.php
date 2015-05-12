<?php

namespace Valiknet\Model;

use Symfony\Component\Yaml\Yaml;

class Model implements InterfaceModel
{
    protected $pdo;

    public function __construct()
    {
        $data = Yaml::parse(file_get_contents(__DIR__ . "/../../../app/config/config.yml"));

        $dsn = sprintf('pgsql:host=%s;dbname=%s', $data['database']['host'], $data['database']['database_name']);
        $this->pdo = new \PDO($dsn, $data['database']['username'], $data['database']['password']);
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->pdo->exec("SET CLIENT_ENCODING TO 'UTF8';");
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public static function getStaticPdo()
    {
        $model = new Model();

        return $model->getPdo();
    }

    public static function findOne($sql, array $parameters)
    {
        $findOne = self::getPdo()->prepare($sql);
        $result = $findOne->execute(array($parameters[0], $parameters[1]));

        return $result;
    }

    public static function find($sql, array $pair)
    {
        $find = self::getPdo()->prepare($sql);
        $result = $find->execute(array($pair[0], $pair[1]));

        return $result;
    }

    public static function exec($sql, array $parameters = [])
    {
        $query = self::getStaticPdo()->prepare($sql);
        $result = $query->execute($parameters);

        return $result;
    }
}
