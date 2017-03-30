<div class="row">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a id="brand-logo" class="navbar-brand" href="/"><img src="/logo/R.jpg" width="30px" height="30px"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li @if(Request::path()=="/")class="active"@endif><a href="/" title="Trending">Trending <i class="fa fa-hand-spock-o" aria-hidden="true"></i></a></li>
            <li @if(Request::path()=="snap")class="active"@endif><a href="/snap" title="Post Photos">Snap <i class="fa fa-camera-retro" aria-hidden="true"></i></a></li>
            <li @if(Request::path()=="tell")class="active"@endif><a href="/tell" title="Caption Photo Anonymously">Tell <i class="fa fa-bomb" aria-hidden="true"></i></a></li>
            <!--li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i><span class="caret"></span></a>
              <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
			          <li>
                  <div class="row">
                    <div class="col-md-12">
                      <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                        <div class="form-group">
                          <label class="sr-only" for="exampleInputEmail2">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
                        </div>
                        <div class="form-group">
                          <label class="sr-only" for="exampleInputPassword2">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> Remember me
                          </label>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success btn-block">Sign in</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </li>
                <li class="divider"></li>
                <li>
                  <input class="btn btn-primary btn-block" type="button" id="sign-in-google" value="Sign In with Google">
                  <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter" value="Sign In with Twitter">
                </li>
              </ul>
            </li-->
          </ul>

    		  <div class="container">
    		    <div class="row">
      			  <div class="span12">
      			    <form id="custom-search-form" >
      				  <div class="input-append span12">
      				    <div class="search">
      						<input type="text" class="search-query" placeholder="Search Retellgram">
      						<button type="submit" class="btn"><i class="fa fa-search fa-lg"></i></button>
      					</div>
      				  </div>
      				  </form>
      			  </div>
    			  </div>
    		  </div>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>
