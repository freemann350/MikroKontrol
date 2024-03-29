@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">DHCP Servers</h4>
            <p class="card-description">
            List of all DHCP servers on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Interface</th>
                    <th>Address Pool</th> 
                    <th>Lease Time</th>
                    <th>Authoritative</th>
                    <th>State</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                <tr>
                    <td>{{ $server['.id'] }}</td>
                    <td>{{ $server['name']}}</td>
                    <td>{{ $server['interface'] }} </td>
                    <td>{{ $server['address-pool'] }} </td>
                    <td>{{ $server['lease-time'] }}</td>
                    <td>{{ $server['authoritative'] }}</td>
                    @if ($server['invalid'] == "true")
                    <td><i class="mdi mdi-check-circle text-success">&nbsp;</i></td>
                    @else
                    <td><i class="mdi mdi-close-circle text-danger">&nbsp;</i></td>
                    @endif
                    @if ($server['disabled']=="false")
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
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('createDhcpServer') }}"><i class="mdi mdi-plus-circle"></i> Add new server</a>
</div>
@endsection