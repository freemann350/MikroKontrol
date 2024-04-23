@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit DNS Server</h4>
            <p class="card-description">
                Here you can edit the device's DNS Server
            </p>
            <form method="POST" action="{{route('storeDnsServer', $deviceParam)}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Servers</label>
                <div class="col-sm-9">
                    <input type="text" name="servers" class="form-control @error('servers') is-invalid @enderror" value="{{$server['servers']}}" placeholder="9.9.9.9,1.1.1.1">
                    @error('servers')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">DoH Servers</label>
                <div class="col-sm-9">
                    <input type="text" name="use-doh-server" class="form-control @error('use-doh-server') is-invalid @enderror" value="{{$server['use-doh-server']}}" placeholder="9.9.9.9,1.1.1.1">
                    @error('use-doh-server')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">DoH max server connections</label>
                <div class="col-sm-9">
                    <input type="text" name="doh-max-server-connections" class="form-control @error('doh-max-server-connections') is-invalid @enderror" value="{{$server['doh-max-server-connections']}}" placeholder="5">
                    @error('doh-max-server-connections')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">DoH max concurrent queries</label>
                <div class="col-sm-9">
                    <input type="text" name="doh-max-concurrent-queries" class="form-control @error('doh-max-concurrent-queries') is-invalid @enderror" value="{{$server['doh-max-concurrent-queries']}}" placeholder="50">
                    @error('doh-max-concurrent-queries')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">DoH timeout</label>
                <div class="col-sm-9">
                    <input type="text" name="doh-timeout" class="form-control @error('doh-timeout') is-invalid @enderror" value="{{$server['doh-timeout']}}" placeholder="HH:MM:SS">
                    @error('doh-timeout')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Max UDP Packet Size</label>
                <div class="col-sm-9">
                    <input type="text" name="max-udp-packet-size" class="form-control @error('max-udp-packet-size') is-invalid @enderror" value="{{$server['max-udp-packet-size']}}" placeholder="4096">
                    @error('max-udp-packet-size')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Query server timeout</label>
                <div class="col-sm-9">
                    <input type="text" name="query-server-timeout" class="form-control @error('query-server-timeout') is-invalid @enderror" value="{{$server['query-server-timeout']}}" placeholder="2">
                    @error('query-server-timeout')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Query total timeout</label>
                <div class="col-sm-9">
                    <input type="text" name="query-total-timeout" class="form-control @error('query-total-timeout') is-invalid @enderror" value="{{$server['query-total-timeout']}}" placeholder="10">
                    @error('query-total-timeout')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <br>
                    <input class="form-check-input @error('allow-remote-requests') is-invalid @enderror"" type="checkbox" name="allow-remote-requests" value="true" {{ $server['allow-remote-requests'] == "true" ? 'checked' : '' }}>
                    <label class="form-check-label @error('allow-remote-requests') is-invalid @enderror""> &nbsp;Allow remote requests</label>
                    @error('allow-remote-requests')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Address list extra time</label>
                <div class="col-sm-9">
                    <input type="text" name="address-list-extra-time" class="form-control @error('address-list-extra-time') is-invalid @enderror" value="{{$server['address-list-extra-time']}}" placeholder="100">
                    @error('address-list-extra-time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Maximum concurrent queries</label>
                <div class="col-sm-9">
                    <input type="text" name="max-concurrent-queries" class="form-control @error('max-concurrent-queries') is-invalid @enderror" value="{{$server['max-concurrent-queries']}}" placeholder="100">
                    @error('max-concurrent-queries')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Max current TCP sessions</label>
                <div class="col-sm-9">
                    <input type="text" name="max-concurrent-tcp-sessions" class="form-control @error('max-concurrent-tcp-sessions') is-invalid @enderror" value="{{$server['max-concurrent-tcp-sessions']}}" placeholder="20">
                    @error('max-concurrent-tcp-sessions')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Cache size</label>
                <div class="col-sm-9">
                    <input type="text" name="cache-size" class="form-control @error('cache-size') is-invalid @enderror" value="{{$server['cache-size']}}" placeholder="2048">
                    @error('cache-size')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Cache max TTL</label>
                <div class="col-sm-9">
                    <input type="text" name="cache-max-ttl" class="form-control @error('cache-max-ttl') is-invalid @enderror" value="{{$server['cache-max-ttl']}}" placeholder="HH:MM:SS">
                    @error('cache-max-ttl')
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
            <form method="POST" action="{{route('dns_storeServerCustom', $deviceParam)}}">
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