@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Security Profiles</h4>
            <p class="card-description">
            List of all security profiles for wireless interfaces on the device
            </p>
            @if ($security_profiles != null)
            <div class="table-responsive">
            <table class="table table-hover table-striped" style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Auth Type</th>
                    <th>Unicast Ciphers</th>
                    <th>Default SP</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($security_profiles as $security_profile)
                <tr>
                    <td>{{ $security_profile['.id'] }}</td>
                    <td>{{ $security_profile['name'] }}</td>
                    <td>{{ isset($security_profile['authentication-types']) && $security_profile['authentication-types'] !== "" ? $security_profile['authentication-types'] : "-"}}</td>
                    <td>{{ isset($security_profile['unicast-ciphers']) && $security_profile['unicast-ciphers'] !== "" ? $security_profile['unicast-ciphers'] : "-"}}</td>
                    @if ($security_profile['default']=="true")
                    <td><label class="badge badge-success">True</label></td>
                    @else
                    <td><label class="badge badge-danger">False</label></td>
                    @endif
                    <td>
                        <a class="btn btn-outline-info btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-information-outline"></i></a>
                        <a class="btn btn-outline-dark btn-fw btn-rounded btn-sm"  href="#"><i class="mdi mdi-pencil"></i></a>
                        @if ($security_profile['wpa2-pre-shared-key'] !== "")
                        <a class="btn btn-outline-warning btn-fw btn-rounded btn-sm" href="#" onclick="sp_psk('{{$security_profile['wpa2-pre-shared-key']}}')"><i class="mdi mdi-key"></i></a>
                        @endif
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
            @else
            <p>Could not load info.</p>
            <p>Error: <b>{{$conn_error}}</b></p>
            @endif
        </div>
    </div>
</div>
@if ($security_profiles != null)
<div class="d-grid gap-2">
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('SecurityProfiles.create') }}"><i class="mdi mdi-plus-circle"></i> Add new security profile</a>
</div>
@endif
@endsection