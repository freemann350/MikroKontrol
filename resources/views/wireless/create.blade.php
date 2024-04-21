@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Wireless</h4>
            <p class="card-description">
                Here you can add a new Wireless interface
            </p>
            <form method="POST" action="{{route('Wireless.store')}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">SSID</label>
                <div class="col-sm-9">
                    <input type="text" name="ssid" class="form-control @error('ssid') is-invalid @enderror" value="{{old('ssid')}}" placeholder="My-WiFi">
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
                        <option value="{{$interface['name']}}">{{$interface['ssid']}} ({{$interface['name']}}, {{$interface['band']}})</option>
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
                        <option>{{$security_profile['name']}}</option>
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
                        <option value="disabled">Disabled</option>
                        <option value="push-button">Push button</option>
                        <option value="push-button-5s">Push button 5 seconds</option>
                        <option value="virtual-push-button-only">Virtual push button only</option>
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
                    <input class="form-check-input" type="checkbox" name="default-authentication" value="true" checked>
                    <label class="form-check-label"> &nbsp;Default Authenticate</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="default-forwarding" value="true" checked>
                    <label class="form-check-label"> &nbsp;Default forward</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hide-ssid" value="true">
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
            <form method="POST" action="{{route('wireless_storeCustom')}}">
            @csrf
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