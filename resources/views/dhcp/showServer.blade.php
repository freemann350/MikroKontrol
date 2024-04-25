@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">DHCP Server "{{$server['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the DHCP Server "{{$server['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($server['name']) ? $server['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Interface</p>
                        <p>
                            {{isset($server['interface']) ? $server['interface'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Relay</p>
                        <p>
                            {{isset($server['relay']) ? $server['relay'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Lease Time</p>
                        <p>
                            {{isset($server['lease-time']) ? $server['lease-time'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Address Pool</p>
                        <p>
                            {{isset($server['address-pool']) ? $server['address-pool'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Authoritative</p>
                        <p>
                            {{isset($server['authoritative']) ? $server['authoritative'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Always Broadcast</p>
                        <p>
                            {{isset($server['always-broadcast']) ? "true" : 'false'}}
                        </p>
                        <p class="fw-bold text-primary">Add ARP For Leases</p>
                        <p>
                            {{isset($server['add-arp']) ? "true" : 'false'}}
                        </p>
                        <p class="fw-bold text-primary">Use Framed As Classless</p>
                        <p>
                            {{isset($server['use-framed-as-classless']) ? "false" : 'true'}}
                        </p>
                        <p class="fw-bold text-primary">Conflict Detection</p>
                        <p>
                            {{isset($server['conflict-detection']) ? "false" : 'true'}}
                        </p>
                    </address>
                </div>
                @if ($server != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$server['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the DHCP Server "{{$server['name']}}", in an unformatted manner
                    </p>
                    <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection