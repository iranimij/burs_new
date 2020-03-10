@extends('layouts.dashboard')
@section("title","لیست سرورها")
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
                            <h5 class="m-0">لیست سرورها</h5>
                        </div>
                        <div class="card-body col-md-12">

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>

                                    <tr>
                                        <th>نام</th>
                                        <th>آیپی</th>
                                        <th>نام کاربری</th>
                                        <th style="width: 40%">
                                            عملیات
                                        </th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                {{$user->name}}
                                            </td>
                                            <td>
                                                {{$user->ip}}
                                            </td>
                                            <td>
                                                {{$user->username}}
                                            </td>
                                            <td>
                                                <a href="{{url("servers/".$user->id.'/edit')}}" class="btn btn-outline-primary">ویرایش</a>
                                                <a href="{{url("servers/".$user->id.'/delete')}}"
                                                   class="btn btn-danger">حذف</a>
                                                <span class="btn btn-outline-dark" style="cursor:pointer;" onclick="checkServer(this)" data-server='<?=$user?>'>چک کردن سرور</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            {{$users->links()}}


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
            data = JSON.parse($(tag).attr("data-server"));
            data._token='{{csrf_token()}}';
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
