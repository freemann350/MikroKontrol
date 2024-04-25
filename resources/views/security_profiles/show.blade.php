@extends('template.layout')

@section('main-content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h4 class="card-title">Security profile "{{$security_profile['name']}}" Form Info</h4>
                        <p class="card-description">
                            Shows information of the Security profile "{{$security_profile['name']}}"
                        </p>
                        <p class="fw-bold text-primary">Name</p>
                        <p>
                            {{isset($security_profile['name']) ? $security_profile['name'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Mode</p>
                        <p>
                            {{isset($security_profile['mode']) ? $security_profile['mode'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Security</p>
                        <p>
                            {{isset($security_profile['authentication-types']) ? $security_profile['authentication-types'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Unicast Ciphers </p>
                        <p>
                            {{isset($security_profile['unicast-ciphers']) ? $security_profile['unicast-ciphers'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Group Ciphers </p>
                        <p>
                            {{isset($security_profile['group-ciphers']) ? $security_profile['group-ciphers'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Supplicant Identity</p>
                        <p>
                            {{isset($security_profile['supplicant-identity']) ? $security_profile['supplicant-identity'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Group Key Update</p>
                        <p>
                            {{isset($security_profile['group-key-update']) ? $security_profile['group-key-update'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Management Protection</p>
                        <p>
                            {{isset($security_profile['management-protection']) ? $security_profile['management-protection'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">Management Protection Key</p>
                        <p>
                            {{isset($security_profile['management-protection-key']) ? $security_profile['management-protection-key'] : '-'}}
                        </p>
                        <p class="fw-bold text-primary">PMKID</p>
                        <p>
                            {{isset($security_profile['disable-pmkid']) ? $security_profile['disable-pmkid'] : '-'}}
                        </p>
                    </address>
                </div>
                @if ($security_profile != null)
                <div class="col-md-6" >
                    <h4 class="card-title">{{$security_profile['name']}}'s JSON Data</h4>
                    <p class="card-description">
                        Shows all information of the Bridge "{{$security_profile['name']}}", in an unformatted manner
                    </p>
                     <pre>{{$json}}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection