@extends('admin.master')

@section('content')
<div class="row">
  <div class="col-xs-8">
    <div class="form-group">
      <label for="title" class="control-label">Title</label>
      <input type="text" id="title" name="title" v-model="form.title" class="form-control" placeholder="Please enter a title" />
    </div>
    
  </div>
</div>
@endsection

@section('customjs')
<script>
  Vue.http.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

  // var vm = new Vue({
  //   el: '#jcms',

  //   data: {
  //     form: {
  //       name: '',
  //       description: ''
  //     },
  //     id: 0,
  //     submitting: false
  //   },

  //   computed: {
  //     slug() {
  //       return {slug: this.form.name};
  //     }
  //   },

  //   methods: {
  //     add() {
  //       NProgress.start();
  //       this.submitting = true;
  //       var data = Object.assign(this.form, this.slug);

  //       this.$http.post("{{ route('admin::post-post-category') }}", JSON.stringify(data)).then((response) => {
  //         notify(response.data);

  //         if (response.data.result) {
  //           $('#newCategory').modal('hide');
  //           this.form.name = '';
  //           this.form.description = '';
  //           table.ajax.reload();
  //         }
  //         this.submitting = false;
  //       }, (error) => {
  //         vueError(error);
  //         this.submitting = false;
  //       });

  //       NProgress.done();
  //     },

  //     update() {
  //       NProgress.start();
  //       this.submitting = true;
  //       var data = Object.assign(this.form, this.slug);

  //       this.$http.put('/admin/post-categories/'+this.id+'/edit', JSON.stringify(data)).then((response) => {
  //         notify(response.data);

  //         if (response.data.result) {
  //           $('#updateCategory').modal('hide');
  //           this.form.name = '';
  //           this.form.description = '';
  //           table.ajax.reload();
  //         }
  //         this.submitting = false;
  //       }, (error) => {
  //         vueError(error);
  //         this.submitting = false;
  //       });

  //       NProgress.done();
  //     },

  //     delete(id) {
  //       swal({
  //         title: 'Deleting record',
  //         text: 'Please wait while we delete this record. <br/><br/><i class="fa fa-spinner fa-pulse fa-2x"></i>',
  //         html: true,
  //         showConfirmButton: false
  //       });

  //       vm.$http.delete('/admin/post-categories/delete/'+id).then((response) => {
  //         notify(response.data);
  //         swal.close();

  //         if (response.data.result) {
  //           table.ajax.reload();
  //         }
  //       });
  //     }
  //   }
  // });

  // $('#post-categories').on('click', '.edit', function() {
  //   vm._data.id = $(this).data('id');
  //   vm._data.form.name = $(this).closest('tr').find('td').eq(0)[0].textContent;
  //   vm._data.form.description = $(this).closest('tr').find('td').eq(1)[0].textContent;
  // });

  // $('#post-categories').on('click', '.delete', function() {
  //   var id = $(this).data('id');

  //   swal({
  //     title: 'Delete this category?',
  //     text: 'All data on this record will be removed and you cannot undo this operation.',
  //     type: 'warning',
  //     showCancelButton: true,
  //     confirmButtonColor: "#DD6B55",
  //     confirmButtonText: "Yes, delete it!",
  //     closeOnConfirm: false
  //   },
  //   function() {
  //     vm.$options.methods.delete(id);
  //   });
  // });
</script>
@endsection