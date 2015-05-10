<?hh

namespace Valiknet\Model;

interface InterfaceModel
{
    public static function findOne(string $sql, $pair);

    public static function find(string $sql, $pair);
}
