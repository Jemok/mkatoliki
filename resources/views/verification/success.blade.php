<link href="{{asset('css/bootstrap.min.css')}}" type="text/css" rel="stylesheet">

<div class="container" style="padding-top:72px;">
     <div class="row">
              @if(Session::has("flash_message"))
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>{{session("flash_message")}}</strong>
                            </div>
                        </div>
                    </div>
              @endif
     </div>
</div>