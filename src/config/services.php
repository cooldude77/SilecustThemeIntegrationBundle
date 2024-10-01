<?php


use Silecust\ThemeManagementBundle\Subscriber\BeforeTwigRenderSubscriber;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container
        ->services()
        ->set('theme.management.kernel_view.event_subscriber', BeforeTwigRenderSubscriber::class)
        ->arg('$themeTemplateBundleName', "")
        ->arg('$themeTemplatePath', "")
        ->arg('$environment', "")
        ->tag('kernel.event_subscriber');


};
