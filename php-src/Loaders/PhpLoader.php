<?php

namespace kalanis\kw_scripts\Loaders;


use kalanis\kw_paths\Interfaces\IPaths;
use kalanis\kw_paths\Path;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_scripts\Interfaces\ILoader;


/**
 * Class PhpLoader
 * @package kalanis\kw_scripts\Loaders
 * Load scripts from predefined paths
 */
class PhpLoader implements ILoader
{
    /** @var string[] */
    protected array $pathMasks = [
        '%2$s%1$s%3$s%1$s%4$s%1$s%5$s%1$s%6$s%1$s%7$s%1$s%8$s', # user dir, user module with conf name
        '%2$s%1$s%3$s%1$s%4$s%1$s%5$s%1$s%6$s%1$s%7$s%1$s%7$s', # user dir, user module
        '%2$s%1$s%3$s%1$s%4$s%1$s%5$s%1$s%6$s%1$s%7$s', # user dir, all user confs
        '%2$s%1$s%3$s%1$s%4$s%1$s%5$s%1$s%6$s', # user dir, conf named by module
        '%2$s%1$s%5$s%1$s%6$s%1$s%7$s%1$s%8$s', # all modules, main script with name
        '%2$s%1$s%5$s%1$s%6$s%1$s%7$s%1$s%7$s', # all modules, default main script
        '%2$s%1$s%5$s%1$s%6$s%1$s%7$s', # all modules, scripts in root
    ];

    protected Path $pathLib;
    protected RoutedPath $routedLib;

    public function __construct(Path $pathLib, RoutedPath $routedLib)
    {
        $this->pathLib = $pathLib;
        $this->routedLib = $routedLib;
    }

    public function load(string $module, string $wantedPath = ''): string
    {
        $includingPath = $this->contentPath($module, $wantedPath);
        return (!empty($includingPath)) ? $this->includedScript($includingPath) : '';
    }

    public function contentPath(string $module, string $conf = ''): ?string
    {
        $basicLookupDir = $this->pathLib->getDocumentRoot() . $this->pathLib->getPathToSystemRoot();
        foreach ($this->pathMasks as $pathMask) {
            $unmasked = sprintf( $pathMask,
                DIRECTORY_SEPARATOR, $basicLookupDir,
                IPaths::DIR_USER, $this->routedLib->getUser(),
                IPaths::DIR_MODULE, $module,
                IPaths::DIR_STYLE, $conf
            );
            $path = realpath($unmasked);
            if ($path && is_file($path)) {
                return $path;
            }
        }
        return null;
    }

    protected function includedScript(string $path): string
    {
        return (string) @file_get_contents($path);
    }
}
