<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>{{env('APP_NAME')}}</title>
</head>
<body class="container-fluid  m-0 p-0 d-flex" style="min-height: 100vh">
    
<div style="width: 300px;" class="m-auto">
    <div class="card shadow-sm">
            <div class="card-body">
    
                <h4 class="mb-4 text-center">{{env('APP_NAME')}}</h4>
    
                @if (session('message'))
                    <div class="text-danger small text-center my-2">
                        {{session('message')}}
                    </div>
                @endif
    
                <form method="POST" action="{{ route('login.auth') }}">
                    @csrf
    
                    <div class="mb-3 small">
                        <label class="form-label">E-mail</label>
                        <input type="email"
                               name="email"
                               class="form-control form-control-sm @error('email') is-invalid @enderror"
                               required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
    
                    <div class="mb-3 small">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                               required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- remember -->
                    <div class="mb-3 small">
                        <div class="form-check">
                            <input class="form-check-input" name="remember" type="checkbox" value="" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember
                            </label>
                        </div>
                        @error('remember') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
    
                    <button type="submit" class="btn btn-primary w-100">
                        Entrar
                    </button>
    
                </form>
            </div>
        </div>
    
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>




