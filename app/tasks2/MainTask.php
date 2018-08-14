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
		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Chat()
				)
			),
			8080
		);

		$server->run();
    }
}