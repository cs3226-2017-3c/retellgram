@extends('new_template')
@section('main')
<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#"><i class="fa" aria-hidden="true"></i>Trending</a>
                </li>
                @yield('sidebar')
      </ul>
  </div>
  <!-- /#sidebar-wrapper -->

  @yield('main-content')

</div>
@endsection
