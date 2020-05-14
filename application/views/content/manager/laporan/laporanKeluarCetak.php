<!DOCTYPE html>
<html>
<head>
	<title>Laporan Barang Keluar Per Periode</title>
</head>
<body>
	<div style="text-align: center;">
		<h3>Laporan Barang Keluar Tanggal 1 Mei - 30 Mei 2020</h3>
	</div>
	<?php foreach($header as $h){ ?>
	<div style="margin-top: 25px; border: 1 solid black; padding: 5px;">
		<div>
			<label>ID BELI : <?= $h->id_sell_item ?> | </label>
			<label>Tanggal Penjualan : <?= date('d M Y', strtotime($h->sell_date)) ?> | </label>
			<label>Customer : <?= $h->customer ?> | </label>
			<label>Staff : <?= $h->fullname ?></label>
		</div>
		<div style="margin-bottom: -10px; margin-top: -10px;">
			<h5>Barang Detail</h5>
		</div>
		<table width="100%" border="1" style="text-align: left">
			<thead>
				<tr>
					<th>Nama Barang</th>
					<th>Satuan</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($detail[$h->id_sell_item] as $d){ ?>
				<tr>
					<td><?= $d['item_name'] ?></td>
					<td><?= $d['unit_name'] ?></td>
					<td><?= $d['qty'] ?></td>
					<td><?= currency_format($d['price']) ?></td>
					<td><?= currency_format($d['subtotal']) ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td style="text-align: center; background-color: whitesmoke; font-weight: bold;" colspan="4">Total</td>
					<td><?= currency_format($h->total) ?></td>
				</tr>
				<tr>
					<td style="text-align: center; background-color: whitesmoke; font-weight: bold;" colspan="4">Pelanggan Bayar</td>
					<td><?= currency_format($h->customer_payment) ?></td>
				</tr>
				<tr>
					<td style="text-align: center; background-color: whitesmoke; font-weight: bold;" colspan="4">Kembali</td>
					<td><?= currency_format($h->customer_change) ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php } ?>
</body>
</html>