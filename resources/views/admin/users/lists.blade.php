@extends('layouts.dashboard')
@section("title","لیست کاربران")
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
                            <h5 class="m-0">لیست کابران</h5>
                        </div>
                        <div class="card-body col-md-12">

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>

                                    <tr>
                                        <th>نام</th>
                                        <th>ایمیل</th>
                                        <th style="width: 20%">
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
                                                {{$user->email}}
                                            </td>
                                            <td>
                                                <a href="{{url("users/".$user->id.'/edit')}}" class="badge bg-danger">ویرایش</a>
                                                <a href="{{url("users/".$user->id.'/delete')}}"
                                                   class="badge bg-success">حذف</a>
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
