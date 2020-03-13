@extends('layouts.dashboard')
@section("title","لیست اکانت ها")
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
                            <h5 class="m-0">لیست سفارشات</h5>
                        </div>
                        <div class="card-body col-md-12">

                                <div class="card-body">
                                    @if(sizeof($orders) > 0)

                                    <table class="table table-bordered">
                                        <thead>

                                        <tr>
                                            @if(auth()->user()->permission == 1)
                                            <th>کابر</th>
                                            @endif
                                            <th>اکانت</th>
                                            <th>قیمت</th>
                                            <th>تعداد</th>
                                            <th>نوع</th>
                                            <th style="width: 20%">
                                                عملیات
                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody>

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
                                        ?>

                                        @foreach($orders as $account)
                                        <tr>
                                            @if(auth()->user()->permission == 1)
                                            <td> {{$account->user->email}}</td>
                                            @endif
                                            <td> {{$account->account->username}}</td>
                                            <td>
                                                 {{number_format($account->price)}} ریال
                                            </td>
                                            <td>
                                                {{$account->number}}
                                            </td>
                                            <td>
                                                {{$account->type}}
                                            </td>

                                            <td>
                                                <a href="{{url("orders/".$account->id.'/edit')}}" class="btn btn-outline-primary">ویرایش</a>
                                                <a id="hazf" href="{{url("orders/".$account->id.'/delete')}}" class="btn btn-danger">حذف</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                    @else
                                    <h3>سفارشی ثبت نشده است.</h3>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                                {{$orders->links()}}


                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section("custom_script")
    <script>
        $('#hazf').on("click",function (e) {
            var answer=confirm('آیا واقعا میخواهید حذف کنید ؟');
            if(answer){

            }
            else{
                e.preventDefault();
            }
        })
    </script>
    @endsection
