@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">DNS Static Record "{{$record['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the DNS Static Record "{{$record['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($record['name']) ? $record['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Address</p>
                        <p>
                            {{isset($record['address']) ? $record['address'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($record != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$record['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the DNS Static Record "{{$record['name']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection