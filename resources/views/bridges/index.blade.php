@extends('template.layout')

@section('main-content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
      <div class="card-body">
          <h4 class="card-title">Interfaces</h4>
          <p class="card-description">
          List of all interfaces on the device (physical/virtual)</code>
          </p>
          <div class="table-responsive">
          <table class="table table-hover table-striped"  style="text-align:center">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Ageing Time</th>
                  <th>MAC</th>
                  <th>MTU (Actual)</th>
                  <th>Connection Status</th>
                  <th>Current Status</th>
              </tr>
              </thead>
              <tbody>
              @foreach($bridges as $bridge)
              <tr>
                  <td>{{ $bridge['.id'] }}</td>
                  <td>{{ $bridge['name'] }}</td>
                  <td>{{ $bridge['ageing-time'] }}</td>
                  <td>{{ $bridge['mac-address'] }}</td>
                  <td>{{ $bridge['mtu'] }} ({{ $bridge['actual-mtu'] }})</td>
                  @if ($bridge['running'] == "true")
                  <td class="text-success"> Connected <i class="ti-arrow-up"></i></td>
                  @else
                  <td class="text-danger"> Not connected <i class="ti-arrow-down"></i></td>
                  @endif
                  @if ($bridge['disabled']=="false")
                  <td><label class="badge badge-success">Enabled</label></td>
                  @else
                  <td><label class="badge badge-danger">Disabled</label></td>
                  @endif
              </tr>
              @endforeach
              </tbody>
          </table>
          </div>
          <br>
          <button onclick="location.reload();" type="button" class="btn btn-success btn-lg btn-block"><i class="mdi mdi-refresh"></i>Refresh info
          </button>
      </div>
  </div>
</div>

<div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Horizontal Form</h4>
                  <p class="card-description">
                    Horizontal form layout
                  </p>
                  <form class="forms-sample">
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="exampleInputMobile" placeholder="Mobile number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Re Password</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-check form-check-flat form-check-primary">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        Remember me
                      </label>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
@endsection