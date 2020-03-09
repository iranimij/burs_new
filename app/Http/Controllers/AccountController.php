<?php

namespace App\Http\Controllers;

use App\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->permission == "1") {
            $accoutns = Account::orderby("id","DESC")->paginate(20);
        }else{
            $accoutns = Account::where("user_id",auth()->user()->id)->orderby("id","DESC")->paginate(20);
        }

        return view('admin.accounts.lists', ['accounts' => $accoutns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.accounts.create');
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
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $accounts = new Account();

        $accounts->username = $request->username;
        $accounts->user_id = auth()->user()->id;
        $accounts->password = $request->password;
        $accounts->kargozari = $request->kargozari;
        $accounts->panel = $request->panel;

        $accounts->save();
        Session::flash('success' , "با موفقیت ذخیره شد.");
        return redirect("accounts");
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
        $account = Account::where("id",$id)->first();
        return view('admin.accounts.create', ['account' => $account]);
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
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        Account::where('id', $id)
            ->update(
                [
                    'username' => $request->username,
                    'password' => $request->password,
                    'kargozari' => $request->kargozari,
                    'panel' => $request->panel,
                ]
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

        Account::where("id",$id)->delete();
        Session::flash('success' , "با موفقیت حذف شد.");
        return redirect()->back();
    }
}
