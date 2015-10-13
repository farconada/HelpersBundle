<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 6/10/15
 * Time: 22:11
 */

namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Message\Recorder\RecordsMessages;

class EventProvider implements RecordsMessages
{
    private $messages = [];

    /**
     * {@inheritdoc}
     */
    public function recordedMessages()
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseMessages()
    {
        $this->messages = [];
    }

    /**
     * Record a message.
     *
     * @param object $message
     */
    public function record($message)
    {
        $this->messages[] = $message;
    }
}
