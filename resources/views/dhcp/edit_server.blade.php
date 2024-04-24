@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new DHCP Server</h4>
            <p class="card-description">
                Here you can add a new DHCP Server
            </p>
            <form method="POST" action="{{route('updateDhcpServer',[$deviceParam,$server['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$server['name']}}" placeholder="defconf">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Interface</label>
                <div class="col-sm-12">
                    <select class="form-select" name="interface">
                        @foreach ($interfaces as $interface)
                        @if ($interface['type'] != "loopback")
                        <option {{$server['interface'] == $interface['name'] ? "selected" : ""}}>{{$interface['name']}}</option>
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
                <label class="col-sm-3 col-form-label">Relay (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="relay" class="form-control @error('relay') is-invalid @enderror" value="{{isset($server['relay'])? $server['relay'] : ""}}" placeholder="0.0.0.0">
                    @error('relay')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Lease Time (optional)</label>
                <div class="col-sm-12">
                    <input type="text" name="lease-time" class="form-control @error('lease-time') is-invalid @enderror" value="{{$server['lease-time']}}" placeholder="00:10:00">
                    @error('lease-time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Address pool</label>
                <div class="col-sm-12">
                    <select class="form-select" name="address-pool">
                        <option value="static-only" {{$server['interface'] == "static-only" ? "selected" : ""}}>Static only</option>
                        <option value="default-dhcp" {{$server['interface'] == "default-dhcp" ? "selected" : ""}}>Default DHCP</option>
                    </select>
                    @error('address-pool')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Authoritative</label>
                <div class="col-sm-12">
                    <select class="form-select" name="authoritative">
                        <option value="after-2s-delay" {{$server['authoritative'] == "after-2s-delay" ? "selected" : ""}}>After 2s delay</option>
                        <option value="after-10s-delay" {{$server['authoritative'] == "after-10s-delay" ? "selected" : ""}}>After 10s delay</option>
                        <option value="no" {{!isset($server['authoritative']) ? "selected" : ""}}>No</option>
                        <option value="yes" {{$server['authoritative'] == "yes" ? "selected" : ""}}>Yes</option>
                    </select>
                    @error('address-pool')
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
                    <input class="form-check-input" type="checkbox" name="always-broadcast" value="true" {{isset($server['always-broadcast']) ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Always broadcast</label>
                    @error('always-broadcast')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="add-arp" value="true" {{isset($server['add-arp']) ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Add ARP for leases</label>
                    @error('add-arp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="use-framed-as-classless" value="true" {{!isset($server['use-framed-as-classless']) ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Use framed as classless</label>
                    @error('use-framed-as-classless')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="conflict-detection" value="true" {{!isset($server['conflict-detection']) ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Conflict detection</label>
                    @error('conflict-detection')
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
            <form method="POST" action="{{route('dhcp_updateServerCustom',[$deviceParam, $server['.id']])}}" enctype="multipart/form-data">
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