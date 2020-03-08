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
                            <h5 class="m-0">لیست اکانت های شما</h5>
                        </div>
                        <div class="card-body col-md-12">

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>

                                        <tr>
                                            <th>کارگزاری</th>
                                            <th>پنل</th>
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
                                        @foreach($accounts as $account)
                                        <tr>
                                            <td>{{$kargozari_array[$account->kargozari]}}</td>
                                            <td>
                                                {{$panel_array[$account->panel]}}
                                            </td>
                                            <td>
                                                <a href="{{url("accounts/".$account->id.'/edit')}}" class="badge bg-danger">ویرایش</a>
                                                <a href="{{url("accounts/".$account->id.'/delete')}}" class="badge bg-success">حذف</a>
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
