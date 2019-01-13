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
        </ul>
    </div>
</nav>
