@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Wireguard peer</h4>
            <p class="card-description">
                Here you can add a new Wireguard peer
            </p>
            <form method="POST" action="{{route('wireguard_updateClient',$wg['.id'])}}"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$wg['name']}}" placeholder="wireguard1">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Interface</label>
                <div class="col-sm-9">
                    <select class="form-select" name="interface">
                        @foreach ($interfaces as $interface)
                        @if ($interface['type'] == "wg")
                        <option {{$wg['interface'] == $interface['name'] ? 'selected' : ''}}>{{$interface['name']}}</option>
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
                <label class="col-sm-3 col-form-label">Public Key</label>
                <div class="col-sm-9">
                    <input type="text" name="public-key" class="form-control @error('public-key') is-invalid @enderror" value="{{$wg['public-key']}}" placeholder="<wg public key>">
                    @error('public-key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Private Key (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="private-key" class="form-control @error('private-key') is-invalid @enderror" value="{{$wg['private-key']}}" placeholder="auto">
                    <br>
                    <div class="col-sm-3 form-check-inline">
                        <input class="form-check-input" type="checkbox" name="auto-pk" value="true">
                        <label class="form-check-label"> &nbsp;Auto</label>
                    </div>
                    @error('private-key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="endpoint-address" class="form-control @error('endpoint-address') is-invalid @enderror" value="{{$wg['endpoint-address']}}" placeholder="0.0.0.0">
                    @error('endpoint-address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Endpoint port (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="endpoint-port" class="form-control @error('endpoint-port') is-invalid @enderror" value="{{$wg['endpoint-port']}}" placeholder="1024-65535">
                    @error('endpoint-port')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Allowed Address</label>
                <div class="col-sm-9">
                    <input type="text" name="allowed-address" class="form-control @error('allowed-address') is-invalid @enderror" value="{{$wg['allowed-address']}}" placeholder="0.0.0.0/0">
                    @error('allowed-address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Preshared Key (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="preshared-key" class="form-control @error('preshared-key') is-invalid @enderror" value="{{$wg['preshared-key']}}" placeholder="auto">
                    <br>
                    <div class="col-sm-3 form-check-inline">
                        <input class="form-check-input" type="checkbox" name="auto-psk" value="true">
                        <label class="form-check-label"> &nbsp;Auto</label>
                    </div>
                    @error('preshared-key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Persistent Keepalive (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="persistent-keepalive" class="form-control @error('persistent-keepalive') is-invalid @enderror" value="{{isset($wg['persistent-keepalive']) ? $wg['persistent-keepalive'] : ''}}" placeholder="HH:MM:SS">
                    @error('persistent-keepalive')
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
@endsection