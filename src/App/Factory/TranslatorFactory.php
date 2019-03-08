<?php


namespace App\Factory;


use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class TranslatorFactory
{

    public function __invoke(ContainerInterface $container): Translator
    {
        $config = $container->get('config');
        $translator = new Translator($config['default_locale'] ?? 'en');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'Hello' => '你好',
            'Docs' => '文档',
            'Welcome to' => '欢迎使用',
        ], 'zh-CN');

        return $translator;
    }
}