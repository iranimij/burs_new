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
                                            @if(auth()->user()->permission == 1)
                                            <th>نام کاربری مدیر اکانت</th>
                                            <th>نام کاربری</th>
                                            @endif
                                            <th>کارگزاری</th>
                                            <th>پنل</th>
                                            <th style="width: 20%">
                                                عملیات
                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody>

                                        <?PHP
                                        use function App\Helpers\getKargozary;use function App\Helpers\getPanel;$kargozari_array = getKargozary();
                                        $panel_array = getPanel();
                                        ?>
                                        @foreach($accounts as $account)
                                        <tr>
                                            @if(auth()->user()->permission == 1)
                                                <td> {{$account->user->email}}</td>
                                            @endif
                                                <td>{{$account->username}}</td>
                                            <td>{{isset($kargozari_array[$account->kargozari]) ? $kargozari_array[$account->kargozari] : ""}}</td>
                                            <td>
                                                {{isset($panel_array[$account->panel]) ? $panel_array[$account->panel] : ""}}
                                            </td>
                                            <td>
                                                <a href="{{url("accounts/".$account->id.'/edit')}}" class="btn btn-outline-primary">ویرایش</a>
                                                <a href="{{url("accounts/".$account->id.'/delete')}}" class="btn btn-danger">حذف</a>
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
