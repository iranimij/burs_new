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
                            <h5 class="m-0">ساخت اکانت جدید</h5>
                        </div>
                        <div class="card-body col-md-6">
                            <?PHP
                            $update_endpoint = isset($account->id) ? '/'. $account->id : "";
                            ?>
                            <form role="form" method="post" action="{{url("/accounts".$update_endpoint)}}">
                                @csrf
                                @if(isset($account))
                                    {{ method_field('PUT') }}
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">نام کاربری</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام کاربری" name="username" value="@if(isset($account)){{$account->username}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">کلمه عبور</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                               placeholder="کلمه عبور" name="password" value="@if(isset($account)){{$account->password}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">کارگزاری</label>
                                        <select class="form-control" name="kargozari" id="broker">
                                            <option value="mofid" @if(isset($account->kargozari) && "mofid" == $account->kargozari) selected @endif>مفید</option>
                                            <option value="farabi" @if(isset($account->kargozari) && "farabi" == $account->kargozari) selected @endif>فارابی</option>
                                            <option value="agah" @if(isset($account->kargozari) && "agah" == $account->kargozari) selected @endif>آگاه</option>
                                            <option value="atie" @if(isset($account->kargozari) && "atie" == $account->kargozari) selected @endif>آتیه</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">پنل</label>
                                        <select class="form-control" name="panel" id="panel">
                                            <option value="easytrader" @if(isset($account->kargozari) && "easytrader" == $account->panel) selected @endif>ایزی تریدر</option>
                                            <option value="onlineplus" @if(isset($account->kargozari) && "onlineplus" == $account->panel) selected @endif>آنلاین پلاس</option>
                                            <option value="mofidonline" @if(isset($account->kargozari) && "mofidonline" == $account->panel) selected @endif>مفید آنلاین</option>
                                            <option value="exir" @if(isset($account->kargozari) && "exir" == $account->panel) selected @endif>اکسیر</option>
                                            <option value="asatrader" @if(isset($account->kargozari) && "asatrader" == $account->panel) selected @endif>آسا تریدر</option>
                                            <option value="farabixo" @if(isset($account->kargozari) && "farabixo" == $account->panel) selected @endif>فارابیکسو</option>

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
