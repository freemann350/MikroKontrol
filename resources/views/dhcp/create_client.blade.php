@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new DHCP Client</h4>
            <p class="card-description">
                Here you can add a new DHCP Client
            </p>
            <form method="POST" action="{{route('storeDhcpClient')}}">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Interface</label>
                <div class="col-sm-9">
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
                <div class="col-sm-9">
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
                <label class="col-sm-3 col-form-label">Comment (optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="comment" class="form-control @error('comment') is-invalid @enderror" value="{{old('comment')}}" placeholder="defconf">
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
@endsection