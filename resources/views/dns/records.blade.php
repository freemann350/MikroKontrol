@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Static DNS Records</h4>
            <p class="card-description">
            List of all static DNS records on the device
            </p>
            @if ($records != "-1")
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th> 
                    <th>Address</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record['.id'] }}</td>
                    <td>{{ $record['name']}}</td>
                    <td>{{ $record['address'] }} </td>
                    @if ($record['disabled']=="false")
                    <td><label class="badge badge-success">Enabled</label></td>
                    @else
                    <td><label class="badge badge-danger">Disabled</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="{{route('showDnsRecord',[$deviceParam, $record['.id']])}}"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="{{route('editDnsRecord',[$deviceParam, $record[".id"]])}}"><i class="mdi mdi-pencil"></i></a>
                        <a class="btn btn-outline-danger btn-fw btn-rounded btn-sm" href="#" onclick="_delete('Are you sure you want to delete the static DNS record &quot;{{$record["name"]}}&quot; ({{$record[".id"]}})','{{route("destroyDnsRecord", [$deviceParam, $record['.id']])}}')"><i class="mdi mdi-trash-can-outline"></i></a>
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
@if ($records != "-1")
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{route('createDnsRecord', $deviceParam)}}"><i class="mdi mdi-plus-circle"></i> Add new static record</a>
</div>
@endif
@endsection