<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 6/10/15
 * Time: 22:29
 */

namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use SimpleBus\Message\Recorder\RecordsMessages;

class DispatchEventBusMidleware implements MessageBusMiddleware
{
    private $eventProvider;
    private $eventBus;

    public function __construct(RecordsMessages $eventProvider, MessageBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->eventProvider = $eventProvider;
    }

    /**
     * @param object $message
     * @return void
     */
    public function handle($message, callable $next)
    {
        $next($message);
        foreach ($this->eventProvider->recordedMessages() as $event) {
            $this->eventBus->handle($event);
        }
    }
}
