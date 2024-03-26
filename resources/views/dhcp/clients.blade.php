@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">DHCP Clients</h4>
            <p class="card-description">
            List of all DHCP clients on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Interface</th> 
                    <th>Comment</th>
                    <th>Options</th>
                    <th>Use Peer DNS</th>
                    <th>Use Peer NTP</th>
                    <th>Valid</th>
                    <th>Current Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client['.id'] }}</td>
                    <td>{{ $client['interface']}}</td>
                    <td>{{ $client['comment'] }}</td>
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
  <a class="btn btn-success btn-lg btn-block" href="#"><i class="mdi mdi-plus-circle"></i> Add new client</a>
</div>
@endsection