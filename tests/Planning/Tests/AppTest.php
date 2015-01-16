<?php

namespace Planning\Tests;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Silex\WebTestCase;

class AppTest extends WebTestCase {
    // ...

    /**
     * {@inheritDoc}
     */
    public function createApplication() {
        // ...
        // Enable anonymous access to admin zone
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * Provides all valid application URLs.
     *
     * @return array The list of all valid application URLs.
     */
    public function provideUrls() {
        return array(
            array('/'),
            array('/eleve/1'),
            array('/login'),
            array('/admin'),
            array('/admin/eleve/add'),
            array('/admin/eleve/edit/1'),
            array('/admin/professeur/add'),
            array('/admin/professeur/edit/1'),
            array('/api/eleves'),
            array('/api/eleve/1'),
            );
    }

}
