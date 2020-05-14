<section class="content-header">
  <h1>
    Transaksi Barang Masuk
    <small>Restok Barang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Transaksi</li>
  </ol>
</section>

<section class="content">

  <div class="box">
    <div class="box-header">
      <div>
        <h4 style="float: left">Barang Masuk</h4>
        <div>
          <a href="<?= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : base_url() ?>" id="bTambah" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-arrow-left"></i> kembali</a>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Kode Beli</label>
            <input type="text" id="idBuyToDB" name="id_buy_item" class="form-control" value="<?=$kodeBeli?>" readonly>
          </div> 
          <div class="form-group">
            <label>Tanggal Pembelian</label>
            <input type="date" id="buyDataToDB" name="buy_date" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No. Faktur</label>
            <input type="text" name="invoice_number" id="invoiceToDB" class="form-control" placeholder="INV00000000">
          </div>
          <div class="form-group">
            <label>Supplier</label>
            <select class="form-control" name="supplier" id="supplierToDB">
              <option value="">-Pilih Supplier-</option>
              <?php if($supplier->num_rows() > 0){ ?>
                <?php foreach($supplier->result() as $row){ ?>
                  <option value="<?= $row->id_supplier ?>"><?= $row->supplier_name ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-sm btn-info" data-target="#ourModal" data-toggle="modal" style="width: 100%">cari item</button>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" id="nama_barang" class="form-control" readonly>
            <input type="hidden" name="id_item" id="id_item">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Satuan</label>
            <input type="text" id="satuan" class="form-control" readonly>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" id="jumlah" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Harga</label>
            <input type="text" id="harga" class="form-control" readonly>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
           <button class="btn btn-success btn-sm" id="bInsertTemp" style="margin-top: 25px; width: 100%">tambah</button>
         </div>
       </div>
     </div>
     <hr>
     <h4 class="card-title">Keranjang</h4>
     <hr>
     <div class="row">
       <div class="col-md-12">
         <table class="table table-bordered" id="tTemporary">
          <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Jumlah Barang</th>
              <th>Harga Satuan</th>
              <th>Subtotal</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody id="tBodyTemporary">
            <td colspan="6">data kosong</td>
          </tbody>
        </table>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12 text-right">
        <button id="bSubmit" class="btn btn-sm btn-success">submit</button>
      </div>
    </div>
  </div>
</div>

<!-- modal item list -->

<div class="modal fade" id="ourModal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Pilih Barang</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" id="tableListCari">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stock</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              <?php if($barang->num_rows() > 0){ ?>
                <?php foreach ($barang->result() as $row) { ?>
                  <tr>
                    <td class="item_name"><?=$row->item_name?></td>
                    <td class="unit_name"><?=$row->unit_name?></td>
                    <td class="buy_price"><?=$row->buy_price?></td>
                    <td class="sell_price"><?=$row->sell_price?></td>
                    <td class="stock"><?=$row->stock?></td>
                    <td><a class="btn btn-sm btn-success bPilih" data-id="<?= $row->id_item ?>">pilih</a></td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
        </div>
      </div>
    </div>
  </div>

</section>


<script type="text/javascript">

  $(document).ready(function(){

    $('#tableListCari').DataTable();

    $('#bInsertTemp').click(function(e){
      e.preventDefault();
      var id_item = $('#id_item').val();
      var jumlah = $('#jumlah').val();

      if(id_item == '' || jumlah == ''){
        swal("Isn't Us!", "Anda harus memilih item atau mengisi jumlah barang terlebih dahulu!", 'warning');
      }else{
        $.ajax({
          url : '<?= base_url() ?>staff/transaksi/insert/temporary',
          type : 'POST',
          data : {id_item : id_item, qty : jumlah, mode : 'masuk'},
          success : function(r){
            r = $.trim(r);
            r = $.parseJSON(r);

            if (r.status == 0) {
              swal(r.title, r.text, r.icon);
            }else{
              loadListBarangTemp();
              $('#nama_barang').val("");
              $('#satuan').val("");
              $('#harga').val("");
              $('#jumlah').val("");
              $('#id_item').val("");
            }
          }
        })
      }
    })

    $(document).on('click', '.bDeleteTemp', function(e){
      e.preventDefault();
      var id_temp = $(this).attr('data-id-temp');
      $.ajax({
        url : '<?= base_url() ?>staff/transaksi/delete/temporary',
        type : 'post',
        data : {id_temp : id_temp},
        success : function(r){
          r = $.trim(r);
          r = $.parseJSON(r);

          if (r.status == 0) {
            swal(r.title, r.text, r.error);
          }else{
            loadListBarangTemp();
          }
        }
      })
    })

    $(document).on('click', '.bPilih', function(e){
      e.preventDefault();

      var item_id = $(this).attr('data-id');
      var item_name = $(this).parent().parent().find('.item_name').html();
      var unit_name = $(this).parent().parent().find('.unit_name').html();
      var buy_price = $(this).parent().parent().find('.buy_price').html();

      $('#nama_barang').val(item_name);
      $('#satuan').val(unit_name);
      $('#harga').val(buy_price);
      $('#id_item').val(item_id);

      $('#ourModal').modal('hide');
    })

    $('#bSubmit').click(function(e){
      e.preventDefault();
      var id_buy_item = $('#idBuyToDB').val();
      var buy_date = $('#buyDataToDB').val();
      var id_supplier = $('#supplierToDB').val();
      var invoice_number = $('#invoiceToDB').val();

      var data = {
        id_buy_item : id_buy_item,
        buy_date : buy_date,
        id_supplier : id_supplier,
        invoice_number : invoice_number
      }

      console.log(data);

      $.ajax({
        url: '<?=base_url('staff/transaksi/masuk/insert')?>',
        type: 'POST',
        data: { id_buy_item : id_buy_item,  buy_date : buy_date, id_supplier : id_supplier, invoice_number : invoice_number},
        success: function (data) {
          obj = $.trim(data);
          obj = $.parseJSON(obj);
           if(obj.status == 1){
            swal(obj.title, obj.text, obj.icon).then(function(){
              window.location.reload();
            });
          }else{
            swal(obj.title, obj.text, obj.icon);
          }
          loadListBarangTemp();
        }
      });
    });

    loadListBarangTemp();

    function loadListBarangTemp(){
      var kode = '<?= $kodeBeli ?>';

      $.ajax({
        url : '<?= base_url() ?>staff/transaksi/get/temporary',
        type : 'post',
        data : {kode : kode},
        success : function(r){
          r = $.trim(r);
          r = $.parseJSON(r);

          html = '';

          if(r.status != 0){
            $.each(r, function(i, item){
              html += '<tr>'
              + '<td class="idItemToDB">'+item.kode_barang+'</td>'
              + '<td>'+item.nama_barang+'</td>'
              + '<td class="qtyToDB">'+item.qty+'</td>'
              + '<td class="priceToDB">'+item.harga_satuan+'</td>'
              + '<td class="subtotalToDB">'+item.subtotal+'</td>'
              + '<td>'+item.button+'</td>'
              + '</tr>';
            });

          }else{
            html = '<tr>'
            + '<td colspan="6">data kosong</td>'
            + '</tr>';
          }

          $('#tBodyTemporary').html(html);
        }
      })
    }

  })

</script>



