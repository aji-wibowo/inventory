<section class="content-header">
	<h1>
		Laporan Barang Keluar
		<small>Cetak Laporan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Transaksi</li>
	</ol>
</section>

<section class="content">

	<div class="box">
		<div class="box-header">
			<h4>List Barang Keluar</h4>
		</div>
		<div class="box-body">
			<form action="<?= base_url('manager/laporan/transaksi/keluar/cetak') ?>" method="post">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="fromDate">Dari</label>
							<input type="date" name="fromDate" id="fromDate" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="toDate">Sampai</label>
							<input type="date" name="toDate" id="toDate" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<div>
							<input type="submit" name="submit" class="btn btn-sm btn-success" value="submit">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>