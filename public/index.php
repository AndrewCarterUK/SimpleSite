<?php

// Change the directory to the parent directory
chdir(__DIR__ . '/..');

/*
 * This gives us access to all the packages we installed via composer (and also
 * our own code as we use composer to set up the namespaces).
 * 
 * Check out more information here:
 * https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require_once 'vendor/autoload.php';

/*
 * Declare all the classes that we are going to use. Some of these are from
 * packages installed by composer and one is from our own app.
 * 
 * There's no particular order required, but I like doing them in alphabetical.
 */
use League\Plates\Engine;
use SimpleSite\SiteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/*
 * This line uses the Request class from the symfony/http-foundation package to
 * create a request object from the global variables ($_GET, $_POST, ...).
 * 
 * Check out more information here:
 * http://symfony.com/doc/current/components/http_foundation/introduction.html
 */
$request = Request::createFromGlobals();

/*
 * Here we set up the templating engine that we're going to use to render our
 * templates.
 * 
 * Check out more information here:
 * http://platesphp.com/engine/
 */
$templatingEngine = new Engine();
$templatingEngine->addFolder('site', 'templates/site');

/*
 * Here we create an object using our controller class at src\SiteController.php.
 * 
 * The full path for this class is SimpleSite\SiteController as we pointed the
 * 'SimpleSite' namespace to the 'src' directory.
 */
$siteController = new SiteController($templatingEngine);

/*
 * Here we set up our router. This is the package that will match a request to
 * our controller and one if its methods (sometimes called an action). This
 * might seem unnecessary, but routers can be really helpful when a site grows.
 * 
 * Check out more information here:
 * 
 * http://symfony.com/doc/current/components/routing/introduction.html
 * 
 * We're going to start off with two routes for the two different types of page
 * that we have set up on our controller (indexPage and simplePage).
 */
$routes = array(
    'index'   => new Route('/',             array('_controller' => $siteController, '_method' => 'indexPage')),
    'general' => new Route('/hello/{name}', array('_controller' => $siteController, '_method' => 'generalPage')),
);

// Add our routes to a collection
$routeCollection = new RouteCollection();
foreach ($routes as $routeName => $route) {
    $routeCollection->add($routeName, $route);
}

/*
 * Match the request we generated earlier to a route. UrlMatcher::matchRequest
 * will throw an exception if it cannot match a request. We need to catch this
 * and turn it into a not found response.
 */
$matcher = new UrlMatcher($routeCollection, new RequestContext('/'));

try {
    $result = $matcher->matchRequest($request);

    // Execute our controller and get the response
    $response = $result['_controller']->$result['_method']($result, $request);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Page not found', 404);
}

// Send the response. Under the hood this uses a combination of 'echo' and 'header()'
$response->send();
