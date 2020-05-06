<section class="content-header">
  <h1>
    SatuanBarang
    <small>Kelola Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Satuan Barang</li>
  </ol>
</section>

<section class="content">

  <div class="box">
    <div class="box-header">
      <div>
        <h4 style="float: left">Daftar Satuan Barang</h4>
        <div>
          <a href="#" id="bTambah" data-target="#ourModal" data-toggle="modal" class="btn btn-xs btn-success" style="float: right"><i class="fa fa-plus"></i> tambah</a>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tListSatuanBarang">
          <thead>
            <tr>
              <th>Nama Satuan</th>
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
            <form id="formTambahSatuanBarang" action="#" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="unit_name">Nama Satuan</label>
                    <input id="unit_name" type="text" name="unit_name" class="form-control">
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

    load();

    $('#bTambah').click(function(e){
      e.preventDefault();
      var form = $('#formTambahSatuanBarang');
      form.attr('action', '<?= base_url() ?>staff/satuan/ajax/save');
      form[0].reset();
      $('#ourModal .modal-title').html('Tambah Satuan Barang');
    })

    $(document).on('click', '.bEdit', function(e){
      var dataId = $(this).attr('data-id');
      var form = $('#formTambahSatuanBarang');
      form.attr('action', '<?= base_url() ?>staff/satuan/ajax/update/' + dataId);
      form[0].reset();
      $('#ourModal .modal-title').html('Edit Satuan Barang');

      $.ajax({
        url : '<?= base_url('staff/satuan/ajax/get/id') ?>',
        type : 'POST',
        data : {id : dataId},
        success : function(r){
          obj = $.trim(r);
          obj = $.parseJSON(obj);
          if(obj.status == 0){
            swal(obj.title, obj.text, obj.icon);
          }else{
            $('#unit_name').val(obj.unit_name);
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
            url : '<?= base_url('staff/satuan/ajax/delete/') ?>' + id,
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

    $('#formTambahSatuanBarang').keypress(function(e){
      if(e.keyCode == 13){
        e.preventDefault();
        return false;
      }
    });

    $('#bSubmit').click(function(e){
      e.preventDefault();
      var form = $('#formTambahSatuanBarang');
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
        url : '<?= base_url('staff/satuan/ajax/get/all') ?>',
        type : 'post',
        success : function(r){
          r = $.trim(r);
          r = $.parseJSON(r);
          var html = '';

          if(r.title){
            swal(r.title, r.text, r.icon);
            $('#tListSatuanBarang #tbody').html(html);
          }else{

            if(r.length > 0){

              $.each(r, function(i, item){
                html += '<tr>'
                + '<td>'+ item.unit_name +'</td>'
                + '<td>' + item.button + '</td>'
                + '</tr>';
              });

            }

            $('#tListSatuanBarang #tbody').html(html);

            if ( $.fn.dataTable.isDataTable( '#tListSatuanBarang' ) ) {
              $('#tListSatuanBarang').DataTable();
            }
            else {
              $('#tListSatuanBarang').DataTable({
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

  </script>


































