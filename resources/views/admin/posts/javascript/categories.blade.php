@section('categories_js')
  <script>
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
          var json = JSON.parse(data),
              columns = [];

          for(var x=0; x<json.data.length; x++) {
            var buttons = '';

            buttons += '<button data-id="'+json.data[x].id+'" class="btn btn-sm btn-primary edit" data-toggle="modal" data-target="#updateCategory" title="Edit"><i class="fa fa-pencil fa-fw"></i></button>';;

            buttons += ' ';

            buttons += '<button data-id="'+json.data[x].id+'" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash fa-fw"></i></button>';

            columns.push([json.data[x].name, json.data[x].description, buttons]);
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

          this.$http.post("{{ route('admin::post-post-category') }}", JSON.stringify(data))
              .then((response) => {
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

          this.$http.put('/admin/post-categories/'+this.id+'/edit', JSON.stringify(data))
              .then((response) => {
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
      var id = $(this).data('id');

      swal({
        title: 'Delete this category?',
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
