<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Send To All Users</label>
          <div class="col-sm-10">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input form-control" id="mail-send-condition" name="condition">
              <label class="custom-control-label" for="mail-send-condition">Turn this switch on to send mail to all user</label>
            </div>

          </div>
        </div>

        <div class="form-group row" id="select-user-div">
          <label for="example-search-input" class="col-sm-2 col-form-label">Send To Users</label>
          <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control" name="users[]" multiple="multiple">
              @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- <div class="form-group row" id="select-schedule" style="visibility: hidden;">
          <label for="example-search-input" class="col-sm-2 col-form-label">Schedule Date</label>
          <div class="col-sm-10">
            <input class="form-control" type="date" name="scheduled_at">
          </div>
        </div> -->

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label"> Mail Title</label>
          <div class="col-sm-10">
            <input class="form-control" name="title" placeholder="mail title" required>


          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Body</label>
          <div class="col-sm-10">
            <textarea name="body" style="width: 100%;height:100px;" required>
              @if(isset($product))
                {{ $product->description }}
              @endif
            </textarea>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-lg-9"></div>
          <div class="col-lg-3 float-right">
            <button class="form-control btn btn-primary" type="submit">{{ $submitButtonText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-1"></div>
</div>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });

  $('#mail-send-condition').on('change.bootstrapSwitch', function(e) {
    if (e.target.checked == true) {
      $("#select-user-div").css('visibility', 'hidden');
      // $("#select-schedule").css('visibility', 'visible');
    } else {
      $("#select-user-div").css('visibility', 'visible');
      // $("#select-schedule").css('visibility', 'hidden');
    }
  });
</script>
@endsection