<!DOCTYPE html>
<html>
<head>
	<title>Stok Barang</title>
</head>
<body>
	<div style="text-align: center;">
		<h3>Laporan Stok Barang</h3>
	</div>
	<table width="100%" border="0.1" style="text-align: left">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Satuan</th>
				<th>Harga Beli</th>
				<th>Harga Jual</th>
				<th>Stok</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; foreach($data as $row){ ?>
				<tr>
					<td><?= $i ?></td>
					<td><?= $row->item_name ?></td>
					<td><?= $row->unit_name ?></td>
					<td><?= currency_format($row->buy_price) ?></td>
					<td><?= currency_format($row->sell_price) ?></td>
					<td><?= $row->stock ?></td>
				</tr>
			<?php $i++; } ?>
		</tbody>
	</table>
</body>
</html>