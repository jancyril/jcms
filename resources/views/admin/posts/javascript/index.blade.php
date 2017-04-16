@section('index_js')
  <script>
    var table = $('#posts').DataTable({
      "columnDefs": [
        { "width": "10%", "targets": 3 },
        { className: "text-center", "targets": [3] }
      ],
      columns: [
        { "name": "title", "orderable": true, "searchable": true },
        { "name": "created_at", "orderable": true, "searchable": false },
        { "name": "status", "orderable": true, "searchable": true },
        { "name": "id", "orderable": false, "searchable": false },
      ],
      serverSide: true,
      ajax: {
        url: "{{ route('admin::get-posts') }}",
        type: 'GET',
        dataFilter: function(data){
          var json = $.parseJSON(data),
              columns = [];

          for(var x = 0; x < json.data.length; x++) {
            var buttons = '';

            buttons += '<a href="'+json.data[x].url+'" class="btn btn-sm btn-primary edit" target="_blank" title="Edit"><i class="fa fa-pencil fa-fw"></i></a>';

            buttons += ' ';

            buttons += '<button data-id="'+json.data[x].id+'" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash fa-fw"></i></button>';

            columns.push([json.data[x].title, json.data[x].date, json.data[x].status, buttons]);
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

      methods: {
        delete(id) {
          swal({
            title: 'Deleting record',
            text: 'Please wait while we delete this record. <br/><br/><i class="fa fa-spinner fa-pulse fa-2x"></i>',
            html: true,
            showConfirmButton: false
          });

          vm.$http.delete('/admin/posts/delete/'+id).then((response) => {
            notify(response.data);
            swal.close();

            if (response.data.result) {
              table.ajax.reload();
            }
          });
        }
      }
    });

    $('#posts').on('click', '.delete', function() {
      var id = $(this).data('id');

      swal({
        title: 'Delete this post?',
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
