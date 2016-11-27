@extends('admin.master')

@section('content')
<div class="row" style="margin-bottom: 20px;">
  <div class="col-xs-2 pull-right">
    <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newCategory">
      <i class="fa fa-plus-circle"></i> New Category
    </button>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table id="post-categories" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="newCategory" tabindex="-1" role="dialog" aria-labelledby="newModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newModal">New Category</h4>
      </div>
      <form v-on:submit.prevent="add">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter a category name" v-model="form.name" />
          </div>
          <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" rows="3" class="form-control" placeholder="Enter a category description" v-model="form.description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" :disabled="submitting" @click="add">
            <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> Save New Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="updateModal">Update Category</h4>
      </div>
      <form v-on:submit.prevent="update">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter a category name" v-model="form.name" />
          </div>
          <div class="form-group">
            <label class="control-label">Description</label>
            <textarea name="description" rows="3" class="form-control" placeholder="Enter a category description" v-model="form.description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" :disabled="submitting" @click="update">
            <i class="fa fa-spinner fa-pulse" v-show="submitting"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('customjs')
<script>
  Vue.http.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

  var table = $('#post-categories').DataTable({
    "columnDefs": [
      { "width": "10%", "targets": 2 },
      { className: "text-center", "targets": [2] }
    ],
    columns: [
      { "name": "name", "orderable": true, "searchable": true },
      { "name": "description", "orderable": true, "searchable": true },
      { "name": "id", "orderable": false, "searchable": false },
    ],
    serverSide: true,
    ajax: {
      url: "{{ route('admin::get-post-categories') }}",
      type: 'GET',
      dataFilter: function(data){
        var json = $.parseJSON(data),
            columns = [];
        
        for(var x=0; x<json.data.length; x++) {
          var buttons = '';

          buttons += '<button data-id="'+json.data[x][2]+'" class="btn btn-sm btn-primary edit" data-toggle="modal" data-target="#updateCategory" title="Edit"><i class="fa fa-pencil fa-fw"></i></button>';;

          buttons += ' ';

          buttons += '<button data-id="'+json.data[x][2]+'" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash fa-fw"></i></button>';

          columns.push([json.data[x][0], json.data[x][1], buttons]);
        }

        json.data = columns;

        return JSON.stringify(json);
      },
      beforeSend: function() {
        NProgress.start();
      },
      complete: function() {
        NProgress.done();
      }
    }
  });

  var vm = new Vue({
    el: '#jcms',

    data: {
      form: {
        name: '',
        description: ''
      },
      id: 0,
      submitting: false
    },

    computed: {
      slug() {
        return {slug: this.form.name};
      }
    },

    methods: {
      add() {
        NProgress.start();
        this.submitting = true;
        var data = Object.assign(this.form, this.slug);

        this.$http.post("{{ route('admin::post-post-category') }}", JSON.stringify(data)).then((response) => {
          notify(response.data);

          if (response.data.result) {
            $('#newCategory').modal('hide');
            this.form.name = '';
            this.form.description = '';
            table.ajax.reload();
          }
          this.submitting = false;
        }, (error) => {
          vueError(error);
          this.submitting = false;
        });

        NProgress.done();
      },

      update() {
        NProgress.start();
        this.submitting = true;
        var data = Object.assign(this.form, this.slug);

        this.$http.put('/admin/post-categories/'+this.id+'/edit', JSON.stringify(data)).then((response) => {
          notify(response.data);

          if (response.data.result) {
            $('#updateCategory').modal('hide');
            this.form.name = '';
            this.form.description = '';
            table.ajax.reload();
          }
          this.submitting = false;
        }, (error) => {
          vueError(error);
          this.submitting = false;
        });

        NProgress.done();
      },

      delete(id) {
        swal({
          title: 'Deleting record',
          text: 'Please wait while we delete this record. <br/><br/><i class="fa fa-spinner fa-pulse fa-2x"></i>',
          html: true,
          showConfirmButton: false
        });

        vm.$http.delete('/admin/post-categories/delete/'+id).then((response) => {
          notify(response.data);
          swal.close();

          if (response.data.result) {
            table.ajax.reload();
          }
        });
      }
    }
  });

  $('#post-categories').on('click', '.edit', function() {
    vm._data.id = $(this).data('id');
    vm._data.form.name = $(this).closest('tr').find('td').eq(0)[0].textContent;
    vm._data.form.description = $(this).closest('tr').find('td').eq(1)[0].textContent;
  });

  $('#post-categories').on('click', '.delete', function() {
    // vm._data.id = $(this).data('id');
    var id = $(this).data('id');

    swal({
      title: 'Delete this group?',
      text: 'All data on this record will be removed and you cannot undo this operation.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function() {
      vm.$options.methods.delete(id);
    });
  });
</script>
@endsection