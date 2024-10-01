<?php

namespace Silecust\ThemeIntegrationBundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TwigCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        $definition = $container->getDefinition('theme.integration.kernel_view.event_subscriber');

        $definition
            ->setArgument('$themeTemplateBundleName', $container->getParameter('silecust.theme_integration.active_theme_bundle'))
            ->setArgument('$environment', new Reference('twig'))
            ->setArgument('$themeTemplatePath', $container->getParameter('silecust.theme_integration.theme_template_path'));

        $twigFilesystemLoaderDefinition = $container->getDefinition('twig.loader.native_filesystem');


        $path =
            $container->getParameter('silecust.theme_integration.theme_template_path');

        $twigFilesystemLoaderDefinition->addMethodCall('addPath',
            [$path, $container->getParameter('silecust.theme_integration.active_theme_bundle')]);

    }

}