<?php

declare(strict_types=1);

/*
 * This file is part of the Structurizr for PHP.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StructurizrPHP\Tests\StructurizrPHP\Tests\Unit\Core\View;

use PHPUnit\Framework\TestCase;
use StructurizrPHP\StructurizrPHP\Core\View\Configuration;

final class ConfigurationTest extends TestCase
{
    public function test_hydrating_configuration()
    {
        $configuration = new Configuration();

        $this->assertEquals($configuration, Configuration::hydrate($configuration->toArray()));
    }
}
