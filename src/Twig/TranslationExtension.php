<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TranslationExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('renderTranslationField', [$this, 'renderTranslationField']),
        ];
    }

    public function renderTranslationField(object $object, string $fieldName)
    {
        $params = [
            'translations' => $object->getTranslations(),
            'fieldName' => $fieldName
        ];

        return $this->environment->render( "admin/common/translation_tabs.html.twig", $params);
    }
}