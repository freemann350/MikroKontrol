@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Static DNS Records</h4>
            <p class="card-description">
            List of all static DNS records on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped"  style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th> 
                    <th>Address</th>
                    <th>Comment</th>
                    <th>Current Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record['.id'] }}</td>
                    <td>{{ $record['name']}}</td>
                    <td>{{ $record['address'] }} </td>
                    <td>{{ isset($record['comment']) ? $record['comment'] : "-"}} </td>
                    @if ($record['disabled']=="false")
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
  <a class="btn btn-success btn-lg btn-block" href="{{route('createDnsRecord')}}"><i class="mdi mdi-plus-circle"></i> Add new static record</a>
</div>
@endsection