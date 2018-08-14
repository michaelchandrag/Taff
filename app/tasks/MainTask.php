<?php
use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo "This is the default task and the default action" . PHP_EOL;
		$url = "localhost/trello/subscribe";
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_HTTPGET,TRUE);
		$output = curl_exec($curl);
		if($output === FALSE)
		{
			echo "Data Gagal";
		}
		else
		{
			echo $output;
		}
		curl_close($curl);
    }
}