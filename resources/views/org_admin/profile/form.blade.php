<div class="row mt-4">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">



                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="full_name"
                            value="{{ !empty($profile->full_name) ? $profile->full_name:'' }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address"
                            value="{{ !empty($profile->address) ? $profile->address:'' }}" lines="5" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        {{Form::select('gender', array('0' => 'Male', '1' => 'Female','2'=>'Others'),  !empty($profile->gender) ? $profile->gender:'',array('class'
                        => 'form-control'))}}


                    </div>
                </div>





                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <div id="photo" class="input-images mt-5"></div>
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