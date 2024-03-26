@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Static Routes</h4>
            <p class="card-description">
            List of all static routes on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Destination Address</th>
                    <th>Local Address</th> 
                    <th>Gateway (Immediate Gateway)</th>
                    <th>Distance (Scope)</th>
                    <th>Routing Table</th>
                    <th>Estabilished Status</th>
                    <th>Connection Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($routes as $route)
                <tr>
                    <td>{{ $route['.id'] }}</td>
                    <td>{{ $route['dst-address'] }} </td>
                    <td>{{ $route['local-address']}}</td>
                    <td>{{ $route['gateway'] }} ({{ $route['immediate-gw'] }})</td>
                    <td>{{ $route['distance'] }} ({{ $route['scope'] }})</td>
                    <td>{{ $route['routing-table'] }}</td>
                    @if ($route['connect'] == "true")
                    <td class="text-success"> Connected  <i class="ti-arrow-up"></i></td>
                    @else
                    <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                    @endif
                    @if ($route['active']=="true")
                    <td><label class="badge badge-success">Estabilished</label></td>
                    @else
                    <td><label class="badge badge-danger">Not estabilished</label></td>
                    @endif
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
  <a class="btn btn-success btn-lg btn-block" href="#"><i class="mdi mdi-plus-circle"></i> Add new static route</a>
</div>
@endsection