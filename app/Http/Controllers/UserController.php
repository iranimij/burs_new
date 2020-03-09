<?php

namespace App\Http\Controllers;

use App\Account;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby("id","DESC")->paginate(20);
        return view('admin.users.lists', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'required|string',
            'user_servers' => 'required',
            'permission' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'server' => json_encode($request->user_servers),
            'password' => Hash::make($request->password),
            'permission' => intval($request->permission),
        ]);

        Session::flash('success' , "با موفقیت ذخیره شد.");
        return redirect("users");
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
        $account = User::where("id",$id)->first();
        return view('admin.users.create', ['account' => $account]);
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
            'email' => ['required','string',function($attribute, $value, $fail) use($id){

                if (User::where("email",$value)->first()->id != $id) {
                    $fail('این نام کاربری (ایمیل) قبلا ثبت شده است .');
                }
            }],
            'password' => 'string|min:8|nullable',
            'name' => 'required|string',
            'user_servers' => 'required',
            'permission' => 'required',
        ]);
        $update_arr = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'server' => json_encode($request->user_servers),
            'permission' => $request->permission,
        ];
        if ($request->password == ""){
            unset($update_arr['password']);
        }
        User::where('id', $id)
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

        User::where("id",$id)->delete();
        Session::flash('success' , "با موفقیت حذف شد.");
        return redirect()->back();
    }
}
