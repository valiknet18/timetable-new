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

    public static function findOne($sql, $parameter = null)
    {
        $findOne = self::getStaticPdo()->prepare($sql);
        $findOne->execute(array($parameter));

        return $findOne->fetch();
    }

    public static function find($sql, $pair = null)
    {
        if ($pair) {
            $find = self::getStaticPdo()->prepare($sql);
            $find->execute(array($pair));
        } else {
            $find = self::getStaticPdo()->prepare($sql);
            $find->execute();
        }

        return $find->fetchAll();
    }

    public static function exec($sql, array $parameters = [])
    {
        $query = self::getStaticPdo()->prepare($sql);
        $result = $query->execute($parameters);

        return $result;
    }

    public function mappedObject(array $data, $depth = 0)
    {
        $reflection = new \ReflectionClass(get_class($this));

        foreach ($reflection->getProperties() as $property) {
            $doc_block = $property->getDocComment();

            preg_match_all('#@typeProperty\(\'(.*?)\'\)\n#s', $doc_block, $annotations);

            if ($annotations[1]) {
                switch ($annotations[1][0]) {
                    case "property":
                        preg_match_all('#@key\((.*?)\)\n#s', $doc_block, $key);

                        $property->setValue($this, $data[$property->getName()]);
                        break;

                    case "arrayOfObjects":
                        if ($depth < 2) {
                            preg_match_all('#@typeObject\(\'(.*?)\'\)\n#s', $doc_block, $nameObject);

                            $objectData = $this->{$property->getName()}();

                            if ($nameObject[1]) {
                                $property->setValue($this, $this->generateArraysOfObjects($nameObject[1][0], $objectData, $depth + 1));
                            }
                        }
                        break;

                    case "object":
                        if ($depth < 2) {
                            preg_match_all('#@typeObject\(\'(.*?)\'\)\n#s', $doc_block, $nameObject);
                            preg_match_all('#@nameForeignKey\(\'(.*?)\'\)\n#s', $doc_block, $foreignKey);

                            $objectData = $this->{$property->getName()}($data[$foreignKey[1][0]]);

                            $object = new $nameObject[1][0]();

                            if ($objectData) {
                                $object->mappedObject($objectData, $depth + 1);
                            }

                            $property->setValue($this, $object);
                        }
                        break;
                }
            }
        }
    }

    private function generateArraysOfObjects($nameClass, $data, $depth) {

        $objects = [];

        foreach ($data as $element) {
            $object = new $nameClass();
            $object->mappedObject($element, $depth);

            $objects[] = $object;
        }

        return $objects;
    }
}
