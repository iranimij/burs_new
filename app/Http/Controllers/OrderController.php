<?php

namespace App\Http\Controllers;

use App\Account;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where("user_id", auth()->user()->id)->orderby("id", "DESC")->paginate(20);
        return view('admin.orders.lists', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();
        $namad_json = file_get_contents(asset("json/namad.json"));
        $namad_arr = json_decode($namad_json);
        return view('admin.orders.create', ['accounts' => $accounts, 'namads' => $namad_arr]);
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
            'account_id' => 'required',
            'namad' => 'required|string',
            'price' => 'required|numeric',
            'number' => 'required|numeric',
            'type' => 'required',
        ]);
        $orders = new Order();

        $orders->account_id = $request->account_id;
        $orders->user_id = auth()->user()->id;
        $orders->namad = $request->namad;
        $orders->number = $request->number;
        $orders->price = $request->price;
        $orders->type = $request->type;

        $orders->save();
        Session::flash('success', "با موفقیت ذخیره شد.");
        return redirect("orders");
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
        $order = Order::where("id", $id)->first();
        $accounts = Account::all();
        $namad_json = file_get_contents(asset("json/namad.json"));
        $namad_arr = json_decode($namad_json);
        return view('admin.orders.create', ['order' => $order, 'accounts' => $accounts, 'namads' => $namad_arr]);
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
            'account_id' => 'required',
            'namad' => 'required|string',
            'price' => 'required|numeric',
            'number' => 'required|numeric',
            'type' => 'required',
        ]);

        Order::where('id', $id)
            ->update(
                [
                    "account_id" => $request->account_id,
                    "user_id" => auth()->user()->id,
                    "namad" => $request->namad,
                    "number" => $request->number,
                    "price" => $request->price,
                    "type" => $request->type,
                ]
            );
        Session::flash('success', "با موفقیت ذخیره شد.");
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

    function deleteAccount($id)
    {
        Order::where("id", $id)->delete();
        Session::flash('success', "با موفقیت حذف شد.");
        return redirect()->back();
    }
}
