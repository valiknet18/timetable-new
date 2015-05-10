<?hh

namespace Valiknet\Controller;

use Silex\Application;

abstract class AbstractController
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}