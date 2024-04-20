@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
      <div class="card-body">
          <h4 class="card-title">Bridges</h4>
          <p class="card-description">
          List of all bridge interfaces on the device
          </p>
          @if ($bridges != null)
          <div class="table-responsive">
          <table class="table table-hover table-striped"  style="text-align:center" id="dt">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Ageing Time</th>
                  <th>MAC</th>
                  <th>MTU (Actual)</th>
                  <th>Connection Status</th>
                  <th>Current Status</th>
                  <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              @foreach($bridges as $bridge)
              <tr>
                <td>{{ $bridge['.id'] }}</td>
                <td>{{ $bridge['name'] }}</td>
                <td>{{ $bridge['ageing-time'] }}</td>
                <td>{{ $bridge['mac-address'] }}</td>
                <td>{{ $bridge['mtu'] }} ({{ isset($bridge['actual-mtu']) ? $bridge['actual-mtu'] : "-" }})</td>
                @if ($bridge['running'] == "true")
                <td class="text-success"> Connected <i class="ti-arrow-up"></i></td>
                @else
                <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                @endif
                @if ($bridge['disabled']=="false")
                <td><label class="badge badge-success">Enabled</label></td>
                @else
                <td><label class="badge badge-danger">Disabled</label></td>
                @endif
                <td>
                    <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-information-outline"></i></a>
                    <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{route('Bridges.edit',$bridge['.id'])}}"><i class="mdi mdi-pencil"></i></a>
                    @if (!isset($bridge['comment']) || $bridge['comment'] != 'defconf')
                    <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the bridge &quot;{{$bridge["name"]}}&quot; ({{$bridge[".id"]}})','{{ route("Bridges.destroy", $bridge[".id"]) }}')"><i class="mdi mdi-trash-can-outline"></i></a>
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
@if ($bridges != null)
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('Bridges.create') }}"><i class="mdi mdi-plus-circle"></i> Add new bridge interface</a>
</div>
@endif
@endsection