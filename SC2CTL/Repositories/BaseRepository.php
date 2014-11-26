<?php

namespace SC2CTL\DotCom\Repositories;

use Depotwarehouse\Toolbox\DataManagement\Configuration;
use Depotwarehouse\Toolbox\DataManagement\Repositories\BaseRepositoryAbstract;

class BaseRepository extends BaseRepositoryAbstract {

    /**
     * Resolves the configuration object of the class.
     *
     * In order to decouple from frameworks, configuration of this class is done through a Configuration object.
     * However, since this class is meant to be overridden, putting Configuration instantiation in the constructor
     * would require significant boilerplate on the part of the user in order to instantiate and explicitly call
     * constructors with a Configuration object.
     *
     * Rather, the user must implement the method to resolve configuration. This method has a single function
     * which is to simply set $this->getConfiguration() to a Configuration object acceptable to the client.
     *
     * It is recommended that each project implement resolveConfiguration in a single BaseRepository, then have
     * all your repositories extend from that, however you are welcome to implement the function on a per-repository
     * basis
     *
     * @return void
     */
    function resolveConfiguration()
    {
        $this->configuration = new Configuration();
    }
}
