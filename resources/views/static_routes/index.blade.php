@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Static Routes</h4>
            <p class="card-description">
            List of all static routes on the device
            </p>
            @if ($routes != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Destination Address</th>
                    <th>Gateway (Immediate Gateway)</th>
                    <th>Estabilished Status</th>
                    <th>Connection Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($routes as $route)
                <tr>
                    <td>{{ $route['.id'] }}</td>
                    <td>{{ $route['dst-address'] }} </td>
                    <td>{{ $route['gateway'] }} ({{ $route['immediate-gw'] }})</td>
                    @if (isset($route['connect']) && $route['connect'] == "true")
                    <td class="text-success"> Connected  <i class="ti-arrow-up"></i></td>
                    @else
                    <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                    @endif
                    @if (isset($route['active']) && $route['active']=="true")
                    <td><label class="badge badge-success">Estabilished</label></td>
                    @else
                    <td><label class="badge badge-danger">Not estabilished</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="{{route('StaticRoutes.show',[$deviceParam, $route['.id']])}}"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{route('StaticRoutes.edit',[$deviceParam, $route['.id']])}}"><i class="mdi mdi-pencil"></i></a>
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the Static Route &quot;{{$route["dst-address"]}}&quot; (via {{$route["gateway"]}})' ,'{{ route("StaticRoutes.destroy", [$deviceParam, $route[".id"]]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <br>
            <button onclick="location.reload();" type="button" class="btn btn-info btn-lg btn-block"><i class="mdi mdi-refresh"></i>Refresh info
            </button>
            @else
            <p>Could not load info.</p>
            <p>Error: <b>{{$conn_error}}</b></p>
            @endif
        </div>
    </div>
</div>
@if ($routes != "-1")
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route('StaticRoutes.create', $deviceParam) }}"><i class="mdi mdi-plus-circle"></i> Add new static route</a>
</div>
@endif
@endsection