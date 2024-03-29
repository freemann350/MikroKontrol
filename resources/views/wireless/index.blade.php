@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Wireless Interfaces</h4>
            <p class="card-description">
            List of all wireless interfaces on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
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
                    <th>Actions</th>
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
                    <td>{{ $wireless['band'] }}</td>
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
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-pencil"></i></a>
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-trash-can-outline"></i></a>
                    </td>
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
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('Wireless.create') }}"><i class="mdi mdi-plus-circle"></i> Add new wireless interface</a>
</div>
@endsection