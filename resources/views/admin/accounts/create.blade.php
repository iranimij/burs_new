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
                            use function App\Helpers\getKargozary;use function App\Helpers\getPanel;$update_endpoint = isset($account->id) ? '/'. $account->id : "";
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
                                        <label for="exampleInputPassword1"> نام کارگزاری</label>
                                        <select class="form-control select2" name="kargozari" id="broker">
                                        <?PHP
                                            $kargozaries = getKargozary();
                                            foreach ($kargozaries as $key=>$kargozary) {
                                            ?>
                                            <option value="{{$key}}" @if(isset($account->kargozari) && $key == $account->kargozari) selected @endif>{{$kargozary}}</option>
                                            <?PHP
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">پنل معاملاتی</label>
                                        <select class="form-control" name="panel" id="panel">
                                            <?PHP
                                            $panels = getPanel();
                                            foreach ($panels as $key=>$panel) {
                                            ?>
                                            <option value="{{$key}}" @if(isset($account->kargozari) && $key == $account->panel) selected @endif>{{$panel}}</option>

<?PHP } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary bg-gradient-primary btn-lg">ثبت</button>
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
