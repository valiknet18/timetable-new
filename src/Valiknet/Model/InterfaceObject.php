<?hh

namespace Valiknet\Model;

interface InterfaceObject
{
    public function save();

    public static function findBy($pair): T;

    public static function findOneBy($pair): T;

    public function create();

    public static function mappedObject(array $attributes): T;
}
