@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">DNS Static Record "{{$wg['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the DNS Static Record "{{$wg['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($wg['name']) ? $wg['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Interface</p>
                        <p>
                            {{isset($wg['interface']) ? $wg['interface'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Public Key</p>
                        <p>
                            {{isset($wg['public-key']) ? $wg['public-key'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Endpoint</p>
                        <p>
                            {{isset($wg['endpoint-address']) ? $wg['endpoint-address'] : '-'}}:{{isset($wg['endpoint-port']) ? $wg['endpoint-port'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Allowed Address</p>
                        <p>
                            {{isset($wg['allowed-address']) ? $wg['allowed-address'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Persistent Keepalive</p>
                        <p>
                            {{isset($wg['persistent-keepalive']) ? $wg['persistent-keepalive'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($wg != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$wg['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the DNS Static Record "{{$wg['name']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection