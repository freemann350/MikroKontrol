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
                @foreach($wg as $key=>$wg1)
                <tr>
                    <td>{{ $wg1['.id'] }}</td>
                    <td>{{ $wg1['name'] }} </td>
                    <td>{{ $wg1['public-key'] }}</td>
                    @if ($wg1['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{ route("wireguard_editClient",[$deviceParam, $wg1['.id']]) }}"><i class="mdi mdi-pencil"></i></a>
                        @if ($wg1['private-key'] != "")
                        <a class="btn btn-outline-warning btn-fw btn-rounded btn-sm" href="#" onclick="wg_prk('{{$wg1['private-key']}}')"><i class="mdi mdi-key"></i></a>
                        <a class="btn btn-outline-primary btn-fw btn-rounded btn-sm" href="#" onclick="wg_qr{{$key}}()"><i class="mdi mdi-qrcode"></i></a>
                        @endif
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the wireguard interface &quot;{{$wg1["name"]}}&quot; ({{$wg1[".id"]}})','{{ route("wireguard_destroyClient", [$deviceParam, $wg1['.id']]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
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
  <a class="btn btn-success btn-lg btn-block" href="{{ route('wireguard_createClient', $deviceParam) }}"><i class="mdi mdi-plus-circle"></i> Add new wireguard interface</a>
</div>
@endif

@foreach ($wg as $key=>$wg2)
    @if (isset($wg2['qrcode']))
    <script>    
        function wg_qr{{$key}}() {
            Swal.fire({
                title: 'Wireguard QR Code',
                icon: "info",
                html: `
                    {!! $wg2['qrcode'] !!}
                `,
                });
            }
    </script>
    @endif
@endforeach
@endsection