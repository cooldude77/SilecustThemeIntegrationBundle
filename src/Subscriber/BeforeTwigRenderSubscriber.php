<?php

namespace Silecust\ThemeManagementBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class BeforeTwigRenderSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly string      $themeTemplateBundleName,
        private readonly Environment $environment,
        private readonly string      $themeTemplatePath)
    {
    }

    public
    function onKernelView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();
        $fallback = $result['view_location'];

        $statusCode = $result['statusCode'] ??= 200;

        $path = "{$this->themeTemplatePath}/{$fallback}";

        $p = "@{$this->themeTemplateBundleName}/{$fallback}";

        if (file_exists($path))
            $response = new Response($this->environment->render($p, $result['parameters']), $statusCode);
        else
            $response = new Response($this->environment->render($fallback, $result['parameters'],$statusCode));

        $event->setResponse($response);

    }

    public
    static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
        ];
    }
}
