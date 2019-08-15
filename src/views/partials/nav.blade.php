<nav class="navbar navbar-expand-lg navbar-light bg-light filemanagernav">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item nav-item <?php if(\Request::is(Config::get('filemanager.filemanager_url').'/create')): echo 'selected'; endif; ?>">
                <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_url').'/create') }}"><i class="fa fa-upload" aria-hidden="true"></i> Upload Files</a>
            </li>
            <li class="nav-item nav-item <?php if(\Request::is(Config::get('filemanager.filemanager_url').'/showfiles')): echo 'selected'; endif; ?>">
                <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_url').'/showfiles') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> Uploaded Files</a>
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
