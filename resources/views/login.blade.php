<!DOCTYPE html>

<html lang="en">
<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="description" content="A modern CRM Dashboard Template with reusable and flexible components for your SaaS web applications by hencework. Based on Bootstrap."/>

	<!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="{{asset('/')}}favicon.ico" type="image/x-icon">

	<!-- CSS -->
    <link href="{{asset('/')}}dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
   	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-footer="simple">
		<!-- Main Content -->
		<div class="hk-pg-wrapper py-0">
			<div class="hk-pg-body py-0">
				<!-- Container -->
				<div class="container-fluid">
					<!-- Row -->
					<div class="row auth-split">
						<div class="col-xl-5 col-lg-6 col-md-7 position-relative mx-auto">
							<div class="auth-content flex-column pt-8 pb-md-8 pb-13">
								<div class="text-center mb-7">
									<a class="navbar-brand me-0" href="index.html">
										<img class="brand-img d-inline-block w-50" src="{{asset('/')}}dist/img/logo-bapas-panjang.png" alt="brand">
									</a>
								</div>
								<form class="w-100" action="{{route('auth-admin')}}" method="post">
                                    @csrf
									<div class="row">
										<div class="col-xl-7 col-sm-10 mx-auto">
											<div class="text-center mb-4">
												<h4>Masuk dengan akun</h4>
												<p>Silakan masuk ke akun Anda dengan menggunakan nama pengguna dan kata sandi yang sudah terdaftar</p>
											</div>
											<div class="row gx-3">

												@if ($errors->any())
												<div class="alert alert-inv alert-inv-danger alert-wth-icon alert-dismissible fade show" role="alert">
													<span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{$errors->all()[0]}}
													<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
												</div>
												@endif
												<div class="form-group col-lg-12">
													<div class="form-label-group">
														<label>Email</label>
													</div>
													<input class="form-control" placeholder="Enter username or email ID" name="email" value="" type="text" autocomplete="off">
												</div>
												<div class="form-group col-lg-12">
													<div class="form-label-group">
														<label>Password</label>
														<a href="#" class="fs-7 fw-medium">Forgot Password ?</a>
													</div>
													<div class="input-group password-check">
														<span class="input-affix-wrapper affix-wth-text">
															<input class="form-control" placeholder="Enter your password" value="" name="password" type="password" autocomplete="off">
															<a href="#" class="input-suffix text-primary text-uppercase fs-8 fw-medium">
																<span>Show</span>
																<span class="d-none">Hide</span>
															</a>
														</span>
													</div>
												</div>
											</div>
											<div class="d-flex justify-content-center">
												<div class="form-check form-check-sm mb-3">
													<input type="checkbox" class="form-check-input" id="logged_in" checked>
													<label class="form-check-label text-muted fs-7" for="logged_in">Keep me logged in</label>
												</div>
											</div>
                                            <input type="submit" id="kt_sign_in_submit" class="btn btn-primary btn-uppercase btn-block" value="Login">

										</div>
									</div>
								</form>
							</div>
							<!-- Page Footer -->
							<div class="hk-footer border-0">
								<footer class="container-xxl footer">
									<div class="row">
										<div class="col-xl-8 text-center">
											<p class="footer-text pb-0"><span class="copy-text">DSM Absen © 2023 All rights reserved.</span> <a href="#" class="" target="_blank">Privacy Policy</a><span class="footer-link-sep">|</span><a href="#" class="" target="_blank">T&C</a><span class="footer-link-sep">|</span><a href="#" class="" target="_blank">System Status</a></p>
										</div>
									</div>
								</footer>
							</div>
							<!-- / Page Footer -->
						</div>
						<div class="col-xl-7 col-lg-6 col-md-5 col-sm-10 d-md-block d-none position-relative bg-primary-light-5">
							<div class="auth-content flex-column text-center py-8">
								<div class="row">
									<div class="col-xxl-7 col-xl-8 col-lg-11 mx-auto">
										<h2 class="mb-4">DSM Absen dan Payroll</h2>
										<p>Aplikasi absensi dan penggajian memberikan kemudahan bagi perusahaan untuk mengelola kehadiran dan gaji karyawan secara terintegrasi dalam satu platform, sehingga dapat mempercepat proses administrasi dan meningkatkan produktivitas bisnis secara keseluruhan</p>
									</div>
								</div>
								<img src="{{asset('/')}}dist/img/attedance.png"  class="img-fluid w-sm-50 mt-7" alt="login"/>
							</div>
							{{-- <p class="p-xs credit-text opacity-55">All Future are powered by <a href="https://icons8.com/ouch/" target="_blank" class="text-light"><u>Icons8</u></a></p> --}}
						</div>
					</div>
					<!-- /Row -->
				</div>
				<!-- /Container -->
			</div>
			<!-- /Page Body -->
		</div>
		<!-- /Main Content -->
	</div>
    <!-- /Wrapper -->

	<!-- jQuery -->
    <script src="{{asset('/')}}vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JS -->
	<script src="{{asset('/')}}vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FeatherIcons JS -->
    <script src="{{asset('/')}}dist/js/feather.min.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{asset('/')}}dist/js/dropdown-bootstrap-extended.js"></script>

	<!-- Simplebar JS -->
	<script src="{{asset('/')}}vendors/simplebar/dist/simplebar.min.js"></script>

	<!-- Init JS -->
	<script src="{{asset('/')}}dist/js/init.js"></script>
</body>
</html>
