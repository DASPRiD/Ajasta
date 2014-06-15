<?php
namespace Ajasta\Core;

use Locale;
use RuntimeException;
use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    public function onBootstrap(EventInterface $event)
    {
        if (!$event instanceof MvcEvent) {
            throw new RuntimeException(sprintf(
                'Listener expects MvcEvent, got %s',
                get_class($event)
            ));
        }

        // Hard-coded until later
        Locale::setDefault('en-US');

        // There's no configuration way to handle this right now…
        $formElementHelper =  $event
            ->getApplication()
            ->getServiceManager()
            ->get('ViewHelperManager')
            ->get('form_element');

        $formElementHelper
            ->addClass('Ajasta\Core\Form\Element\DatePicker', 'Ajasta\Core\Form\View\Helper\FormDatePicker')
            ->addClass('Ajasta\Core\Form\Element\Toggle', 'Ajasta\Core\Form\View\Helper\FormToggle');

        // Automatically redirect trailing slash requests
        $event
            ->getApplication()
            ->getEventManager()
            ->attach(
                MvcEvent::EVENT_ROUTE,
                function (MvcEvent $event) {
                    $request = $event->getRequest();

                    if ($request instanceof HttpRequest) {
                        $requestPath = substr($request->getUri()->getPath(), strlen($request->getBasePath()));

                        if (preg_match('(./$)', $requestPath)) {
                            $response = new HttpResponse();
                            $response->setStatusCode(HttpResponse::STATUS_CODE_301);
                            $response->getHeaders()->addHeaderLine('Location', rtrim($requestPath, '/'));
                            return $response;
                        }
                    }
                },
                5000
            );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
