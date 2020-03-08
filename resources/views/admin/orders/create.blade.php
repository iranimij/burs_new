@extends('layouts.dashboard')
@section("title","ساخت اکانت")
@section("content")

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success'))
                        <div class="alert alert-success"> {{Session::get('success')}}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">ثبت سفارش جدید</h5>
                        </div>
                        <div class="card-body col-md-6">
                            <?PHP
                            $kargozari_array = [
                                "mofid" => "مفید",
                                "farabi" => "فارابی",
                                "agah" => "آگاه",
                                "atie" => "آتیه",
                            ];
                            $panel_array = [
                                "easytrader" => "ایزی تریدر",
                                "onlineplus" => "آنلاین پلاس",
                                "mofidonline" => "مفید آنلاین",
                                "exir" => "اکسیر",
                                "asatrader" => "آسا تریدر",
                                "farabixo" => "فارابیکسو",
                            ];
                            $update_endpoint = isset($order->id) ? '/'. $order->id : "";
                            ?>
                            <form role="form" method="post" action="{{url("/orders".$update_endpoint)}}">
                                @csrf
                                @if(isset($order))
                                    {{ method_field('PUT') }}
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">اکانت</label>
                                        <select class="form-control" name="account_id" id="broker" autocomplete="off">
                                            @if(isset($accounts))
                                                @foreach($accounts as $account)
                                            <option value="{{$account->id}}" @if(isset($order->account->id)) @if($order->account->id == $account->id) selected="selected" @endif @endif>{{$account->username}} | {{$kargozari_array[$account->kargozari]}} | {{$panel_array[$account->panel]}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">نماد</label>
                                        <select class="form-control select2" name="namad" id="broker" autocomplete="off">
                                            @if(isset($namads))
                                                @foreach($namads as $namad)
                                            <option value="{{$namad->isin}}" @if(isset($order->namad)) @if($order->namad == $namad->isin) selected @endif @endif>{{$namad->title}}</option>
                                                @endforeach
                                                @endif

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">قیمت (به تومان)</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام کاربری" name="price" value="@if(isset($order)){{$order->price}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">تعداد</label>
                                        <input type="number" class="form-control" id="exampleInputPassword1"
                                               placeholder="کلمه عبور" name="number" value="@if(isset($order)){{$order->number}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">نوع</label>
                                        <select class="form-control" name="type" id="panel" autocomplete="off">
                                            <option value="buy" @if(isset($order->type)) @if($order->type == "buy") selected @endif @endif>خرید</option>
                                            <option value="sell" @if(isset($order->type)) @if($order->type == "sell") selected @endif @endif>فروش</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('custom_script')

    <script>
        $('.select2').select2();
    </script>
    @endsection
