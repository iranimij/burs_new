@extends('layouts.dashboard')
@section("title","لیست گزارشات")
@section("content")
<?PHP use function App\Helpers\jdate;?>
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
                            <h5 class="m-0 float-right">لیست گزارشات</h5>
                            @if(auth()->user()->permission == 1)
                            <a href="{{url("logsclear")}}" class="btn btn-outline-primary float-left">حذف تمامی گزارشات</a>
                            @endif
                        </div>
                        <div class="card-body col-md-12">

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>

                                        <tr>
                                            @if(auth()->user()->permission == 1)
                                            <th>نام کاربری مدیر اکانت</th>
                                            @endif
                                            <th>نماد</th>
                                            <th>قیمت</th>
                                            <th>تعداد</th>
                                            <th>پنل</th>
                                            <th>زمان</th>
                                            <th style="width: 20%">
                                                وضعیت
                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody>

                                        <?PHP
                                            $status_array = [
                                              "login_request" => "ارسال درخواست ورود",
                                              "send_request" => "ارسال درخواست",
                                              "uploaded" => "فایل ها آپلود شد",
                                              "extract_files" => "فایل ها اکسترکت شد",
                                              "success" => "ثبت موفق درخواست",
                                                "failed_login" => "ورود ناموفق به سرور"
                                            ];
                                        use function App\Helpers\getKargozary;use function App\Helpers\getPanel;$kargozari_array = getKargozary();
                                        $panel_array = getPanel();
                                        ?>
                                        @foreach($accounts as $account)
                                        <tr>
                                            @if(auth()->user()->permission == 1)
                                                <td> {{$account->user->email}}</td>
                                            @endif
                                            <td>{{$account->order->namad}}</td>
                                            <td>
                                                {{$account->order->price}}
                                            </td>
                                            <td>
                                                {{$account->order->number}}
                                            </td>
                                                <td>
                                                {{isset($panel_array[$account->order->account->panel])  ? $panel_array[$account->order->account->panel] : ""}}
                                            </td>
                                                <td>
                                                    <?=jdate("Y-m-d H:i:s",strtotime($account->created_at))?>
                                                </td>
                                            <td>
                                                <span class="badge badge-info">{{isset($status_array[$account->status]) ? $status_array[$account->status] : ""}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                {{$accounts->links()}}


                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
