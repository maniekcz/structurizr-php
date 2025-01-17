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

namespace StructurizrPHP\Tests\StructurizrPHP\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use StructurizrPHP\StructurizrPHP\Core\Model\Tags;
use StructurizrPHP\StructurizrPHP\Core\View\Configuration\Shape;
use StructurizrPHP\StructurizrPHP\Core\Workspace;

final class WorkspaceTest extends TestCase
{
    public function test_hydraing_workspace()
    {
        $workspace = new Workspace(
            "1",
            "name",
            "description"
        );

        $this->assertEquals($workspace, Workspace::hydrate($workspace->toArray("test")));
    }

    public function test_hydraing_with_relationships_and_views()
    {
        $workspace = new Workspace(
            "1",
            "name",
            "description"
        );

        $person = $workspace->getModel()->addPerson('person', 'test');
        $system = $workspace->getModel()->addSoftwareSystem('system2', 'test');

        $person->usesSoftwareSystem($system, 'uses', 'browser');

        $contextView = $workspace->getViews()->createSystemContextView($system, 'systemcontext', 'contextview', 'test');
        $contextView->addAllElements();

        $landscapeView = $workspace->getViews()->createSystemContextView($system, 'landscale', 'landscapeview', 'test');
        $landscapeView->addElement($person, true)->setY(100)->setX(200);

        $workspace->getViews()->getConfiguration()->getStyles()->addElementStyle(Tags::PERSON)
            ->shape(Shape::person());

        $this->assertEquals($workspace, Workspace::hydrate($workspace->toArray("test")));
    }
}
