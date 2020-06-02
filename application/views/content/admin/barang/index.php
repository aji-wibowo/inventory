<section class="content-header">
  <h1>
    Stok Barang
    <small>Kelola Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Stok Barang</li>
  </ol>
</section>

<section class="content">

  <div class="box">
    <div class="box-header">
      <div>
        <h4 style="float: left">Daftar Barang dan Stok</h4>
        <div>
          <a href="#" id="bTambah" data-target="#ourModal" data-toggle="modal" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tListBarang">
          <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Satuan Barang</th>
              <th>Harga Beli</th>
              <th>Harga Jual</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody">

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ourModal" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <div class="modal-body">
            <form id="formTambahBarang" action="#" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input id="kode_barang" type="text" name="kode_barang" class="form-control" placeholder="WIRE001">
                  </div>
                  <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input id="nama_barang" type="text" name="nama_barang" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="satuan_barang">Satuan Barang</label>
                    <select class="form-control" name="satuan_barang" id="satuan_barang">
                      <option value="-Pilih Satuan-"></option>
                      <?php if(count($satuan_barang) > 0){ ?>
                        <?php foreach($satuan_barang as $row){ ?>
                          <option value="<?= $row->id_unit ?>"><?= $row->unit_name ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input id="harga_beli" type="number" name="harga_beli" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input id="harga_jual" type="number" name="harga_jual" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="stok">Stock</label>
                    <input id="stok" type="number" name="stok" class="form-control" disabled>
                    <small>*diisi saat melakukan transaksi barang masuk oleh Admin Staff!</small>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">close</button>
            <button id="bSubmit" type="button" class="btn btn-primary">save</button>
          </div>
        </div>
      </div>
    </div>

  </section>

  <script type="text/javascript">

    $(document).ready(function(){

      load();

      $('#bTambah').click(function(e){
        e.preventDefault();
        var form = $('#formTambahBarang');
        form.attr('action', '<?= base_url() ?>admin/barang/ajax/save');
        form[0].reset();
        $('#ourModal .modal-title').html('Tambah  Barang');
      })

      $(document).on('click', '.bEdit', function(e){
        var dataId = $(this).attr('data-id');
        var form = $('#formTambahBarang');
        form.attr('action', '<?= base_url() ?>admin/barang/ajax/update/' + dataId);
        form[0].reset();
        $('#ourModal .modal-title').html('Edit  Barang');

        $.ajax({
          url : '<?= base_url('admin/barang/ajax/get/id') ?>',
          type : 'POST',
          data : {id : dataId},
          success : function(r){
            obj = $.trim(r);
            obj = $.parseJSON(obj);
            if(obj.status == 0){
              swal(obj.title, obj.text, obj.icon);
            }else{
              $('#kode_barang').val(obj.id_item);
              $('#nama_barang').val(obj.item_name);
              $('#satuan_barang').val(obj.id_unit);
              $('#harga_beli').val(obj.buy_price);
              $('#harga_jual').val(obj.sell_price);
              $('#stok').val(obj.stock);
            }
          }
        });
      });

      $(document).on('click', '.bDelete', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        swal({
          title: "Anda yakin?",
          text: "Data akan dihapus dan tidak bisa kembali!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url : '<?= base_url('admin/barang/ajax/delete/') ?>' + id,
              type : 'post',
              success : function(data){
                obj = $.trim(data);
                obj = $.parseJSON(obj);
                load();
                swal(obj.title, obj.text, obj.icon);
              },
              error : function(err){
                swal(err);
              }
            })
          } else {
            swal("Data tidak jadi dihapus");
          }
        });
      })

      $('#bSubmit').click(function(e){
        e.preventDefault();
        var form = $('#formTambahBarang');
        var data = new FormData(form[0]);

        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function (data) {
            obj = $.trim(data);
            obj = $.parseJSON(obj);
            if(obj.status == 1){
              $('#ourModal').modal('hide');
            }
            load();
            swal(obj.title, obj.text, obj.icon);
          }
        });
      });

      function load(){
        $.ajax({
          url : '<?= base_url('admin/barang/ajax/get/all') ?>',
          type : 'post',
          success : function(r){
            r = $.trim(r);
            r = $.parseJSON(r);
            var html = '';

            if(r.title){
              swal(r.title, r.text, r.icon);
            }else{

              $.each(r, function(i, item){
                html += '<tr>'
                + '<td>'+ item.kode_barang +'</td>'
                + '<td>'+ item.nama_barang +'</td>'
                + '<td>'+ item.satuan_barang +'</td>'
                + '<td>'+ item.harga_beli +'</td>'
                + '<td>'+ item.harga_jual +'</td>'
                + '<td>'+ item.stok +'</td>'
                + '<td>' + item.button + '</td>'
                + '</tr>';
              });

              $('#tListBarang #tbody').html(html);

              if ( $.fn.dataTable.isDataTable( '#tListBarang' ) ) {
                $('#tListBarang').DataTable();
              }
              else {
                $('#tListBarang').DataTable({
                  "columnDefs": [ {
                    "order": [[ 0, "desc" ]],
                    "targets": 1,
                    "orderable": false
                  } ]
                });
              }

            }
          }
        });
      }

    })

  </script>


































