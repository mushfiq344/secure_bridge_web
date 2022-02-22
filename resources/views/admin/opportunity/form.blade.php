<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Owner</label>
          <div class="col-sm-10">
            {{Form::select('',[],'',array('class'
                        => 'form-control js-example-basic-single','required'=>'required','placeholder'=>"Owner", "name"=>"user_id"))}}
          </div>
        </div>

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input class="form-control" name="title" placeholder="Title" value="{{ !empty($opportunity->title) ? $opportunity->title:'' }}" required>


          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Subtitle</label>
          <div class="col-sm-10">
            <input class="form-control" name="subtitle" placeholder="Subtitle" value="{{ !empty($opportunity->subtitle) ? $opportunity->subtitle:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <div class="control">

              <textarea class="input is-medium" rows="5" name="description" id="description">{{ !empty($opportunity->description) ? $opportunity->description:'' }}</textarea>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Opportunity Date</label>
          <div class="col-sm-10">
            <input class="form-control" type="date" name="opportunity_date" placeholder="Opportunity Date" value="{{ !empty($opportunity->opportunity_date) ? $opportunity->opportunity_date:'' }}" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Reward</label>
          <div class="col-sm-10">
            <input class="form-control" name="reward" placeholder="Reward" type="number" value="{{ !empty($opportunity->reward) ? $opportunity->reward:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Duration</label>
          <div class="col-sm-10">
            <input class="form-control" name="duration" placeholder="Duration" type="number" step="1" min="0" max="365" value="{{ !empty($opportunity->duration) ? $opportunity->duration:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Location</label>
          <div class="col-sm-10">
            <input class="form-control" name="location" placeholder="Description" value="{{ !empty($opportunity->location) ? $opportunity->location:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-10">
            {{Form::select('', \App\Models\Opportunity::$opportunityTypes,!empty($opportunity->type) ? $opportunity->type:'',array('class'
                        => 'form-control','required'=>'required','placeholder'=>"Type", "name"=>"type"))}}
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Is Featured</label>
          <div class="col-sm-10">
            {{Form::select('',array("0"=>"No","1"=>"Yes"),!empty($opportunity->is_featured) ? $opportunity->is_featured:'',array('class'
                        => 'form-control','required'=>'required','placeholder'=>"Is Featured", "name"=>"is_featured"))}}
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Icon Image</label>
          <div class="col-sm-10">
            <div class="control">
              <div id="icon_image" class="input-images mt-5"></div>


            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Cover Image</label>
          <div class="col-sm-10">
            <div class="control">
              <div id="cover_image" class="input-images mt-5"></div>


            </div>
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