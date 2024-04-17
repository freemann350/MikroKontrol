@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Address</h4>
            <p class="card-description">
                Here you can add a new IP Address
            </p>
            <form method="POST" action="{{route('IPAddresses.store')}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="0.0.0.0/0" required>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Network</label>
                <div class="col-sm-9">
                    <input type="text" name="network" class="form-control @error('network') is-invalid @enderror" value="{{old('network')}}" placeholder="0.0.0.0">
                    @error('network')
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
                        <option>{{$interface['name']}}</option>
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
                <label class="col-sm-3 col-form-label">Comment (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="comment" class="form-control @error('comment') is-invalid @enderror" value="{{old('comment')}}" placeholder="My interface">
                    @error('comment')
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