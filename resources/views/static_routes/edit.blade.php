@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Static Route</h4>
            <p class="card-description">
                Here you can add a new Static Route
            </p>
            <form method="POST" action="{{route('StaticRoutes.update',[$deviceParam, $route['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Destination Address</label>
                <div class="col-sm-9">
                    <input type="text" name="dst-address" class="form-control @error('dst-address') is-invalid @enderror" value="{{$route['dst-address']}}" placeholder="0.0.0.0/0">
                    @error('dst-address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Gateway</label>
                <div class="col-sm-9">
                    <select class="form-select" name="gateway">
                        @foreach ($interfaces as $interface)
                        <option {{$route['gateway'] == $interface['name'] ? "selected" : ""}}>{{$interface['name']}}</option>
                        @endforeach
                    </select>
                    @error('gateway')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Check Gateway</label>
                <div class="col-sm-9">
                    <select class="form-select" name="check-gateway">
                        <option value="ping" {{ isset($route['check-gateway']) && $route['check-gateway'] == "ping" ? "selected" : ""}}>Ping</option>
                        <option value="arp" {{isset($route['check-gateway']) && $route['check-gateway'] == "arp" ? "selected" : ""}}>ARP</option>
                        <option value="none" {{isset($route['check-gateway']) && $route['check-gateway'] == "none" ? "selected" : ""}}>None</option>
                    </select>
                    @error('check-gateway')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <br>
                <div class="col-sm-3">
                    <input class="form-check-input" type="checkbox" name="suppress-hw-offload" value="true" {{$route['suppress-hw-offload'] == true ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Suppress hw offload</label>
                </div>
                @error('suppress-hw-offload')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Distance (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="distance" class="form-control @error('distance') is-invalid @enderror" value="{{$route['distance']}}" placeholder="0">
                    @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Scope (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="scope" class="form-control @error('scope') is-invalid @enderror" value="{{$route['scope']}}" placeholder="30">
                    @error('scope')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Target Scope (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="target-scope" class="form-control @error('target-scope') is-invalid @enderror" value="{{isset($route['target-scope']) ? $route['target-scope'] : ""}}" placeholder="10">
                    @error('target-scope')
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
            <form method="POST" action="{{route('sr_updateCustom',[$deviceParam, $route['.id']])}}" enctype="multipart/form-data">
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