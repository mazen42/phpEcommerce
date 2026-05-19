<?php
$pageTitle = "Login";
include "common/Header.php";
?>
<section style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
	<div class="mask d-flex align-items-center h-100 gradient-custom-3">
		<div class="container h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-9 col-lg-7 col-xl-6 mt-3 mb-3">
					<div class="card" style="border-radius: 15px;">
						<div class="card-body p-5">
							<h2 class="text-uppercase text-center mb-5">Create an account</h2>
							<div class="col-md-8" id="signup_msg"></div>
							<form id="registerform">

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="text" name="firstname" id="form3Example1cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example1cg">Your FirstName</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="text" name="lastname" id="form3Example1cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example1cg">Your LastName</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="text" name="city" id="form3Example1cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example1cg">City</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="text" name="mobilenumber" id="form3Example1cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example1cg">Mobile Number</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="text" name="secondmoblienumber" id="form3Example1cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example1cg">Second mobile number</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="email" name="email" id="form3Example3cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example3cg">Your Email</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="password" name="password" id="form3Example4cg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example4cg">Password</label>
								</div>

								<div data-mdb-input-init class="form-outline mb-4">
									<input type="password" name="passwordconfirmation" id="form3Example4cdg"
										class="form-control form-control-lg" />
									<label class="form-label" for="form3Example4cdg">Repeat your password</label>
								</div>

								<div class="form-check d-flex justify-content-center mb-5">
									<input class="form-check-input me-2" name="terms" type="checkbox" value=""
										id="form2Example3cg" />
									<label class="form-check-label" for="form2Example3g">
										I agree all statements in <a href="#!" class="text-body"><u>Terms of
												service</u></a>
									</label>
								</div>

								<div class="d-flex justify-content-center">
									<button type="button" id="registersubmit" data-mdb-button-init data-mdb-ripple-init
										class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
								</div>

								<p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="Login.php"
										class="fw-bold text-body"><u>Login here</u></a></p>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
<?php
include "common/footer.php";
?>