@extends('layouts.dashboard')
@section("title","ساخت اکانت")
@section("content")
    <style>
        #panel option{
            display: none;
        }
        #panel option.active{
            display: block;
        }
        .high_speed_parent{
            display: none;
        }
    </style>
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
                            use function App\Helpers\getKargozary;use function App\Helpers\getKargozaryName;use function App\Helpers\getPanel;use function App\Helpers\getPanelName;$update_endpoint = isset($account->id) ? '/'. $account->id : "";
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
<?PHP

                                    $files = file_get_contents(base_path("assets/json/boka.json"));
                                    $files = json_decode($files);

                                    ?>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"> نام کارگزاری</label>
                                        <select class="form-control select2" name="kargozari" id="broker">
                                            <option value=""></option>
                                        <?PHP

                                            foreach ($files as $key=>$item) {
                                            $kargozary = getKargozaryName($key);
                                            ?>
                                            <option data-kargoizari_id="<?=$key?>" value="{{$key}}" @if(isset($account->kargozari) && $key == $account->kargozari) selected @endif >{{$kargozary}}</option>
                                            <?PHP
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">پنل معاملاتی</label>
                                        <select class="form-control" name="panel" id="panel">
                                            <option value=""></option>
                                            <?PHP

                                            foreach ($files as $key=>$kargozari) {

                                                foreach ($kargozari as $item) {

                                            ?>
                                            <option value="{{$item}}" data-kargozari="<?=$key?>" @if(isset($account->kargozari) && $item == $account->panel) selected @endif><?=getPanelName($item)?></option>

<?PHP }
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="form-group high_speed_parent">
                                        <label for="exampleInputPassword1">سرعت بیشتر</label>
                                        <input id="high_speed_input" type="checkbox" name="high_speed" value="1" @if(isset($account->high_speed)) checked @endif autocomplete="off">
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
@section("custom_script")
    <script>
        var kargozariName = $('#broker option:selected').attr("data-kargoizari_id");
        $('#panel option[data-kargozari='+kargozariName+']').addClass("active");

        $('#broker').on("change",function () {
            $('#panel option').removeClass("active");
            var kargozariName = $('#broker option:selected').attr("data-kargoizari_id");
            $('#panel option[data-kargozari='+kargozariName+']').addClass("active");
        })

        var value = $('#panel').val();
        if(value === "onlineplus" || value === "mofidonline"){
            $('.high_speed_parent').slideDown();
        }else{
            $('.high_speed_parent').slideUp();
        }
        $('#panel').on("change",function () {
            var value = $(this).val();
            if(value === "onlineplus" || value === "mofidonline"){
                $('.high_speed_parent').slideDown();
            }else{
                $('.high_speed_parent').slideUp();
                $('#high_speed_input').prop("checked", false);
            }
        });
    </script>
@endsection()
