<?php

namespace App\Console;

use App\Account;
use App\Helpers\PrepareWebRequest;
use App\Log;
use App\Order;
use App\Server;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use phpseclib\Net\SFTP;
use phpseclib\Net\SSH2;
use function App\Helpers\get_broker_url;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //place for login
        $schedule->call(function () {
            $this->createAccountcFile();


            $host = "185.51.202.111";
            $username = "root";
            $password = "Ehsan123";
            $command = 'rmdir imanTestDirctory';

            $ssh = new SSH2($host);
            if (!$ssh->login($username, $password)) {
                $output = 'Login Failed';
            } else {
                $output = $ssh->exec($command);
            }
            //this is time for run code
        })->dailyAt('06:00');
//    })->everyMinute();

        //this is for send order
        $schedule->call(function () {



            $orders = Order::where("deleted", null)->get();
            $servers = [];
            foreach ($orders as $order) {

                $namad_id = $order->namad;
                $sahm_number = $order->number;
                $price = $order->price;
                $server_id = $order->server;
                //new variables
                $ts = isset($order->ts) ? $order->ts : "58";
                $te = isset($order->te) ? $order->te : "05";
                $ms = isset($order->ms) ? $order->ms : "0.01";
                $high_speed = isset($order->account->high_speed) ? true : false;
                /////////
                $type = $order->type == "buy" ? "b" : "s";
                $kargozari = $order->account->kargozari;
                $panel = $order->account->panel;
                $user = $order->user->email;
                if ($high_speed){
                    file_put_contents("cookie/replacing.txt",$panel);
                }
                $command = 'nohup php send_ts.php u=' . $user . '_' . $panel . '_' . $kargozari . ' s=' . $namad_id . ' q=' . $sahm_number . ' p=' . $price . ' t=' . $type . ' ts='.$ts.' te='.$te.' ms='.$ms.' &>nohup_log1.out &';
                $server_obj = Server::where("id", $server_id)->first();
                if (isset($server_obj->ip)) {
                    $host = $server_obj->ip;
                    $username = $server_obj->username;
                    $password = $server_obj->password;

                    $this->createZipFiles();
                    $sftp = new SFTP($host);
                    $logs = new Log();
                    $logs->user_id = $order->user->id;
                    $logs->order_id = $order->id;
                    $logs->status = "login_request";
                    $logs->save();

                        if (@!$sftp->login($username, $password)) {
                            Log::where("id", $logs->id)->update([
                                "status" => "failed_login"
                            ]);
                        } else {

                            $upload_files = $sftp->put('temp_upload.zip', 'temp_upload.zip', SFTP::SOURCE_LOCAL_FILE);
                            if ($upload_files) {
                                Log::where("id", $logs->id)->update([
                                    "status" => "uploaded"
                                ]);
                            }
                            $extract_files = $sftp->exec('unzip -o temp_upload.zip' . ' -d /root/');
                            if ($upload_files) {
                                Log::where("id", $logs->id)->update([
                                    "status" => "extract_files"
                                ]);
                            }
                            $send_request = $sftp->exec($command);
                            if ($upload_files) {
                                Log::where("id", $logs->id)->update([
                                    "status" => "success"
                                ]);
                            }
                        }
                    unlink('temp_upload.zip');
                    Order::where("id", $order->id)->update([
                        "deleted" => 1
                    ]);
                }
            }
            //this is time for run code
//        })->dailyAt('08:00');
       })->everyMinute();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    public function createZipFiles()
    {

        $folder = 'cookie';
        $created_new_files= [];
//        $new_folder = 'new_folder';
        $created_files = glob($folder . '/*');
//        $created_new_files = glob($new_folder . '/*');
        $created_files = array_merge($created_files,$created_new_files);
        Zipper::make('temp_upload.zip')->add($created_files)->close();

    }

    public function createAccountcFile(){
        $accounts = Account::all();
        $acc_res= [];
        $text = '<?PHP $accounts = [';
        foreach ($accounts as $account) {
            $text .= '"'.$account->user->email.'_'.$account->kargozari.'_'.$account->panel.'"'.'=> [
                "username" => "'.$account->username.'",
                "password" => "'.$account->password.'",
                "broker" => "'.$account->kargozari.'",
                "panel" => "'.$account->panel.'",
                "capital" => "'.'all'.'",
                "server" => '.true.',
                "enable" => '.true.',
            ], ';
        };
        $text .= '] ?>';
        file_put_contents("accounts.php",$text);
    }
}
