<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\PHPooleTest;

use PHPoole\PHPoole;
use Symfony\Component\Filesystem\Filesystem;

class PHPooleBuildTest extends \PHPUnit_Framework_TestCase
{
    protected $wsSourceDir;
    protected $wsDestinationDir;

    public function setUp()
    {
        $this->wsSourceDir      = __DIR__ . '/fixtures/website';
        $this->wsDestinationDir = $this->wsSourceDir;
    }

    public function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove($this->wsDestinationDir . '/_site');
    }

    public function testBuid()
    {
        PHPoole::create(
            $this->wsSourceDir,
            null,
            [
                'site' => [
                    'menu' => [
                        'main' => [
                            'id'        => 'homepage',
                            'name'      => 'TEST',
                            'url'       => 'test',
                            'weight'    => -100,
                            'disabled'  => true,
                        ]
                    ]
                ],
            ]
        )->build();
    }
}