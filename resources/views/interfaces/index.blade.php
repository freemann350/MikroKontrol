@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Interfaces</h4>
            <p class="card-description">
                List of all interfaces on the device (physical/virtual)
            </p>
            @if ($interfaces != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>MAC</th>
                    <th>MTU (Actual)</th>
                    <th>Connection Status</th>
                    <th>Current Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($interfaces as $interface)
                @if ($interface['type'] != "wlan")                    
                <tr>
                    <td>{{ $interface['.id'] }}</td>
                    <td>{{ $interface['name'] }}</td>
                    <td>{{ $interface['type'] }}</td>
                    <td>{{ isset($interface['mac-address']) ? $interface['mac-address'] : "-" }}</td>
                    <td>{{ $interface['mtu'] }} ({{ isset($interface['actual-mtu']) ? $interface['actual-mtu'] : "-" }})</td>
                    @if ($interface['running'] == "true")
                    <td class="text-success"> Connected <i class="ti-arrow-up"></i></td>
                    @else
                    <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                    @endif
                    @if ($interface['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                </tr>
                @endif
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
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Wireless Interfaces</h4>
            <p class="card-description">
                List of all wireless interfaces on the device
            </p>
            @if ($wireless != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt_wifi">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>SSID</th>
                    <th>Mode</th>
                    <th>Security Profile</th>
                    <th>Band (Actual)</th>
                    <th>Connection Status</th>
                    <th>Current Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wireless as $wireless)
                <tr>
                    <td>{{ $wireless['.id'] }}</td>
                    <td>{{ $wireless['name'] }}</td>
                    <td>{{ $wireless['ssid'] }}</td>
                    <td>{{ $wireless['mode'] }}</td>
                    <td>{{ $wireless['security-profile'] }}</td>
                    <td>{{ isset($wireless['band']) ? $wireless['band'] : '-' }}</td>
                    @if ($wireless['running'] == "true")
                    <td class="text-success"> Connected <i class="ti-arrow-up"></i></td>
                    @else
                    <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                    @endif
                    @if ($wireless['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
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
@endsection