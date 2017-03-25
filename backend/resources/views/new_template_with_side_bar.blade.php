@extends('new_template')
@section('main')
<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#"><i class="fa fa-hashtag" aria-hidden="true"></i>Hashtags</a>
                </li>
                <li>
                    <a href="#">#NewestSnaps</a>
                </li>
                <li>
                    <a href="#">#NewestStories</a>
                </li>
                <li>
                    <a href="#">#MostLikedStories</a>
                </li>
                <li>
                    <a href="#">#MostLikedSnaps</a>
                </li>
                <li>
                    <a href="#">#UserTag1</a>
                </li>
                <li>
                    <a href="#">#UserTag2</a>
                </li>
                <li>
                    <a href="#">#UserTag3</a>
                </li>
      </ul>
  </div>
  <!-- /#sidebar-wrapper -->
  @yield('main-content')
</div>
@endsection