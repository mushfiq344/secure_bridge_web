<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title_key" value="{{ !empty($blog->title_key) ? $blog->title_key:'' }}">


          </div>
        </div>

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title" value="{{ !empty($blog->title) ? $blog->title:'' }}" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Content</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="content" id="content">{{ !empty($blog->content) ? $blog->content:'' }}</textarea>


          </div>
        </div>

        <!-- <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Terms</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="terms" id="terms">{{ !empty($terms->content) ? $terms->content:'' }}</textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Privacy</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="privacy" id="privacy">{{ !empty($privacy->content) ? $privacy->content:'' }}</textarea>


          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">FAQ</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="faq" id="faq">{{ !empty($faq->content) ? $faq->content:'' }}</textarea>


          </div>
        </div> -->
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