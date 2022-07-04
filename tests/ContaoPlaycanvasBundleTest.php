<?php

declare(strict_types=1);

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace DuncrowGmbh\ContaoPlaycanvasBundle\Tests;

use DuncrowGmbh\ContaoPlaycanvasBundle\ContaoPlaycanvasBundle;
use PHPUnit\Framework\TestCase;

class ContaoPlaycanvasBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoPlaycanvasBundle();

        $this->assertInstanceOf('DuncrowGmbh\ContaoPlaycanvasBundle\ContaoPlaycanvasBundle', $bundle);
    }
}
