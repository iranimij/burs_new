@extends('layouts.dashboard')
@section("title","سرور جدید")
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
                        <span class="response_check_server">

                        </span>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">ایجاد سرور جدید</h5>
                        </div>
                        <div class="card-body col-md-6">
                            <?PHP
                            $update_endpoint = isset($account->id) ? '/'. $account->id : "";
                            ?>
                            <form id="serverform" role="form" method="post" action="{{url("/servers".$update_endpoint)}}">
                                @csrf
                                @if(isset($account))
                                    {{ method_field('PUT') }}
                                @endif
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">نام سرور</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام سرور" name="name" value="@if(isset($account)){{$account->name}}@endif" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">آیپی</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="آیپی" name="ip" value="@if(isset($account)){{$account->ip}}@endif" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">پورت </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="پورت" name="port" value="@if(isset($account)){{$account->port}}@endif" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">نام کاربری </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               placeholder="نام کاربری" name="username" value="@if(isset($account)){{$account->username}}@endif" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">کلمه عبور</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                               placeholder="کلمه عبور" name="password" value="@if(isset($account)){{$account->password}}@endif" autocomplete="off">
                                    </div>




                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                    <span class="btn btn-warning" onclick="checkServer(this)" style="cursor: pointer">چک کردن اتصال به سرور</span>
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
        // $('.select2').select2({
        //     tags: true,
        //     tokenSeparators: [',', ' '],
        //     dir: "rtl"
        // });
        function checkServer(tag) {
            $('.response_check_server').empty();
            var data = $("#serverform :not(input[name=_method])").serialize();


            $('body').waitMe({

                effect: 'ios',
                text: 'لطفا چند لحظه صبر کنید!',
                maxSize: '',
                waitTime: -1,
                textPos: 'vertical',
                fontSize: '',
                source: '',

            });

            $.ajax({
                type: 'POST',
                url: js_vars.url,
                dataType: 'json',
                data: data,
                timeout: 10000,
                success: function (msg) {
                    if(msg.success == true){
                        $('.response_check_server').append('<div class="alert alert-success">تست اتصال به سرور با موفقیت انجام شد.</div>');
                    }else{
                        $('.response_check_server').append('<div class="alert alert-warning">مشکلی در اتصال به سرور وجود دارد.</div>');
                    }
                    $('body').waitMe('hide');
                },
                error : function (msg) {
                    console.log(msg);
                    if(msg.status == 500){
                        $('.response_check_server').append('<div class="alert alert-warning">مشکلی در اتصال به سرور وجود دارد.</div>');
                    }else if(msg.status == 422){
                    if (msg.responseJSON.errors) {
                        $('.response_check_server').append('<div class="alert alert-danger">لطفا تمام فیلد ها را پر کنید</div>');

                    }
                    }
                    $('body').waitMe('hide');
                }
            });
        }
    </script>
@endsection
