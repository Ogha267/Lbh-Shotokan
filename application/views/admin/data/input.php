   <!-- Begin Page Content -->
   <div class="container-fluid">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h2 class="h4 mb-0 text-gray-800"><?php echo $title; ?></h2>
           <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
       </div>
       <div class="row">
           <div class="col-xl-12 col-lg-5">
               <div class="card shadow mb-4">
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                       <!-- <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6> -->
                       <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-user"><i class="fas fa-file-medical"></i> <b>Tambah File Input</b></button>
                   </div>
                   <div class="card-body">
                       <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                       <?php echo $this->session->flashdata('msg'); ?>
                       <?php if (validation_errors()) { ?>
                           <div class="alert alert-danger">
                               <strong><?php echo strip_tags(validation_errors()); ?></strong>
                               <a href="" class="float-right text-decoration-none" data-dismiss="alert"><i class="fas fa-times"></i></a>
                           </div>
                       <?php } ?>
                       <div class="table-responsive">
                           <table class="table table-bordered" id="table-id">
                               <thead>
                                   <th>#</th>
                                   <th>Tgl Upload</th>
                                   <th>File Asal</th>
                                   <th>No. File</th>
                                   <th>Nama Input</th>
                                   <th>Deskripsi</th>
                                   <th>File</th>
                                   <th>Edit</th>
                                   <th>Download</th>
                               </thead>
                               <tbody>
                                   <?php $i = 1; ?>
                                   <?php foreach ($list_input as $lu) : ?>
                                       <tr>
                                           <td><?php echo $i++; ?></td>
                                           <td><?php echo format_indo($lu['tgl_input_asal']); ?></td>
                                           <td><?php echo $lu['asal']; ?></td>
                                           <td><?php echo $lu['no_nama_input']; ?></td>
                                           <td><?php echo $lu['nama_input']; ?></td>
                                           <td><?php echo $lu['deskripsi']; ?></td>
                                           <td><?php echo $lu['file_input']; ?></td>
                                           <td><a href="#" class="tombol-edit btn btn-primary btn-block btn-sm" data-id="<?php echo $lu['id_input']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</a></td>
                                           <td><a href="<?php echo base_url('admin/download_input/') . $lu['id_input']; ?>" class="btn btn-info btn-block btn-sm"><i class="fas fa-download"></i> Download</a> </td>
                                       </tr>
                                   <?php endforeach; ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="add-user">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Tambah File Input</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('admin/input'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="date" class="form-control form-control-sm" name="tgl_input_asal" required>
                       </div>
                       <div class="form-group">
                           <label>Asal File</label>
                           <input type="text" class="form-control form-control-sm" name="asal" required>
                       </div>
                       <div class="form-group">
                           <label>Nomer File</label>
                           <input type="text" class="form-control form-control-sm" name="no_nama_input" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Input</label>
                           <input type="text" class="form-control form-control-sm" name="nama_input" required>
                       </div>
                       <div class="form-group">
                           <label>Deskripsi</label>
                           <textarea class="form-control" name="deskripsi" rows="2"></textarea>
                       </div>
                       <div class="form-group">
                           <input type="file" name="file_input" required>
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Upload File Input </button>
                       <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                       </form>
                       <hr>
                       * File Upload harus format PDF,DOCX,DOC.<br>
                       * Ukuran File tidak lebih dari 2 MB.<br>
                   </div>
               </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
       </div>
   </div>

   <div class="modal fade" id="edit-user">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Edit File Input</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('admin/edit_input'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="hidden" name="id_input" id="id_input">
                           <input type="date" class="form-control form-control-sm" name="tgl_input_asal" id="tgl_input_asal" required>
                       </div>
                       <div class="form-group">
                           <label>File Asal</label>
                           <input type="text" class="form-control form-control-sm" name="asal" id="asal" required>
                       </div>
                       <div class="form-group">
                           <label>Nomer File</label>
                           <input type="text" class="form-control form-control-sm" name="no_nama_input" id="no_nama_input" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Input</label>
                           <input type="text" class="form-control form-control-sm" name="nama_input" id="nama_input" required>
                       </div>
                       <div class="form-group">
                           <label>Deskripsi</label>
                           <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2"></textarea>
                       </div>
                       <div class="form-group">
                           <input type="file" name="file_input">
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Upload File Input </button>
                       <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                       </form>
                       <hr>
                       * File Upload harus format PDF,DOCX,DOC.<br>
                       * Ukuran File tidak lebih dari 2 MB.<br>
                   </div>
               </div>
               <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
       </div>
   </div>


   <script>
       $('.tombol-edit').on('click', function() {
           const id_input = $(this).data('id');
           $.ajax({
               url: '<?php echo base_url('admin/get_input'); ?>',
               data: {
                   id_input: id_input
               },
               method: 'post',
               dataType: 'json',
               success: function(data) {
                   $('#deskripsi').val(data.deskripsi);
                   $('#nama_input').val(data.nama_input);
                   $('#no_nama_input').val(data.no_nama_input);
                   $('#asal').val(data.asal);
                   $('#tgl_input_asal').val(data.tgl_input_asal);
                   $('#id_input').val(data.id_input);
               }
           });
       });
   </script>