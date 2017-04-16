@section('summernote')
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
  });

  $('#texteditor').summernote({
    height: 500,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'hr']],
      ['view', ['codeview']]
    ],
    callbacks: {
      onImageUpload: function(files) {
        var images = new FormData();
        for(var i = 0; i < files.length; i++) {
          images.append('files[]', files[i]);
        }
        uploadImage(images);
      },
      onMediaDelete : function(target, editor, editable) {
        var filename = target[0].dataset.filename;
        deleteImage(filename, target);
      }
    }
  });

  function uploadImage(images) {
    $.ajax({
      type: 'POST',
      url: "{{ route('admin::post-file') }}",
      data: images,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        swal({
          title: "Uploading Image(s)",
          text: "This will close once upload is complete. <br/><i class='fa fa-spinner fa-pulse fa-2x'></i>",
          html: true,
          showConfirmButton: false
        });
      },
      complete: function() {
        swal.close();
      }
    }).done(function(response){
      console.log(response);
      if(response.result == false) {
        notify(response);
      }

      for(var x = 0; x < response.length; x++) {
        if(x === 0) {
          if(response[0]) {
            for (var i = 0; i < response[0].message.length; i++) {
              notify(response[0].message[i].original);
            }
          }

          continue;
        }

        $('#texteditor').summernote('insertImage', imageURL + response[x].filename, response[x].filename);
      }
    });
  }

  function deleteImage(filename, target) {
    $.ajax({
      type: 'DELETE',
      url: "{{ url('backend/uploader/delete') }}"+'/'+filename,
      dataType: 'json',
      beforeSend: function() {
        swal({
          title: 'Deleting photo',
          text: 'Please wait while we delete this photo. <br/><br/><i class="fa fa-spinner fa-pulse fa-2x"></i>',
          html: true,
          showConfirmButton: false
        });
        pstart();
      },
      complete: function() {
        swal.close();
        pdone();
      }
    }).done(function(response){
      notify(response);

      if(response.result == false) {
        return;
      }

      target.remove();
    });
  }
</script>
@endsection
