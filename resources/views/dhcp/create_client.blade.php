@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new DHCP Client</h4>
            <p class="card-description">
                Here you can add a new DHCP Client
            </p>
            <form method="POST" action="{{route('storeDhcpClient', $deviceParam)}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Interface</label>
                <div class="col-sm-12">
                    <select class="form-select" name="interface">
                        @foreach ($interfaces as $interface)
                        @if ($interface['type'] != "loopback")
                        <option>{{$interface['name']}}</option>
                        @endif
                        @endforeach
                    </select>
                    @error('interface')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Add default route</label>
                <div class="col-sm-12">
                    <select class="form-select" name="add-default-route">
                        <option value="no">No</option>
                        <option value="special-classless">Special classless</option>
                        <option value="yes" selected>Yes</option>
                    </select>
                    @error('interface')
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
                    <input class="form-check-input" type="checkbox" name="use-peer-dns" value="true">
                    <label class="form-check-label"> &nbsp;Use peer DNS</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="use-peer-ntp" value="true">
                    <label class="form-check-label"> &nbsp;Use peer NTP</label>
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
            <form method="POST" action="{{route('dhcp_storeClientCustom', $deviceParam)}}">
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