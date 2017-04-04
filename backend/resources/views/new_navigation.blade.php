<div class="row">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a id="brand-logo" class="navbar-brand" href="/"><img src="/logo/R.jpg" width="30px" height="30px"></a>
          <form class="navbar-form navbar-left hidden-md hidden-lg" role="form" action="/search" id="custom-search-form" method="get">
          <div class="input-group stylish-input-group">
            <input type="text" id="query" name="query" class="form-control" placeholder="Search">
            <span class="input-group-addon">
              <button type="submit"><i class="fa fa-search fa-lg"></i></button>
            </span>
          </div>
          </form>
        </div>
        <form class="navbar-form navbar-left navbar-padding hidden-xs hidden-sm" role="form" action="/search" id="custom-search-form" method="get" style="padding-left:190px">
          <div class="input-group stylish-input-group">
            <input type="text" id="query" name="query" class="form-control" placeholder="Search">
            <span class="input-group-addon">
              <button type="submit"><i class="fa fa-search fa-lg"></i></button>
            </span>
          </div>
        </form>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li @if(Request::path()=="home")class="active"@endif><a href="/home" title="Trending">Trending <i class="fa fa-hand-spock-o" aria-hidden="true"></i></a></li>
            <li @if(Request::path()=="/")class="active"@endif><a href="/" title="NewestStories">Newest <i class="fa fa-coffee" aria-hidden="true"></i></a></li>
            <li @if(Request::path()=="snap")class="active"@endif><a href="/snap" title="Post Photos">Snap <i class="fa fa-camera-retro" aria-hidden="true"></i></a></li>
            <li @if(Request::path()=="tell")class="active"@endif><a href="/tell" title="Caption Photo Anonymously">Tell <i class="fa fa-bomb" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>
    </nav>
</div>
