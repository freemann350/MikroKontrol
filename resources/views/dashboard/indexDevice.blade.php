@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>My placeholder MiktoTik</strong>'s Info </h4>
            <div class="row">
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Endpoint
                    </p>
                    <p class="mb-2">
                        https://192.168.88.1 
                    </p>
                    <p class="fw-bold">
                        Logging as:
                    </p>
                    <p>
                        admin
                    </p>
                    <p class="fw-bold">
                        Communication timeout:
                    </p>
                    <p>
                        7 seconds
                    </p>
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Status
                    </p>
                    <p class="mb-2 text-success">
                        Online
                    </p>
                    </address>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Wireless.create') }}">Use this device</a><br>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Wireless.create') }}">Edit this device</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>My second MiktoTik</strong>'s Info </h4>
            <div class="row">
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Endpoint
                    </p>
                    <p class="mb-2">
                        http://10.10.89.1 
                    </p>
                    <p class="fw-bold">
                        Logging as:
                    </p>
                    <p>
                        admin
                    </p>
                    <p class="fw-bold">
                        Communication timeout:
                    </p>
                    <p>
                        4 seconds
                    </p>
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Status
                    </p>
                    <p class="mb-2 text-danger">
                        Unreachable
                    </p>
                    </address>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Wireless.create') }}">Edit this device</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('Wireless.create') }}"><i class="mdi mdi-plus-circle"></i> Add new MikroTik device</a>
</div>
@endsection