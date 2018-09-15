<?php
use Phalcon\Cli\Task;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

require '../vendor/autoload.php';

class MainTask extends Task
{
    public function mainAction()
    {
        echo "This is the default task and the default action" . PHP_EOL;   
        $user = User::findFirst();
        print_r($user);
    }
}