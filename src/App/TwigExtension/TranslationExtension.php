<?php


namespace App\TwigExtension;


use Symfony\Bridge\Twig\Extension\TranslationExtension as SymfonyTranslationExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TranslationExtension extends AbstractExtension
{
    private $parentExtension;

    public function __construct(SymfonyTranslationExtension $symfonyTransExtension) {
        $this->parentExtension = $symfonyTransExtension;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('trans', [$this, 'trans'], ['needs_context' => true]),
        ];
    }

    public function trans($context, $message, array $arguments = [], $domain = null, $locale = null, $count = null)
    {
        return $this->parentExtension->trans($message, $arguments, $domain, $locale ?: $context['lang'], $count);
    }
}
