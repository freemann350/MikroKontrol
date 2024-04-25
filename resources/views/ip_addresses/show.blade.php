@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">IP Address "{{$address['address']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the IP Address "{{$address['address']}}"
                        </p>
                        <p class="fw-bold text-primary">Address</p>
                        <p>
                            {{isset($address['address']) ? $address['address'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Network</p>
                        <p>
                            {{isset($address['network']) ? $address['network'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Interface</p>
                        <p>
                            {{isset($address['interface']) ? $address['interface'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($address != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$address['address']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the IP Address "{{$address['address']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection