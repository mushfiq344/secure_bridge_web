@section('scripts')
<!-- js for toggle -->
<script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{asset('admin/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{asset('admin/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<!-- Datatable init js -->
<script src="{{asset('admin/pages/datatables.init.js')}}"></script>

<!-- users tables -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".user-status").change(function() {
        let status = $(this).val();
        let user_id = $(this).attr("user-id");
        $.ajax({
            type: 'POST',
            url: "{{ route('admin-change-user-status')}}",
            data: {
                is_active: status,
                user_id: user_id
            },
            success: (data) => {

                console.log(data);

            },

            error: function(data) {
                console.log(data);
                alert("There has been some error");
            }
        });
    });
</script>
@endsection