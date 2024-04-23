@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Wireless</h4>
            <p class="card-description">
                Here you can add a new Wireless interface
            </p>
            <form method="POST" action="{{route('Wireless.update', [$deviceParam, $wireless['.id']])}}"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">SSID</label>
                <div class="col-sm-9">
                    <input type="text" name="ssid" class="form-control @error('ssid') is-invalid @enderror" value="{{$wireless['ssid']}}" placeholder="My-WiFi">
                    @error('ssid')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Master Interface</label>
                <div class="col-sm-9">
                    <select class="form-select" name="master-interface">
                        @foreach ($interfaces as $interface)
                        @if (isset($interface['band']))
                        <option value="{{$interface['name']}}" {{$wireless['name'] == $interface['name'] ? 'selected': ''}}>{{$interface['ssid']}} ({{$interface['name']}}, {{$interface['band']}})</option>
                        @endif
                        @endforeach
                    </select>
                    @error('master-interface')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Security Profile</label>
                <div class="col-sm-9">
                    <select class="form-select" name="security-profile">
                        @foreach ($security_profiles as $security_profile)
                        <option {{$wireless['security-profile'] == $security_profile['name'] ? 'selected': ''}}>{{$security_profile['name']}}</option>
                        @endforeach
                    </select>
                    @error('security-profile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">WPS Mode</label>
                <div class="col-sm-9">
                    <select class="form-select" name="wps-mode">
                        <option value="disabled" {{$wireless['wps-mode'] == "disabled" ? 'selected': ''}}>Disabled</option>
                        <option value="push-button" {{$wireless['wps-mode'] == "push-button" ? 'selected': ''}}>Push button</option>
                        <option value="push-button-5s" {{$wireless['wps-mode'] == "push-button-5s" ? 'selected': ''}}>Push button 5 seconds</option>
                        <option value="virtual-push-button-only" {{$wireless['wps-mode'] == "virtual-push-button-only" ? 'selected': ''}}>Virtual push button only</option>
                    </select>
                    @error('wps-mode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Options</label>
                <br>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="default-authentication" value="true" {{$wireless['default-authentication'] == "true" ? 'checked': ''}}>
                    <label class="form-check-label"> &nbsp;Default Authenticate</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="default-forwarding" value="true" {{$wireless['default-forwarding'] == "true" ? 'checked': ''}}>
                    <label class="form-check-label"> &nbsp;Default forward</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hide-ssid" value="true" {{$wireless['hide-ssid'] == "true" ? 'checked': ''}}>
                    <label class="form-check-label"> &nbsp;Hide SSID</label>
                </div>
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
            <form method="POST" action="{{route('wireless_updateCustom',[$deviceParam, $wireless['.id']])}}" enctype="multipart/form-data">
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