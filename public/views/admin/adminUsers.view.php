<?php
getHeader();

$titles = array('Name', 'Number Of Packages', 'Total Spent', 'Average Spent');
?>
<!-- /admin/users page displays all the customers in the database. It displays
the users' first name, last name and transaction figures, with a link to single user's view -->
<div class="row">
	<div class="container">
		<div class="group-wrapper card-2 clearfix">
			<h3>All Users</h3>
			<div class="list-wrapper card-2">
				<?php if( ! empty( $users ) ) { ?>
					<div class="list-header primary-bg clearfix">
						<!-- Header for the list begins -->
						<div class="col-dt-3 col-tb-3 col-mb-3 no-margin">
							<div class="list-item-content">
								<strong>Name</strong>
							</div>
						</div>
						<div class="col-dt-3 col-tb-3 col-mb-3 no-margin">
							<div class="list-item-content">
								<strong>Number of Packages</strong>
							</div>
						</div>
						<div class="col-dt-3 col-tb-3 col-mb-3 no-margin">
							<div class="list-item-content">
								<strong>Total Spent</strong>
							</div>
						</div>
						<div class="col-dt-3 col-tb-3 col-mb-3 no-margin">
							<div class="list-item-content">
								<strong>Average Spent</strong>
							</div>
						</div>
					</div>
					<div>
						<?php foreach( $users as $user ) { ?>
							<!-- List of users begins -->
							<div class="list-item clearfix">
								<div class="list-container clearfix">
									<div class="col-dt-3 col-tb-3 col-mb-3">
										<div class="list-item-content">
											<?= $user->firstName?> <?= $user->lastName?>
											<div>
												<a href="/users/<?= $user->id ?>">
													View</a>
											</div>
										</div>
									</div>
									<div class="col-dt-3 col-tb-3 col-mb-3">
										<div class="list-item-content">
											<?= $user->packageCount?>
										</div>
									</div>
									<div class="col-dt-3 col-tb-3 col-mb-3">
										<div class="list-item-content">
											$<?= $user->transactionTotal ?>
										</div>
									</div>
									<div class="col-dt-3 col-tb-3 col-mb-3">
										<div class="list-item-content">
											$<?= $user->averageSpent ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<?php
getFooter();
?>
