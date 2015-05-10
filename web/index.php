<?hh

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__.'/../app/app.php';
require_once __DIR__.'/../app/config/routing.php';

$app['config'] = Yaml::parse(file_get_contents('../app/config/config.yml'));

$request = Request::createFromGlobals();
$app->run($request);