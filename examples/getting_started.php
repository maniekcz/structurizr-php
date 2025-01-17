<?php

/*
 * This file is part of the Structurizr for PHP.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use StructurizrPHP\StructurizrPHP\Core\Model\Enterprise;
use StructurizrPHP\StructurizrPHP\Core\Model\Location;
use StructurizrPHP\StructurizrPHP\Core\Model\Properties;
use StructurizrPHP\StructurizrPHP\Core\Model\Property;
use StructurizrPHP\StructurizrPHP\Core\Model\Tags;
use StructurizrPHP\StructurizrPHP\Core\View\Configuration\Shape;
use StructurizrPHP\StructurizrPHP\Core\Workspace;
use StructurizrPHP\StructurizrPHP\Infrastructure\Http\SymfonyRequestFactory;
use StructurizrPHP\StructurizrPHP\SDK\Client;
use StructurizrPHP\StructurizrPHP\SDK\Credentials;
use StructurizrPHP\StructurizrPHP\SDK\UrlMap;
use Symfony\Component\HttpClient\Psr18Client;

require __DIR__ . '/../vendor/autoload.php';

$workspace = new Workspace(
    $id = (string)\getenv('STRUCTURIZR_WORKSPACE_ID'),
    $name = 'Getting Started',
    $description = 'This is a model of my software system. by structurizr-php/structurizr-php'
);
$workspace->getModel()->setEnterprise(new Enterprise('Structurizr PHP'));
$person = $workspace->getModel()->addPerson(
    $name = 'User',
    $description = 'A user of my software system.',
    Location::internal()
);
$softwareSystem = $workspace->getModel()->addSoftwareSystem(
    $name = 'Software System',
    $description = 'My software system.',
    Location::internal()
);
$person->usesSoftwareSystem($softwareSystem, 'Uses', 'Http');

$contextView = $workspace->getViews()->createSystemContextView($softwareSystem, 'System Context', 'system01', 'An example of a System Context diagram.');
$contextView->addAllElements();
$contextView->setAutomaticLayout(true);

$styles = $workspace->getViews()->getConfiguration()->getStyles();

$styles->addElementStyle(Tags::SOFTWARE_SYSTEM)->background("#1168bd")->color('#ffffff');
$styles->addElementStyle(Tags::PERSON)->background("#08427b")->color('#ffffff')->shape(Shape::person());

$client = new Client(
    new Credentials((string) \getenv('STRUCTURIZR_API_KEY'), (string) \getenv('STRUCTURIZR_API_SECRET')),
    new UrlMap('https://api.structurizr.com'),
    new Psr18Client(),
    new SymfonyRequestFactory(),
);
$client->put($workspace);
