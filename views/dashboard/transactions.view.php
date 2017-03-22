<?php
	getHeader();
?>

<div class="row">
	<div class="container">
		<h1>Post Office Transactions</h1>
	</div>
</div>

<div class="row">
	<div class="container">
		<?php if( ! empty( $transactions ) ) { ?>
			<div class="package-wrapper">
				<?php foreach( $transactions as $transaction ) { ?>
					<a href="/transactions/<?= $transaction->id ?>" class="package-list-item clearfix">
						<div class="clearfix">
							<div class="col-dt-2 col-tb-10 col-mb-2 text-center">
								<?= $transaction->id ?>
							</div>
							<!-- /.col-dt-2 col-tb-4 col-mb-6 -->
							<div class="col-dt-2 col-tb-4 col-mb-6 text-center">
								<?= $transaction->packageId ?>
							</div>
							<!-- /.col-dt-2 col-tb-4 col-mb-6 -->
							<div class="col-dt-2 col-tb-4 col-mb-6 text-center" >
								<?= $transaction->customerId?>
							</div>
							<!-- /.col-dt-2 col-tb-4 col-mb-6 -->
							<div class="col-dt-2 col-tb-4 col-mb-6 text-center" >
								<?= $transaction->cost ?>
							</div>
							<!-- /.col-dt-2 col-tb-4 col-mb-6 -->
						</div>
					</a>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>


<?php
	getFooter();
?>