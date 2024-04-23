@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new DHCP Client</h4>
            <p class="card-description">
                Here you can add a new DHCP Client
            </p>
            <form method="POST" action="{{route('updateDhcpClient',[$deviceParam, $client['.id']])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Interface</label>
                <div class="col-sm-9">
                    <select class="form-select" name="interface">
                        @foreach ($interfaces as $interface)
                        @if ($interface['type'] != "loopback")
                        <option {{$client['interface'] == $interface['name'] ? "selected" : ""}}>{{$interface['name']}}</option>
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
                <div class="col-sm-9">
                    <select class="form-select" name="add-default-route">
                        <option value="no" {{$client['add-default-route'] == "no" ? "selected" : ""}}>No</option>
                        <option value="special-classless" {{$client['add-default-route'] == "special-classless" ? "selected" : ""}}>Special classless</option>
                        <option value="yes" {{$client['add-default-route'] == "yes" ? "selected" : ""}}>Yes</option>
                    </select>
                    @error('interface')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Comment (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="comment" class="form-control @error('comment') is-invalid @enderror" value="{{isset($client['comment']) ? $client['comment'] : ""}}" placeholder="defconf">
                    @error('comment')
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
                    <input class="form-check-input" type="checkbox" name="use-peer-dns" value="true" {{$client['use-peer-dns']  == "true" ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Use peer DNS</label>
                </div>
                <div class="col-sm-3 form-check-inline">
                    <input class="form-check-input" type="checkbox" name="use-peer-ntp" value="true" {{$client['use-peer-ntp']  == "true" ? "checked" : ""}}>
                    <label class="form-check-label"> &nbsp;Use peer NTP</label>
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
            <form method="POST" action="{{route('dhcp_updateClientCustom',[$deviceParam, $client['.id']])}}" enctype="multipart/form-data">
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