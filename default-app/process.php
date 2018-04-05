<?php

use PhpAmqpLib\Message\AMQPMessage;

function process_message(AMQPMessage $message)
{
    echo "\n--------\n";
    echo $message->body;
    echo "\n--------\n";
}
