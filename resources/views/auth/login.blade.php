<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      max-width: 400px;
      width: 100%;
      padding: 30px;
      border-radius: 20px;
      background: #ffffff;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .login-card h3 {
      font-weight: 600;
      color: #495057;
    }
    .form-control {
      border-radius: 12px;
      padding: 12px;
    }
    .btn-custom {
      background: #6c63ff;
      color: #fff;
      border-radius: 12px;
      padding: 10px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #574bdb;
    }
    .text-muted a {
      text-decoration: none;
      color: #6c63ff;
      font-weight: 500;
    }
    .text-muted a:hover {
      color: #574bdb;
    }
  </style>
</head>
<body>
  <div class="login-card shadow-lg">
    <div class="text-center mb-4">
      <h3>Welcome Back</h3>

      <p class="text-muted">Please login to your account</p>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('auth.login.post') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
      </div>
      <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>
   
  </div>
</body>
</html>
