@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new MikroTik device</h4>
            <p class="card-description">
                Here you can add a new MikroTik device for you to control
            </p>
            <form method="POST" action="{{route('Devices.update',$device['id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Device name</label>
                <div class="col-sm-12">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$device['name']}}" placeholder="My Mikrotik">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-12">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{$device['username']}}" placeholder="admin">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{$device['password']}}" placeholder="••••••">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint</label>
                <div class="col-sm-12">
                    <input type="text" name="endpoint" class="form-control @error('endpoint') is-invalid @enderror" value="{{$device['endpoint']}}" placeholder="192.168.88.1">
                    @error('endpoint')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint communication method</label>
                <div class="col-sm-12">
                    <select class="form-select" name="method">
                        <option value="http"{{$device['method'] == "http" ? "selected" : ""}}>HTTP (Not secure but simpler access)</option>
                        <option value="https" {{$device['method'] == "https" ? "selected" : ""}}>HTTPS (Secure, needs SSL configured on the device)</option>
                    </select>
                    @error('method')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Timeout (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="timeout" class="form-control @error('timeout') is-invalid @enderror" value="{{$device['timeout']}}" placeholder="3">
                    @error('timeout')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-fw">Submit</button>
            </form>

        </div>
    </div>
</div>
<form method="POST" action="{{route ('Devices.destroy',$device['id'])}}" enctype="multipart/form-data">
@csrf
@method('DELETE')
    <div class="d-grid gap-2">
        <a href="#deletion" id="deletion" class="btn btn-danger btn-lg btn-block" onclick="_delete('Are you sure you want to delete this device?','{{ route("Devices.destroy", $device["id"]) }}')"><i class="mdi mdi-trash-can-outline"></i> Delete this device</a>
    </div>
</form>
@endsection