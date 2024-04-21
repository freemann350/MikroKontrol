@extends('template.layout')

@section('main-content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add new Static DNS Record</h4>
            <p class="card-description">
                Here you can add a new static DNS record (A Type)
            </p>
            <form method="POST" action="{{route('updateDnsRecord',$record['.id'])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$record['name']}}" placeholder="My DNS record name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{$record['address']}}" placeholder="My record address">
                    @error('address')
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
            <form method="POST" action="{{route('dns_updateRecordCustom',$record['.id'])}}" enctype="multipart/form-data">
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