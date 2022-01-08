<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">



        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">key Name</label>
          <div class="col-sm-10">
            <input class="form-control" name="key" placeholder="key name" value="{{ isset($setting->key)?$setting->key:'' }}" required>


          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Key value</label>
          <div class="col-sm-10">
            <textarea name="value" style="width: 100%;height:100px;" required>
              @if(isset($setting))
                {{ $setting->value }}
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
</script>
@endsection
