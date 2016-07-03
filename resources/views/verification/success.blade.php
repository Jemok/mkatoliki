<link href="{{asset('css/bootstrap.min.css')}}" type="text/css" rel="stylesheet">

<div class="container" style="padding-top:200px;">
     <div class="row">
              @if(Session::has("flash_message"))
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <h1>{{session("flash_message")}}</h1>
                            </div>
                        </div>
                    </div>
              @endif
     </div>
</div>