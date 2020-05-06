<section class="content-header">
	<h1>
		Dashboard
		<small>Staff Panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	</ol>
</section>

<section class="content">

	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?= $grafikData['summaryJual']['qty']?></h3>

					<p>Barang Keluar</p>
				</div>
				<div class="icon">
					<i class="fas fa-arrow-up"></i>
				</div>
				<a href="<?= base_url('admin/transaksi/list/keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?= currency_format($grafikData['summaryJual']['jual']) ?></h3>

					<p>Hasil Barang Keluar</p>
				</div>
				<div class="icon">
					<i class="fas fa-dollar"></i>
				</div>
				<a href="<?= base_url('admin/transaksi/list/keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?= $grafikData['summaryBeli']['qty']?></sup></h3>

					<p>Barang Masuk</p>
				</div>
				<div class="icon">
					<i class="fas fa-arrow-down"></i>
				</div>
				<a href="<?= base_url('admin/transaksi/list/masuk') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?= currency_format($grafikData['summaryBeli']['beli']) ?></h3>

					<p>Biaya Barang Masuk</p>
				</div>
				<div class="icon">
					<i class="fas fa-dollar"></i>
				</div>
				<a href="<?= base_url('admin/transaksi/list/masuk') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="box-header">
			<h4 style="float: left">Grafik Barang Masuk dan Keluar tahun <?= date('Y') ?></h4>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div id="chart" style="height: 250px;"></div>
				</div>
			</div>
		</div>
	</div>

</section>


<script type="text/javascript">
	
	$(document).ready(function(){

		dataGrafik = $.parseJSON($.trim('<?= json_encode($grafikData['ready']) ?>'));

		console.log(dataGrafik);

		new Morris.Bar({
		  // ID of the element in which to draw the chart.
		  element: 'chart',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  data: dataGrafik,
		  // The name of the data record attribute that contains x-values.
		  xkey: 'barang',
		  // A list overf names of data record attributes that contain y-values.
		  ykeys: ['keluar', 'masuk'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Keluar', 'Masuk'],
		  stacked: true
		});

	})

</script>