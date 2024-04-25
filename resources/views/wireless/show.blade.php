@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">WLAN "{{$wireless['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the WLAN "{{$wireless['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($wireless['name']) ? $wireless['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">SSID</p>
                        <p>
                            {{isset($wireless['ssid']) ? $wireless['ssid'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Master Interface</p>
                        <p>
                            {{isset($wireless['master-interface']) ? $wireless['master-interface'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Security Profile</p>
                        <p>
                            {{isset($wireless['security-profile']) ? $wireless['security-profile'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">WPS Mode</p>
                        <p>
                            {{isset($wireless['wps-mode']) ? $wireless['wps-mode'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Default Authentication</p>
                        <p>
                            {{isset($wireless['default-authentication']) ? $wireless['default-authentication'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Default Forwarding</p>
                        <p>
                            {{isset($wireless['default-forwarding']) ? $wireless['default-forwarding'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Hide SSID</p>
                        <p>
                            {{isset($wireless['hide-ssid']) ? $wireless['hide-ssid'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($wireless != null)
                <div class="col-md-6">
                    <h4 class="card-title">{{$wireless['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the WLAN "{{$wireless['name']}}", in an unformatted manner
                    </p>
                    <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection