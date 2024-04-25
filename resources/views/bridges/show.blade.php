@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">Bridge "{{$bridge['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the Bridge "{{$bridge['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($bridge['name']) ? $bridge['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Ageing Time</p>
                        <p>
                            {{isset($bridge['ageing-time']) ? $bridge['ageing-time'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">MTU (Actual MTU)</p>
                        <p>
                            {{isset($bridge['mtu']) ? $bridge['mtu'] : '-'}} ({{isset($bridge['actual-mtu']) ? $bridge['actual-mtu'] : '-'}})
                        </p>
                        <p class="fw-bold text-primary">MAC Address</p>
                        <p>
                            {{isset($bridge['mac-address']) ? $bridge['mac-address'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">DHCP Snooping</p>
                        <p>
                            {{isset($bridge['dhcp-snooping']) ? $bridge['dhcp-snooping'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($bridge != null)
                <div class="col-md-6">
                    <h4 class="card-title">{{$bridge['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the Bridge "{{$bridge['name']}}", in an unformatted manner
                    </p>
                    <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection