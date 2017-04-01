@section('vue_headers')
  <script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";
  </script>
@endsection
