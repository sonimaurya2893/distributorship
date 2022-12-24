@extends('layouts.weblayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
        <h4>Welcome Rajat Shah</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-link active" id="nav-home-tab" href="/dashboard/">Dashboard</a>
    <a class="nav-link" id="nav-profile-tab" href="dashboard/profile">Profile</a>
    <a class="nav-link" id="nav-contact-tab" href="dashboard/inbox">Inbox</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent" style="border: 1px solid #CCC; background: #FFF; margin-top: -1px; padding: 17px;">
<p>Add New Listing</p>
@include('web.listing.distributor')


</div>
        </div>
    </div>
</div>

    
@endsection