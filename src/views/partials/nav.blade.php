<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
              <a class="navbar-brand" href="{{ url(Config::get('filemanager.filemanager_url')) }}">File manager</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_url').'/create') }}">Upload Images</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_url').'/showfiles') }}">View Uploaded Files</a>
            </li>
            <li class="float-right" style="float:right">

              @if( !empty(Session::get('theresponse')) )
                @if(Session::get('theresponse')["msgtype"]==1)
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Well done!</strong> {{ Session::get('theresponse')["message"] }}
                </div>
                @else
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Error!</strong> {{ Session::get('theresponse')["message"] }}
                </div>
                @endif

              @endif

            </li>
        </ul>
    </div>
</nav>
