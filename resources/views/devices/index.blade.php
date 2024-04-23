@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
          @if ($resource != null)
            <h4 class="card-title"><strong>{{$device['name']}}</strong>'s resources </h4>
            <div class="row">
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Board name
                    </p>
                    <p class="mb-2">
                        {{$resource['platform']}} {{$resource['board-name']}}
                    </p>
                    <p class="fw-bold">
                        CPU
                    </p>
                    <p>
                        {{$resource['cpu']}} ({{$resource['cpu-count']}} cores, {{$resource['cpu-frequency']}} MHz)
                    </p>
                    <p class="fw-bold">
                        Version:
                    </p>
                    <p>
                        {{$resource['version']}} <br>
                        Built on {{$resource['build-time']}}
                    </p>
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                    <p class="fw-bold">
                        Uptime
                    </p>
                    <p class="mb-2">
                        {{$resource['uptime']}}
                    </p>
                    <p class="fw-bold">
                        HDD (used/total)
                    </p>
                    <p class="mb-2">
                        {{$resource['free-hdd-space']}} / {{$resource['total-hdd-space']}}
                    </p>
                    <p class="fw-bold">
                        Memory (used/total)
                    </p>
                    <p class="mb-2">
                        {{$resource['free-memory']}} / {{$resource['total-memory']}}
                    </p>
                    </address>
                </div>
            </div>
            @else
            <p>Could not load info.</p>
            <p>Error: <b>{{$conn_error}}</b></p>
            @endif
        </div>
    </div>
</div>
@endsection