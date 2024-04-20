@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Wireguard server</h4>
            <p class="card-description">
                Here you can add a new Wireguard server
            </p>
            <form method="POST" action="{{route('wireguard_storeServer')}}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="wireguard1">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Port</label>
                <div class="col-sm-9">
                    <input type="text" name="listen-port" class="form-control @error('listen-port') is-invalid @enderror" value="{{old('listen-port')}}" placeholder="13230">
                    @error('listen-port')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">MTU (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="mtu" class="form-control @error('mtu') is-invalid @enderror" value="{{old('mtu')}}" placeholder="1420">
                    @error('mtu')
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