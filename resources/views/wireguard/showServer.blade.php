@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">Wireguard Server "{{$wg['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the Wireguard Server "{{$wg['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($wg['name']) ? $wg['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Port</p>
                        <p>
                            {{isset($wg['listen-port']) ? $wg['listen-port'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Public Key</p>
                        <p>
                            {{isset($wg['public-key']) ? $wg['public-key'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">MTU</p>
                        <p>
                            {{isset($wg['mtu']) ? $wg['mtu'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($wg != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$wg['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the Wireguard Server "{{$wg['name']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection