<?hh
/**
 * Created by PhpStorm.
 * User: valik-pc
 * Date: 10.05.15
 * Time: 2:33
 */

namespace Valiknet\Model;

class Event extends Model implements InterfaceObject
{
    public string $event_date_start;
    public string $event_date_end;
    public string $event_time_start;
    public string $event_time_end;
    public ?string $event_replace_date_start = null;
    public ?string $event_replace_date_end = null;
    public ?string $event_replace_time_start = null;
    public ?string $event_replace_time_end = null;
    public int $event_type;
    public string $repeat_type;
    public Teacher $teacher;
    public Subject $subject;
    public Auditory $auditory;
    public $groups = Vector {};

    public function save()
    {

    }

    public static function findBy($pair): Vector
    {

    }

    public static function findOneBy($pair): T
    {

    }

    public function create()
    {

    }

    public static function mappedObject(array $data): Event
    {

    }
}
