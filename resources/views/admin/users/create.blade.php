@extends('layouts.dashboard')
@section("title","کابر جدید")
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
                            <form role="form" method="post" action="{{url("/users".$update_endpoint)}}">
                                @csrf
                                @if(isset($account))
                                    {{ method_field('PUT') }}
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">نام</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام" name="name" value="@if(isset($account)){{$account->name}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">نام کاربری (ایمیل)</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام کاربری" name="email" value="@if(isset($account)){{$account->email}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">کلمه عبور</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1"
                                               placeholder="کلمه عبور" name="password" value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">نوع کاربر</label>
                                        <select class="form-control" name="permission" id="broker" autocomplete="off">
                                            <option value="" >انتخاب کنید</option>
                                            <option value="1" @if(isset($account->permission)) @if($account->permission == 1) selected @endif @endif>مدیر</option>
                                            <option value="2" @if(isset($account->permission)) @if($account->permission == 2) selected @endif @endif>مشتری</option>
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
