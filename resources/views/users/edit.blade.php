@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit User</h4>
            <p class="card-description">
                Here you can add edit a user
            </p>
            <form method="POST" action="{{route('User.update',$user['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$user['name']}}" placeholder="user" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$user['email']}}" placeholder="user@example.com" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            @if (Auth::user()->admin == 1)
            <div class="form-group">
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="admin" value="1" {{$user['admin'] == "1" ? 'checked': ''}}>
                    <label class="form-check-label"> &nbsp;Admin</label>
                </div>
            </div>
            @endif
            <button type="submit" class="btn btn-primary btn-fw">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection