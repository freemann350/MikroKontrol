@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Security Profiles</h4>
            <p class="card-description">
            List of all security profiles for wireless interfaces on the device
            </p>
            <div class="table-responsive">
            <table class="table table-hover table-striped" style="text-align:center" id="dt">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Auth Type</th>
                    <th>Unicast Ciphers</th>
                    <th>Default SP</th>
                    <th>PSK</th>
                </tr>
                </thead>
                <tbody>
                @foreach($security_profiles as $security_profiles)
                <tr>
                    <td>{{ $security_profiles['.id'] }}</td>
                    <td>{{ $security_profiles['name'] }}</td>
                    <td>{{ $security_profiles['authentication-types'] }}</td>
                    <td>{{ $security_profiles['unicast-ciphers'] }}</td>
                    @if ($security_profiles['default']=="true")
                    <td><label class="badge badge-success">True</label></td>
                    @else
                    <td><label class="badge badge-danger">False</label></td>
                    @endif
                    <td><p class="security-profile">{{ $security_profiles['wpa2-pre-shared-key'] }}</p></td>
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
  <a class="btn btn-success btn-lg btn-block" href="{{ route ('SecurityProfiles.create') }}"><i class="mdi mdi-plus-circle"></i> Add new security profile</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tdElement = document.querySelector('.security-profile');

        var originalValue = tdElement.textContent.trim();
        var maskedValue = "(hover to reveal)";

        // Hide the original value and display the masked value
        tdElement.textContent = maskedValue;

        // Add event listeners to show the original value when hovered
        tdElement.addEventListener('mouseover', function() {
            tdElement.textContent = originalValue;
        });

        tdElement.addEventListener('mouseleave', function() {
            tdElement.textContent = maskedValue;
        });
    });
</script>
@endsection