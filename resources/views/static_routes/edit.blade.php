@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Static Route</h4>
            <p class="card-description">
                Here you can add a new Static Route
            </p>
            <form method="POST" action="{{route('StaticRoutes.store')}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Destination Address</label>
                <div class="col-sm-9">
                    <input type="text" name="dst-address" class="form-control @error('dst-address') is-invalid @enderror" value="{{old('dst-address')}}" placeholder="0.0.0.0/0">
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
                        <option>{{$interface['name']}}</option>
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
                        <option value="ping">Ping</option>
                        <option value="arp">ARP</option>
                        <option value="bfd">BFD</option>
                        <option value="none">None</option>
                    </select>
                    @error('check-gateway')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <br>
                <div class="col-sm-3">
                    <input class="form-check-input" type="checkbox" name="suppress-hw-offload" value="true">
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
                    <input type="text" name="distance" class="form-control @error('distance') is-invalid @enderror" value="{{old('distance')}}" placeholder="0">
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
                    <input type="text" name="scope" class="form-control @error('scope') is-invalid @enderror" value="{{old('scope')}}" placeholder="30">
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
                    <input type="text" name="target-scope" class="form-control @error('target-scope') is-invalid @enderror" value="{{old('target-scope')}}" placeholder="10">
                    @error('target-scope')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <input class="form-check-input" type="checkbox" name="blackhole" value="true">
                    <label class="form-check-label"> &nbsp;Blackhole</label>
                </div>
                @error('blackhole')
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
@endsection