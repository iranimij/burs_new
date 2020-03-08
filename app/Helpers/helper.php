<?php
namespace App\Helpers;
use App\Helpers\WebRequest;
class PrepareWebRequest{
    public static function handleWebRequest(){
        if (PHP_SAPI === 'cli') parse_str(implode('&', array_slice($argv, 1)), $_GET);
        $user = @$_GET['u'];
        $clear =  @$_GET['c'] ? true : false;//true,false

        $root_server = '/root/boors/';
        $root_local = '../';
        $files = [
            'send_ts.php',
            'send_ts2.php',
            'accounts.php',
            'info.php',
            'login.php',
            'tickers.txt',
            'test_time.php',
            'send_ts2 - Copy.php',
            'send_ts_manual.php',
            'create_logs.php',
            'functions.php',
        ];
        $folder = 'cookies/';

        ini_set('default_socket_timeout', 2);

        $servers = [];
        $lines = file('servers_info.txt');
        foreach ($lines as $line) {
            $line = trim($line);
            list($name, $host, $port, $comm) = explode("\t", $line);
            $servers[] = ['name'=>$name, 'host'=>$host, 'port'=>$port];

        }

        @unlink('temp_upload.zip');
        $zip_str = $root_local . $folder;
        foreach ($files as $file) {
            $zip_str .= ' "' . $root_local . $file . '"';
        }
        shell_exec('zip -r temp_upload.zip ' . $zip_str);

        $app = [];
        $n = 0;
        foreach ($servers as $server) {
            if (isset($user) && $user !== $server['name']) continue;

            $app[$n] = new WebRequest($server, $root_server);
            $app[$n]->start();
            $n++;

        }

//count running
        while(true) {
            if (!$clear) echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
            $c = 0;
            foreach($app as $anapp) {
                echo str_pad($anapp->log_fixed, 42) . ' > ' . $anapp->log . PHP_EOL;
                if (isset($anapp) && $anapp->isRunning()) {
                    $c++;
                }
            }
            if ($c == 0) break;
            sleep(1);

        }

        unlink('temp_upload.zip');

    }
}
