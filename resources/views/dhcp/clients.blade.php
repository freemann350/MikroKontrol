@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">DHCP Clients</h4>
            <p class="card-description">
            List of all DHCP clients on the device
            </p>
            @if ($clients != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Interface</th> 
                    <th>Options</th>
                    <th>Use Peer DNS</th>
                    <th>Use Peer NTP</th>
                    <th>Valid</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client['.id'] }}</td>
                    <td>{{ $client['interface']}}</td>
                    <td>{{ $client['dhcp-options'] }} </td>
                    <td>{{ $client['use-peer-dns'] }} </td>
                    <td>{{ $client['use-peer-ntp'] }} </td>
                    @if ($client['invalid'] == "true")
                    <td class="text-success"> <i class="mdi mdi-check-circle"></i> </td>
                    @else
                    <td class="text-danger">  <i class="mdi mdi-close-circle"></i> </td>
                    @endif
                    @if ($client['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="{{route('showDhcpClient',[$deviceParam, $client['.id']])}}"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{route("editDhcpClient",[$deviceParam, $client['.id']])}}"><i class="mdi mdi-pencil"></i></a>
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the DHCP Client on the interface&quot;{{$client["interface"]}}&quot; ({{$client[".id"]}})','{{ route("destroyDhcpClient", [$deviceParam, $client['.id']]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
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
@if ($clients != "-1")
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route('createDhcpClient', $deviceParam) }}"><i class="mdi mdi-plus-circle"></i> Add new client</a>
</div>
@endif
@endsection