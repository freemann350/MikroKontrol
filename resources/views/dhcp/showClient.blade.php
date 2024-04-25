@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">DHCP Client "{{$client['interface']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the DHCP Client "{{$client['interface']}}"
                        </p>
                        <p class="fw-bold text-primary">Address</p>
                        <p>
                            {{isset($client['interface']) ? $client['interface'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Add Default Route</p>
                        <p>
                            {{isset($client['add-default-route']) ? $client['add-default-route'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Use Peer DNS</p>
                        <p>
                            {{isset($client['use-peer-dns']) ? $client['use-peer-dns'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Use Peer NTP</p>
                        <p>
                            {{isset($client['use-peer-ntp']) ? $client['use-peer-ntp'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($client != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$client['interface']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the DHCP Client "{{$client['interface']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection