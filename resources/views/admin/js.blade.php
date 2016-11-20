<script type="text/javascript">
function notify(response) {
  new PNotify({
    styling: 'fontawesome',
    type: response.type,
    title: response.title,
    text: response.message
});
}

function showError(errorValue) {
  new PNotify({
    styling: 'fontawesome',
    type: 'error',
    title: 'Error',
    text: errorValue.join("<br/>")
  });
}

function vueError(error) {
  var messages = [];

  var errors = Object.keys(error.data).map(function (key) {
      return error.data[key];
  });

  for (var x = 0; x < errors.length; x++) {
    if (Array.isArray(errors[x])) {
      for (var y = 0; y < errors[x].length; y++) {
        messages.push(errors[x][y]);
      }
      continue;
    }

    messages.push(errors[x]);
  }

  showError(messages);
}
</script>