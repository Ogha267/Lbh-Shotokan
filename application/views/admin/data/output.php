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
                       <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-user"><i class="fas fa-file-medical"></i> <b>Tambah File Output</b></button>
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
                                   <th>Nama Output</th>
                                   <th>Deskripsi</th>
                                   <th>File</th>
                                   <th>Edit</th>
                                   <th>Download</th>
                               </thead>
                               <tbody>
                                   <?php $i = 1; ?>
                                   <?php foreach ($list_output as $lu) : ?>
                                       <tr>
                                           <td><?php echo $i++; ?></td>
                                           <td><?php echo format_indo($lu['tgl_output_asal']); ?></td>
                                           <td><?php echo $lu['asal_output']; ?></td>
                                           <td><?php echo $lu['no_nama_output']; ?></td>
                                           <td><?php echo $lu['nama_output']; ?></td>
                                           <td><?php echo $lu['deskripsi_output']; ?></td>
                                           <td><?php echo $lu['file_output']; ?></td>
                                           <td><a href="#" class="tombol-edit btn btn-primary btn-block btn-sm" data-id="<?php echo $lu['id_output']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</a></td>
                                           <td><a href="<?php echo base_url('admin/download_output/') . $lu['id_output']; ?>" class="btn btn-info btn-block btn-sm"><i class="fas fa-download"></i> Download</a> </td>
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
                   <h4 class="modal-title">Tambah File Output</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('admin/output'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="date" class="form-control form-control-sm" name="tgl_output_asal" required>
                       </div>
                       <div class="form-group">
                           <label>File Asal</label>
                           <input type="text" class="form-control form-control-sm" name="asal_output" required>
                       </div>
                       <div class="form-group">
                           <label>Nomer File</label>
                           <input type="text" class="form-control form-control-sm" name="no_nama_output" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Output</label>
                           <input type="text" class="form-control form-control-sm" name="nama_output" required>
                       </div>
                       <div class="form-group">
                           <label>Deskripsi</label>
                           <textarea class="form-control" name="deskripsi_output" rows="2"></textarea>
                       </div>
                       <div class="form-group">
                           <input type="file" name="file_output" required>
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Upload File output </button>
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
                   <h4 class="modal-title">Edit File output</h4>
               </div>
               <div class="modal-body">
                   <div class="box-body">
                       <?php echo form_open_multipart('admin/edit_output'); ?>
                       <div class="form-group">
                           <label>Tgl Upload</label>
                           <input type="hidden" name="id_output" id="id_output">
                           <input type="date" class="form-control form-control-sm" name="tgl_output_asal" id="tgl_output_asal" required>
                       </div>
                       <div class="form-group">
                           <label>Asal File</label>
                           <input type="text" class="form-control form-control-sm" name="asal_output" id="asal_output" required>
                       </div>
                       <div class="form-group">
                           <label>Nomer File</label>
                           <input type="text" class="form-control form-control-sm" name="no_nama_output" id="no_nama_output" required>
                       </div>
                       <div class="form-group">
                           <label>Nama Output</label>
                           <input type="text" class="form-control form-control-sm" name="nama_output" id="nama_output" required>
                       </div>
                       <div class="form-group">
                           <label>Deskripsi</label>
                           <textarea class="form-control" name="deskripsi_output" id="deskripsi_output" rows="2"></textarea>
                       </div>
                       <div class="form-group">
                           <input type="file" name="file_output">
                       </div>
                       <button type="submit" class="btn btn-primary mr-2">Upload File output </button>
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
           const id_output = $(this).data('id');
           $.ajax({
               url: '<?php echo base_url('admin/get_output'); ?>',
               data: {
                   id_output: id_output
               },
               method: 'post',
               dataType: 'json',
               success: function(data) {
                   $('#deskripsi_output').val(data.deskripsi_output);
                   $('#nama_output').val(data.nama_output);
                   $('#no_nama_output').val(data.no_nama_output);
                   $('#asal_output').val(data.asal_output);
                   $('#tgl_output_asal').val(data.tgl_output_asal);
                   $('#id_output').val(data.id_output);
               }
           });
       });
   </script>