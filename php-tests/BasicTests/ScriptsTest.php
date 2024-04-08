<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources as routeSource;
use kalanis\kw_scripts\Interfaces\ILoader;
use kalanis\kw_scripts\Loaders\MultiLoader;
use kalanis\kw_scripts\Loaders\PhpLoader;
use kalanis\kw_scripts\Scripts;
use kalanis\kw_scripts\ScriptsException;


class ScriptsTest extends CommonTestClass
{
    /**
     * @throws ScriptsException
     */
    public function testGetVirtualFile(): void
    {
        Scripts::init(new XLoader());
        $this->assertEquals('abcmnodefpqrghistujklvwx%syz0123%s456', Scripts::getFile('abc', 'def'));
    }

    /**
     * @throws ScriptsException
     */
    public function testNoLoader(): void
    {
        Scripts::init(null);
        $this->expectException(ScriptsException::class);
        Scripts::getFile('anything', 'will die');
    }

    /**
     * @throws PathsException
     * @throws ScriptsException
     */
    public function testGetRealFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Scripts::init(new PhpLoader($path, $routed));
        $this->assertEquals('// dummy script file', Scripts::getFile('dummy', 'dummyScript.js'));
    }

    /**
     * @throws PathsException
     * @throws ScriptsException
     */
    public function testGetNoFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Scripts::init(new PhpLoader($path, $routed));
        $this->assertEquals('', Scripts::getFile('dummy', '**really-not-existing'));
    }

    /**
     * @throws PathsException
     */
    public function testWant(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Scripts::init(new PhpLoader($path, $routed));

        Scripts::want('foo', 'abc');
        Scripts::want('foo', 'def');
        Scripts::want('bar', 'ghi');
        Scripts::want('baz', 'jkl');
        $this->assertEquals([
            'foo' => ['abc', 'def', ],
            'bar' => ['ghi', ],
            'baz' => ['jkl', ],
        ], Scripts::getAll());
    }

    /**
     * @throws ScriptsException
     */
    public function testMulti(): void
    {
        $lib = new MultiLoader();
        $this->assertEmpty($lib->load('dummy', '**really-not-known'));
        $lib->addLoader(new XYLoader());
        $this->assertEquals('abc%smnodefpqrghistujklvwxyz%s0123456', $lib->load('anything dummy', 'def'));
    }
}


class XLoader implements ILoader
{
    public function load(string $module, string $path = ''): string
    {
        return 'abcmnodefpqrghistujklvwx%syz0123%s456';
    }
}


class XYLoader implements ILoader
{
    public function load(string $module, string $path = ''): ?string
    {
        return 'abc%smnodefpqrghistujklvwxyz%s0123456';
    }
}
