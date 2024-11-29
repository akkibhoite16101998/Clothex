
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clothex The Men Wear</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <!--<link rel="stylesheet" href="../assets/css/styles.min.css" />-- >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-1 w-100">
                  <img src="../assets/images/logos/clothexlogo.jfif" width="120" style="border-radius: 50%;" alt="">
                </a>
                <p class="text-center">Where Is Fashion Meets Passion</p>
              <div class="card-body">
                <form action="{{ route('user.create') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control @error('user_name') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('user_name')
                        <p class="invalid-feedback " style="color: red;">{{ $message }}</p> 
                        @enderror
                  </div>
                  <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email Id</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('email')
                        <p class="invalid-feedback " style="color: red;">{{ $message }}</p> 
                        @enderror
                    </div>
                 
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1">
                        @error('password')
                        <p class="invalid-feedback " style="color: red;">{{ $message }}</p> 
                        @enderror  
                    </div>

                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Comfirm Password</label>
                        <input type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="exampleInputPassword1">
                        @error('password_confirmation')
                        <p class="invalid-feedback " style="color: red;">{{ $message }}</p> 
                        @enderror  
                    </div>

                    <div class="mb-4">
                        <label for="roleSelect" class="form-label">Role</label>
                        <select class="form-control" id="roleSelect" name="user_role">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        </select>
                    </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('welcome') }}">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}" ></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}" ></script>
  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>-->
</body>

</html>