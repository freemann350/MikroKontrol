@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Addresses</h4>
            <p class="card-description">
            List of all IP addresses on the device
            </p>
            @if ($addresses != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Address</th>
                    <th>Network</th>
                    <th>Interface (Actual Interface)</th> 
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($addresses as $address)
                <tr>
                    <td>{{ $address['.id'] }}</td>
                    <td>{{ $address['address'] }} ({{ $address['dynamic'] == "true" ? 'Dynamic' : 'Static' }})</td>
                    <td>{{ $address['network'] }}</td>
                    <td>{{ $address['interface']}} ({{$address['actual-interface']}})</td>
                    @if ($address['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="{{route('IPAddresses.show',[$deviceParam, $address['.id']])}}"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{route("IPAddresses.edit",[$deviceParam, $address['.id']])}}"><i class="mdi mdi-pencil"></i></a>
                        @if (!isset($address['comment']) || $address['comment'] != 'defconf')
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the IP Address &quot;{{$address["address"]}}&quot; ({{$address[".id"]}})','{{ route("IPAddresses.destroy", [$deviceParam, $address[".id"]]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
                        @endif
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
@if ($addresses != "-1")
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('IPAddresses.create', $deviceParam) }}"><i class="mdi mdi-plus-circle"></i> Add new address</a>
</div>
@endif
@endsection