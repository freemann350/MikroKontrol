@extends('template.layout')

@section('main-content')
@if ($devices == null)
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>You don't have any devices yet</h4>
            <p class="card-description">
                Try adding one using the button below
            </p>
        </div>
    </div>
</div>
@else
@foreach ($devices as $device)
    <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>{{$device['name']}}</strong>'s Info </h4>
            <div class="row">
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Endpoint
                    </p>
                    <p>
                        {{$device['method']}}://{{$device['endpoint']}} 
                    </p>
                    <p class="fw-bold">
                        Logging as:
                    </p>
                    <p>
                        {{$device['username']}}
                    </p>
                    <p class="fw-bold">
                        Communication timeout:
                    </p>
                    <p>
                        {{$device['timeout']}} seconds
                    </p>
                    </address>
                </div>
                <div class="col-md-6">
                @if ($device['online'])
                    <address>
                        <p class="fw-bold">
                            Status
                        </p>
                        <p class="mb-2 text-success">
                            Online
                        </p>
                    </address>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Device.index', $device['id']) }}">Use this device</a><br>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Devices.edit', $device['id']) }}">Edit this device</a>
                @else
                    <address>
                        <p class="fw-bold">
                            Status
                        </p>
                        <p class="mb-2 text-danger">
                            Unreachable
                        </p>
                    </address>
                    <a class="btn btn-outline-dark btn-lg btn-block" href="{{ route ('Devices.edit', $device['id']) }}">Edit this device</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('Devices.create') }}"><i class="mdi mdi-plus-circle"></i> Add new MikroTik device</a>
</div>
@endsection