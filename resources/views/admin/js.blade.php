<script type="text/javascript">
var imageURL = "{{ config('custom.asset_url') }}";

function notify(response) {
  new PNotify({
    styling: 'fontawesome',
    type: response.type,
    title: response.title,
    text: response.message,
    animate: {
      animate: true,
      in_class: 'lightSpeedIn',
      out_class: 'fadeOut'
    }
  });
}

function showError(errorValue) {
  new PNotify({
    styling: 'fontawesome',
    type: 'error',
    title: 'Error',
    text: errorValue.join("<br/>"),
    animate: {
      animate: true,
      in_class: 'lightSpeedIn',
      out_class: 'fadeOut'
    }
  });
}

function vueError(error) {
  var messages = [];

  var errors = Object.keys(error.data).map(function (key) {
    return error.data[key][0];
  });

  setTimeout(function () {
    for (var x = 0; x < errors.length; x++) {
      messages.push(errors[x]);
    }

    showError(messages);
  }, 100);
}
</script>
