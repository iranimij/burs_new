<?php

namespace App\Http\Controllers;

use App\Account;
use App\Order;
use App\Server;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use phpseclib\Net\SSH2;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Server::orderby("id","DESC")->paginate(20);
        $js_vars =  [
            "url" => url("check-server-is-validate")
        ];
        return view('admin.servers.lists', ['users' => $users,'js_vars' => $js_vars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
          'js_vars' => [
              "url" => url("check-server-is-validate")
          ]
        ];
        return view('admin.servers.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'ip' => 'required|string',
            'port' => 'required|string',
            'username' => 'required',
            'password' => 'required',
        ]);

        $orders = new Server();

        $orders->name = $request->name;
        $orders->ip = $request->ip;
        $orders->port = $request->port;
        $orders->username = $request->username;
        $orders->password = $request->password;

        $orders->save();

        Session::flash('success' , "با موفقیت ذخیره شد.");
        return redirect("servers");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $js_vars =  [
                "url" => url("check-server-is-validate")
            ];
        $account = Server::where("id",$id)->first();
        return view('admin.servers.create', ['account' => $account,'js_vars' => $js_vars]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'ip' => 'required|string',
            'port' => 'required|string',
            'username' => 'required',
            'password' => 'required',
        ]);
        $update_arr = [
            'name' => $request->name,
            'ip' => $request->ip,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
        ];
        if ($request->password == ""){
            unset($update_arr['password']);
        }
        Server::where('id', $id)
            ->update(
                $update_arr
            );
        Session::flash('success' , "با موفقیت ذخیره شد.");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function deleteAccount($id){

        Server::where("id",$id)->delete();
        Session::flash('success' , "با موفقیت حذف شد.");
        return redirect()->back();
    }

    public function checkServerIsValid(Request $request){
        $request->validate([
            'name' => 'required|string',
            'ip' => 'required|string',
            'port' => 'required|string',
            'username' => 'required',
            'password' => 'required',
        ]);

        $host = $request->ip;
        $username = $request->username;
        $password = $request->password;

        $ssh = new SSH2($host);
        if (!$ssh->login($username, $password)) {
            return response()->json([
                'success' => false,
            ]);
        }
        else{
            return response()->json([
                'success' => true,
            ]);
        }
    }
}
