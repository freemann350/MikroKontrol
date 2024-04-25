@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
      <div class="card-body">
          <h4 class="card-title">Users</h4>
          <p class="card-description">
          List of all users
          </p>
          <div class="table-responsive">
          <table class="table table-hover table-striped" style="text-align:center" id="dt">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user['id']}}</td>
                <td>{{$user['name']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['admin'] == 1 ? "Admin" : "User"}}</td>
                <td>
                    <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{$user['id'] == Auth::user()->id ? route('User.me') : route('User.edit',$user['id'])}}"><i class="mdi mdi-pencil"></i></a>
                    @if (Auth::user()->id != $user['id'])
                    <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the user &quot;{{$user["name"]}}&quot; ({{$user["id"]}})','{{ route("User.destroy",$user['id']) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
                    @endif
                </td>
              </tr>
              @endforeach
              </tbody>
          </table>
          </div>
          <br>
          <button onclick="location.reload();" type="button" class="btn btn-info btn-lg btn-block"><i class="mdi mdi-refresh"></i>Refresh info
          </button>
      </div>
  </div>
</div>
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('User.create') }}"><i class="mdi mdi-plus-circle"></i> Add new user</a>
</div>
@endsection