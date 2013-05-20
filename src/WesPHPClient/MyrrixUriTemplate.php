<?php

namespace WesPHPClient;

use Guzzle\Parser\UriTemplate\UriTemplateInterface;

/**
 * Hack the original UriTemplate class to provide adapted parsing for the Myrrix uris
 */
class MyrrixUriTemplate implements UriTemplateInterface
{
    /**
     * @var UriTemplateInterface
     */
    protected $uriTemplate;

    function __construct(UriTemplateInterface $uriTemplate)
    {
        $this->uriTemplate = $uriTemplate;
    }

    public function expand($template, array $variables)
    {
        if ($template == '/entitysuggester/suggest{/properties*}') {
            $result = '/entitysuggester/suggest';
            foreach ($variables['properties'] as $key => $variable) {
                $result .= sprintf('/%d=%f', $key, $variable);
            }
            return $result;
        }

        return $this->uriTemplate->expand($template, $variables);
    }
}
