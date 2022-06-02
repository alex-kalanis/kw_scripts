<?php

/// in bootstrap

$paths = new \kalanis\kw_paths\Path();
$paths->setDocumentRoot(realpath($_SERVER['DOCUMENT_ROOT']));
$paths->setPathToSystemRoot('/..');

/// ... other steps

// init scripts
\kalanis\kw_scripts\Scripts::init(new \kalanis\kw_scripts\Loaders\PhpLoader($paths));


//// Now class to access scripts itself

use kalanis\kw_mime\MimeType;
use kalanis\kw_extras\ExternalLink;
use kalanis\kw_scripts\Scripts as ExScripts;


/**
 * Class Scripts
 * Render scripts in page
 * Also can load and flush the whole wanted script file
 */
class Scripts
{
    /** @var MimeType */
    protected $mime = null;
    /** @var ScriptsTemplate */
    protected $template = null;
    /** @var ExternalLink */
    protected $libExtLink = '';
    /** @var string[] */
    protected $params = [];

    public function __construct($params = [])
    {
        $this->mime = new MimeType(true);
        $this->template = new ScriptsTemplate();
        $this->libExtLink = new ExternalLink();
        $this->params = $params;
    }

    public function flushLayout(): string
    {
        $content = [];
        foreach (ExScripts::getAll() as $module => $scripts) {
            foreach ($scripts as $script) {
                $content[] = $this->template->reset()->setData(
                    $this->libExtLink->linkVariant($module . '/' . $script, 'Scripts', true, false)
                )->render();
            }
        }
        return implode('', $content);
    }

    public function flushContent(): string
    {
        try {
            $content = ExScripts::getFile($this->params['module'], $this->params['path']);
            if ($content) {
                header("Content-Type: " . $this->mime->mimeByPath('any.js'));
            }
            return $content;
        } catch (\kalanis\kw_scripts\ScriptsException $ex) {
            return '';
        }
    }
}


/**
 * Class ScriptsTemplate
 * Template to render script element
 */
class ScriptsTemplate extends ATemplate
{
    protected $moduleName = 'Scripts';
    protected $templateName = 'template';

    protected function fillInputs(): void
    {
        $this->addInput('{SCRIPT_PATH}');
    }

    public function setData(string $path): self
    {
        $this->updateItem('{SCRIPT_PATH}', $path);
        return $this;
    }
}
