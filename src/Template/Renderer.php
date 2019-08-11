<?php

namespace Ryvon\Plugin\Template;

class Renderer implements RendererInterface
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @param LocatorInterface $locator
     */
    public function __construct(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @return LocatorInterface
     */
    public function getLocator(): LocatorInterface
    {
        return $this->locator;
    }

    /**
     * @param string $templateFile The template file we are rendering
     * @param array $context
     * @return string|null
     */
    public function render(string $templateFile, array $context = []): ?string
    {
        $templatePath = $this->locator->locate($templateFile);
        if (!$templatePath) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                /** @noinspection ForgottenDebugOutputInspection */
                error_log(sprintf('Failed to locate template "%s"', $templateFile));
            }
            return null;
        }

        if (!is_readable($templatePath)) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                /** @noinspection ForgottenDebugOutputInspection */
                error_log(sprintf('Cannot read template "%s" at "%s"', $templateFile, $templatePath));
            }
            return null;
        }

        return $this->renderTemplate($templatePath, $context);
    }

    /**
     * @param string $templatePath
     * @param array $context
     * @return string
     */
    private function renderTemplate(string $templatePath, array $context = []): string
    {
        ob_start();
        extract($context, EXTR_OVERWRITE);
        /** @noinspection PhpIncludeInspection */
        require $templatePath;
        return ob_get_clean();
    }
}
