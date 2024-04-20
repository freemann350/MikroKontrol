@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Wireguard</h4>
            <p class="card-description">
            List of all Wireguard peers on the device
            </p>
            @if ($wg != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Public Key</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wg as $wg)
                <tr>
                    <td>{{ $wg['.id'] }}</td>
                    <td>{{ $wg['name'] }}</td>
                    <td>{{ $wg['public-key'] }}</td>
                    @if ($wg['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{ route("wireguard_editClient",$wg['.id']) }}"><i class="mdi mdi-pencil"></i></a>
                        <a class="btn btn-outline-warning btn-fw btn-rounded btn-sm" href="#" onclick="wg_prk('{{$wg['private-key']}}')"><i class="mdi mdi-key"></i></a>
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the wireguard interface &quot;{{$wg["name"]}}&quot; ({{$wg[".id"]}})','{{ route("wireguard_destroyClient", $wg[".id"]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
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
@if ($wg != "-1")
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('wireguard_createClient') }}"><i class="mdi mdi-plus-circle"></i> Add new wireguard interface</a>
</div>
@endif
@endsection