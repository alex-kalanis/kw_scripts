<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Path;
use kalanis\kw_scripts\Interfaces\ILoader;
use kalanis\kw_scripts\Loaders\PhpLoader;
use kalanis\kw_scripts\Scripts;
use kalanis\kw_scripts\ScriptsException;


class ScriptsTest extends CommonTestClass
{
    /**
     * @throws ScriptsException
     */
    public function testLoaderException(): void
    {
        $loader = new PhpLoader();
        $this->expectException(ScriptsException::class);
        $loader->load('dummy', 'file');
    }

    /**
     * @throws ScriptsException
     */
    public function testGetVirtualFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Scripts::init($path);
        Scripts::reset($path, new XLoader());
        $this->assertEquals('abcmnodefpqrghistujklvwx%syz0123%s456', Scripts::getFile('abc', 'def'));
    }

    /**
     * @throws ScriptsException
     */
    public function testGetRealFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        Scripts::reset($path);
        $this->assertEquals('// dummy script file', Scripts::getFile('dummy', 'dummyScript.js'));
    }

    /**
     * @throws ScriptsException
     */
    public function testGetNoFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        Scripts::reset($path);
        $this->assertEquals('', Scripts::getFile('dummy', '**really-not-existing'));
    }

    public function testWant(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Scripts::init($path);

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
}


class XLoader implements ILoader
{
    public function load(string $module, string $path = ''): string
    {
        return 'abcmnodefpqrghistujklvwx%syz0123%s456';
    }
}
