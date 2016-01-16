<?php

namespace SimpleSite;

// These are the classes that we are going to use
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController
{
    private $templatingEngine;

    /*
     * This controller requires access to a templating engine object to be able
     * to turn templates into HTML.
     * 
     * We make it a 'dependency' that is passed through the class constructor.
     * You might pass other 'dependencies' through the class constructor such
     * as database connections.
     */
    public function __construct(Engine $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
    }

    public function indexPage(array $routeParams, Request $request)
    {
        /*
         * We're using the plates PHP templating engine to turn our templates
         * into HTML for us.
         * 
         * See here for more information:
         * 
         * http://platesphp.com/simple-example/
         */
        $html = $this->templatingEngine->render('site::index');

        /*
         * Here we are creating a response object using the HTML that we
         * rendered from our template.
         * 
         * See here for more information:
         * 
         * http://symfony.com/doc/current/components/http_foundation/introduction.html#response
         * 
         * After we have created this object we immediately return it so that
         * public/index.php can send all of the headers and contents.
         */
        return new Response($html);
    }

    public function generalPage(array $routeParams, Request $request)
    {
        // Make the first letters uppercase and replace hyphens with spaces
        $name = ucwords(str_replace('-', ' ', $routeParams['name']));
        

        // This time we pass '$name' to the template so that we can use it there
        $html = $this->templatingEngine->render('site::page', array('name' => $name));

        return new Response($html);
    }
}
