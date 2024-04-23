@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Bridge</h4>
            <p class="card-description">
                Here you can add a new Bridge interface
            </p>
            <form method="POST" action="{{route('Bridges.update',[$deviceParam, $bridge['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$bridge['name']}}" placeholder="bridge1" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Ageing time (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="ageing-time" class="form-control @error('ageing-time') is-invalid @enderror" value="{{isset($bridge['ageing-time']) ? $bridge['ageing-time'] : '' }}" placeholder="00:05:00">
                    @error('ageing-time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">MTU (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="mtu" class="form-control @error('mtu') is-invalid @enderror" value="{{isset($bridge['mtu']) ? $bridge['mtu'] : '' }}" placeholder="1500">
                    @error('mtu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">MAC Address (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="admin-mac" class="form-control @error('admin-mac') is-invalid @enderror" value="{{ isset($bridge['admin-mac']) ? $bridge['admin-mac'] : '' }}" placeholder="AA:BB:CC:DD:EE:FF">
                    @error('admin-mac')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input class="form-check-input @error('dhcp-snooping') is-invalid @enderror"" type="checkbox" name="dhcp-snooping" value="1" {{ $bridge['dhcp-snooping'] == "true" ? 'checked' : '' }}>
                    <label class="form-check-label @error('dhcp-snooping') is-invalid @enderror""> &nbsp;DHCP Snooping</label>
                    @error('dhcp-snooping')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
            <form method="POST" action="{{route('bridge_updateCustom',[$deviceParam, $bridge['.id']])}}" enctype="multipart/form-data">
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