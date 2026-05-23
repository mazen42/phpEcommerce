<?php
$pageTitle = "cart";
include "common/Header.php";
?>
<section class="h-100 h-custom" style="background-color: #eee;">
	<div class="container py-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100 ">
			<div class="col">
				<div class="card">
					<div class="card-body p-4">

						<div class="row">
							<h5 class="mb-3"><a href="#!" class="text-body"><i
										class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
							<hr>

							<div class="d-flex justify-content-between align-items-center mb-4">
								<div>
									<p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"
											class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
								</div>
							</div>
							<div class="col-lg-7" id="colToAppend">


							</div>

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