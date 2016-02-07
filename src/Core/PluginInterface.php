<?php namespace App\Core;

// use App\Core\Hooks;
// OR https://github.com/igorw/evenement/blob/master/doc/02-plugin-system.md

interface PluginInterface
{
    function attachEvents();
    // if (!$container instanceof ContainerInterface) {
    //         throw new InvalidArgumentException('Expected a ContainerInterface');
    //     }
    // function attachEvents(Hooks $emitter);
}
