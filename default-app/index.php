<?php

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__ . '/config.php';
require_once __DIR__ . '/process.php';

$connection = new AMQPStreamConnection(
    $config['rabbitmq.host'],
    $config['rabbitmq.port'],
    $config['rabbitmq.user'],
    $config['rabbitmq.pass']
);
$channel = $connection->channel();

/*
    name: $config['queue']
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
$channel->queue_declare($config['rabbitmq.queue'], false, true, false, false);

echo "Waiting messages on '" . $config['rabbitmq.queue'] . "'\n";

/*
    queue: Queue from where to get the messages
    consumer_tag: Consumer identifier
    no_local: Don't receive messages published by this consumer.
    no_ack: Tells the server if the consumer will acknowledge the messages.
    exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
    nowait:
    callback: A PHP Callback
*/
$channel->basic_consume($config['rabbitmq.queue'], $config['rabbitmq.consumerTag'], false, false, false, false, 'process_message');

/*function shutdown(AMQPChannel $channel, AbstractConnection $connection)
{
    $channel->close();
    $connection->close();
}
register_shutdown_function('shutdown', $channel, $connection);*/

// Loop as long as the channel has callbacks registered
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
