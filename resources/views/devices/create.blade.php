@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new MikroTik device</h4>
            <p class="card-description">
                Here you can add a new MikroTik device for you to control
            </p>
            <form method="POST" action="{{route('Devices.store')}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Device name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="My Mikrotik">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}" placeholder="admin">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}" placeholder="••••••">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint</label>
                <div class="col-sm-9">
                    <input type="text" name="endpoint" class="form-control @error('endpoint') is-invalid @enderror" value="{{old('endpoint')}}" placeholder="192.168.88.1">
                    @error('endpoint')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint communication method</label>
                <div class="col-sm-9">
                    <select class="form-select" name="method">
                        <option value="http">HTTP (Not secure but simpler access)</option>
                        <option value="https">HTTPS (Secure, needs SSL configured on the device)</option>
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
                <div class="col-sm-9">
                    <input type="text" name="timeout" class="form-control @error('timeout') is-invalid @enderror" value="{{old('timeout')}}" placeholder="3">
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
@endsection