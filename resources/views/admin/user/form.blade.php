<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">



        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input class="form-control" name="name" placeholder="Name" required>


          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input class="form-control" name="email" placeholder="Email" required>


          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            @if(isset($vendor->password))
            <div id="generated-password-div">
            </div>
            <button class="form-control btn btn-primary" id="generate-password-btn">Generate Password
            </button>
            @else
            <div id="generated-password-div">
            </div>
            <button class="form-control btn btn-primary" id="generate-password-btn">Generate Password
            </button>
            @endif
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