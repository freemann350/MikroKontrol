<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>MikroKontrol - Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
  <link rel="stylesheet" href="{{ url('css/login/style.css') }}">
  <link rel="stylesheet" href="{{ url('vendors/css/vendor.bundle.base.css') }}">
  <link rel="shortcut icon" href="{{ url('img/favicon.png') }}" />
<style>    
  canvas {
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
  }

  img {
    display: block;
    margin: -20px auto 50px;
    width: 100px; /* Adjust image width as needed */
    height: auto;
  }

  p {
    text-align: center;
  }

  .invalid-feedback {
    color: #dc3545;
  }
</style>
</head>
<body>
  <canvas id=c></canvas>

  <!-- partial:index.partial.html -->
  <form method="POST" action="{{ route('Auth.login') }}">
  <div class="screen-1">
    <div>
      <strong><i><p>MikroKontrol</p></i></strong>
    </div>
    <img src="https://merch.mikrotik.com/cdn/shop/files/512.png?v=1657867177" alt="MikroTik Logo">
      @csrf
      <div class="email">
        <label for="email">Email Address</label>
        <div class="sec-2">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" name="email" placeholder="user@mail.org" value="{{old('email')}}">
        </div>
        @error('email')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>

      <div class="password">
        <label for="password">Password</label>
        <div class="sec-2">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input class="pas" type="password" name="password" placeholder="••••••••" value="{{old('password')}}">
        </div>
        @error('password')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>
      <button type="submit" class="login">Login</button>
    </div>
  </form>

  <!-- partial -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="{{ url('js/login/p5_bg.js') }}"></script>
  <script src="{{ url('js/login/p5.js') }}"></script>
  
</body>
</html>
