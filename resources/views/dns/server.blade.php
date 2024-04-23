@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">DNS Info</h4>
            <p class="card-description">
                Shows all information of the router's DNS
            </p>
            @if ($server != null)
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">Servers</h4>
                        <p class="fw-bold text-primary">DNS Servers</p>
                        <p>
                            {{ $server['servers'] != "" ? $server['servers'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Dynamic DNS Servers</p>
                        <p>
                            {{ $server['dynamic-servers'] != "" ? $server['dynamic-servers'] : '-'}}
                        </p>
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                    <h4 class="card-title">DoH</h4>
                    <p class="fw-bold text-primary">
                        DoH Server
                    </p>
                    <p class="mb-2">
                        @if ($server['use-doh-server'] != "")
                            {{ $server['use-doh-server'] }} ({{ $server['verify-doh-cert'] ==  "false" ? "unverified" : "verified" }})
                        @else
                        -
                        @endif
                    
                    </p>
                    <p class="fw-bold text-primary">
                    Maximum concurrent queries
                    </p>
                    <p>
                    {{ $server['doh-max-concurrent-queries'] }}
                    </p>
                    <p class="fw-bold text-primary">
                    Maximum server connections
                    </p>
                    <p>
                    {{ $server['doh-max-server-connections'] }}
                    </p>
                    <p class="fw-bold text-primary">
                        Timeout
                    </p>
                    <p>
                    {{ $server['doh-timeout'] }}
                    </p>
                    </address>
                </div>
            </div>
            <hr>
            <div class="row">
                <h4 class="card-title">General</h4>
                <div class="col-md-6">
                    <address>
                        <p class="fw-bold text-primary">Remote requests</p>
                        <p>
                            {{ $server['allow-remote-requests'] == "true" ? "Allowed" : "Not allowed"}}
                        </p>
                        <p class="fw-bold text-primary">Address list extra time</p>
                        <p>
                            {{ $server['address-list-extra-time'] }}
                        </p>
                        <p class="fw-bold text-primary">
                        Maximum concurrent queries
                        </p>
                        <p>
                        {{ $server['max-concurrent-queries'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Maximum concurrent TCP sessions
                        </p>
                        <p>
                        {{ $server['max-concurrent-tcp-sessions'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Maximum UDP packet size
                        </p>
                        <p>
                            {{ $server['max-udp-packet-size'] }}
                        </p>
                        <p class="fw-bold text-primary">VRF</p>
                        <p>
                            {{ $server['vrf'] }}
                        </p>
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                        <p class="fw-bold text-primary">
                            Cache size
                        </p>
                        <p>
                            {{ $server['cache-size'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Cache maximum TTL
                        </p>
                        <p class="mb-2">
                            {{ $server['cache-max-ttl'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Cache used
                        </p>
                        <p>
                        {{ $server['cache-used'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Query server timeout
                        </p>
                        <p>
                        {{ $server['query-server-timeout'] }}
                        </p>
                        <p class="fw-bold text-primary">
                            Query total timeout
                        </p>
                        <p>
                        {{ $server['query-total-timeout'] }}
                        </p>
                    </address>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-block">
                <a class="btn btn-success btn-lg btn-block" href="{{route('editDnsServer', $deviceParam)}}"><i class="mdi mdi-pencil"></i> Edit router DNS</a>
                <button onclick="location.reload();" type="button" class="btn btn-info btn-lg btn-block"><i class="mdi mdi-refresh"></i>Refresh info</button>
            </div>
            @else
            <p>Could not load info.</p>
            <p>Error: <b>{{$conn_error}}</b></p>
            @endif
        </div>
    </div>
</div>
<div class="d-grid gap-2">
</div>
@endsection