@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Security Profile</h4>
            <p class="card-description">
                Here you can add a new Security Profile for Wireless interfaces
            </p>
            <form method="POST" action="{{route('SecurityProfiles.update', [$deviceParam, $security_profile['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$security_profile['name']}}" placeholder="securityprofile1">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Mode</label>
                <div class="col-sm-12">
                    <select class="form-select" name="mode">
                        <option value="none" {{$security_profile['mode'] == "none" ? "selected" : ""}}>None</option>
                        <option value="dynamic-keys" {{$security_profile['mode'] == "dynamic-keys" ? "selected" : ""}}>Dynamic Keys</option>
                    </select>
                    @error('mode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Security (required if mode is dynamic keys)</label>
                <br>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="wpa2-psk" value="true" {{strpos($security_profile['authentication-types'], "wpa2-psk") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;WPA2-PSK</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="wpa2-eap" value="true" {{strpos($security_profile['authentication-types'], "wpa2-eap") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;WPA2-EAP</label>
                </div>
                @error('authentication-types') 
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Unicast Ciphers (optional, for dynamic keys)</label>
                <br>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="uc-aes-ccm" value="true" {{strpos($security_profile['unicast-ciphers'], "aes-ccm") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;AES CCM</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="uc-tkip" value="true" {{strpos($security_profile['unicast-ciphers'], "tkip") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;TKIP</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Group Ciphers (optional, for dynamic keys)</label>
                <br>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="gc-aes-ccm" value="true" {{strpos($security_profile['group-ciphers'], "aes-ccm") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;AES CCM</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="gc-tkip" value="true" {{strpos($security_profile['group-ciphers'], "tkip") !== false ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;TKIP</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">WPA2-Pre-Shared Key</label>
                <div class="col-sm-12">
                    <input type="text" name="wpa2-pre-shared-key" class="form-control @error('wpa2-pre-shared-key') is-invalid @enderror" value="{{$security_profile['wpa2-pre-shared-key']}}" placeholder="Your SP password">
                    @error('wpa2-pre-shared-key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Supplicant Identity</label>
                <div class="col-sm-12">
                    <input type="text" name="supplicant-identity" class="form-control @error('supplicant-identity') is-invalid @enderror" value="{{$security_profile['supplicant-identity']}}" placeholder="Your SP EAP supplicant">
                    @error('supplicant-identity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Group Key Update</label>
                <div class="col-sm-12">
                    <input type="text" name="group-key-update" class="form-control @error('group-key-update') is-invalid @enderror" value="{{$security_profile['group-key-update']}}" placeholder="HH:MM:SS">
                    @error('group-key-update')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Management Protection</label>
                <div class="col-sm-12">
                    <select class="form-select" name="management-protection">
                        <option value="allowed" {{$security_profile['management-protection'] == "allowed" ? "selected" : ""}}>Allowed</option>
                        <option value="disabled" {{$security_profile['management-protection'] == "disabled" ? "selected" : ""}}>Disabled</option>
                        <option value="required" {{$security_profile['management-protection'] == "required" ? "selected" : ""}}>Required</option>
                    </select>
                    @error('management-protection')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Management Protection Key</label>
                <div class="col-sm-12">
                    <input type="text" name="management-protection-key" class="form-control @error('management-protection-key') is-invalid @enderror" value="{{$security_profile['management-protection-key']}}" placeholder="Your SP EAP supplicant">
                    @error('management-protection-key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" name="disable-pmkid" value="true" {{$security_profile['disable-pmkid'] == "true" ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Disable PMKID</label>
                </div>
                @error('unicast-ciphers')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-fw">Submit</button>
            </form>
        </div>
    </div>
</div>
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Custom JSON request (for advanced users only)</h4>
            <p class="card-description">
                Here you can make your own request to the device.
                <br>
                Check the <a href="https://help.mikrotik.com/docs/display/ROS">Mikrotik Support</a> for the correct parameters
            </p>
            <form method="POST" action="{{route('sp_updateCustom',[$deviceParam, $security_profile['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <textarea class="form-control" name="custom" id="custom">{{old('custom')}}</textarea>
                @error('custom')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <p class="btn btn-info btn-fw" onclick="prettyPrint()">Beautify JSON</p><br>
            <button type="submit" class="btn btn-primary btn-fw">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection