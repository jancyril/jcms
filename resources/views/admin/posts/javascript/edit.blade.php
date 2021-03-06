@section('edit_js')
<script type="text/javascript">
new Vue({
  el: '#jcms',

  data: {
    form: {
      title: "{{ $post->title }}",
      slug: "{{ $post->slug }}",
      content: '',
      excerpt: "{{ $post->excerpt }}",
      category_id: "{{ $post->category_id }}",
      status: "{{ $post->status }}",
      image: "{{ $post->image }}",
    },
    message: '',
    result: false,
    alert: false,
    submitting: false,
    submit: 'Save Changes',
    file: new FormData(),
  },

  computed: {
    slug() {
      if (this.form.slug === '') {
        return {slug: this.form.title};
      }

      return {slug: this.form.slug};
    },

    photo() {
      if (this.form.image == '') {
        return '';
      }

      return imageURL + this.form.image;
    }
  },

  methods: {
    save() {
      NProgress.start();
      this.submitting = true;
      this.form.content = $('#texteditor').summernote('isEmpty') ? '' : $('#texteditor').val();
      var data = Object.assign(this.form, this.slug);

      this.$http.put("{{ route('admin::put-post', $post->id) }}", JSON.stringify(data))
          .then((response) => {
            this.result = response.body.result;
            this.message = response.body.message;
            this.alert = true;
            this.submitting = false;

            window.scrollTo(0, 0);
          },(error) => {
            vueError(error);
            this.submitting = false;
          });

      NProgress.done();
    },

    imageUpload(image) {
      this.submitting = true;
      this.submit = 'Uploading Photo';
      this.file.delete('files[]');
      this.file.append('files[]', image.target.files[0]);

      this.$http.post("{{ route('admin::post-file') }}", this.file)
      .then((response) => {
        this.submitting = false;
        this.submit = 'Save Changes';

        if (!(0 in response.data)) {
          notify(response.data);
          return;
        }

        for (var i = 0; i < response.data[0].message.length; i++) {
          notify(response.data[0].message[i].original);
        }

        this.form.image = response.data[1].filename;
      });
    },

    deletePhoto() {
      swal({
        title: "Delete Featured Image?",
        text: "You cannot undo this operation. Would you like to proceed?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
      }, function() {
        this.delete();
      }.bind(this));
    },

    delete() {
      swal({
        title: 'Deleting photo',
        text: 'Please wait while we delete this photo. <br/><br/><i class="fa fa-spinner fa-pulse fa-2x"></i>',
        html: true,
        showConfirmButton: false
      });

      this.$http.delete("{{ url('admin/files/delete') }}/" + this.form.image)
      .then((response) => {
        swal.close();
        this.form.image = '';
        notify(response.data);
      }, (error) => {
        swal.close();
        vueError(error);
      });
    },

    hideAlert() {
      this.alert = false;
    }
  }
});
</script>
@endsection
