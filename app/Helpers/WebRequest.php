<?php


namespace App\Helpers;


class WebRequest {
    public $server;
    public $root_server;
    public $log_fixed;
    public $log;

    public function __construct($server, $root_server) {
        $this->server = $server;
        $this->root_server = $root_server;
        $this->log_fixed = '';
        $this->log = '';
    }

    public function run() {
        $server = $this->server;
        $root_server = $this->root_server;

        $this->log_fixed = 'Server: #' . $server['name'] . ' : ' . $server['host'] . ':' . $server['port'];

        $connection = @ssh2_connect($server['host'], (int)$server['port']);
        if (!$connection) {
            $this->log = 'Connection error.';
            return;
        } else {
            $this->log = 'Connected.';
        }

        $r = ssh2_auth_password($connection, 'root', 'Ehsan123');
        if (!$r) {
            $this->log = 'pass is wrong.';
            return;
        } else {
            $this->log = 'pass is true.';
        }

        $r = ssh2_scp_send($connection, 'temp_upload.zip', $root_server.'temp_upload.zip', 0644);
        if (!$r) {
            $this->log = 'Upload error.';
            return;
        } else {
            $this->log = 'Upload ok.';
        }

        $stream = ssh2_exec($connection, 'unzip -o ' . $root_server.'temp_upload.zip' . ' -d ' . $root_server);
        if (!$stream) {
            $this->log = 'Unzip error.';
            return;
        } else {
            $this->log = 'Unzip ok.';
        }

        $r = stream_set_blocking($stream, true);
        if (!$r) {
            $this->log = 'stream_set_blocking error.';
            return;
        } else {
            $this->log = 'stream_set_blocking ok.';
        }

        $this->log = substr(stream_get_contents($stream), 0, 37) . '...';
    }
}
