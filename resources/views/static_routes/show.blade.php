@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">Static Route "{{$route['dst-address']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the Static Route "{{$route['dst-address']}}"
                        </p>
                        <p class="fw-bold text-primary">Address</p>
                        <p>
                            {{isset($route['dst-address']) ? $route['dst-address'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Gateway</p>
                        <p>
                            {{isset($route['gateway']) ? $route['gateway'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Check Gateway</p>
                        <p>
                            {{isset($route['check-gateway']) ? $route['check-gateway'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Suppress Hardware Offload</p>
                        <p>
                            {{isset($route['suppress-hw-offload']) ? $route['suppress-hw-offload'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Distance </p>
                        <p>
                            {{isset($route['distance']) ? $route['distance'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Scope </p>
                        <p>
                            {{isset($route['scope']) ? $route['scope'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Target Scope </p>
                        <p>
                            {{isset($route['target-scope']) ? $route['target-scope'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($route != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$route['dst-address']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the Static Route "{{$route['dst-address']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection