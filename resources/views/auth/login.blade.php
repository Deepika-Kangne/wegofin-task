<!DOCTYPE html>
@include('header')
<html>
<head>
    <title>Login</title>
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
    <img src= "{{ asset('img/user.png') }}" height="100px" style="padding: 10px;" alt="Example Image">
    </div>
    <form method="POST" action="/login">
    @csrf
      <input type="email" class="fadeIn second" placeholder="User email" name="email" required>
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <button type="submit" class="fadeIn fourth">Login</button>
    </form>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  </div>
</div>
</body>
</html>


