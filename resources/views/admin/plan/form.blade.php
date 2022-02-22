<div class="row mt-4">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="card">
      <div class="card-body">



        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input class="form-control" name="title" placeholder="Title" value="{{ !empty($plan->title) ? $plan->title:'' }}" required>


          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <input class="form-control" name="description" placeholder="Description" value="{{ !empty($plan->description) ? $plan->description:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Amount</label>
          <div class="col-sm-10">
            <input class="form-control" name="amount" placeholder="Amount" type="number" value="{{ !empty($plan->amount) ? $plan->amount:'' }}"  required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Duration</label>
          <div class="col-sm-10">
            <input class="form-control" name="duration" placeholder="Duration" type="number" step="1" min="0" max="365" value="{{ !empty($plan->duration) ? $plan->duration:'' }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-10">
          {{Form::select('', \App\Models\Plan::$planTypesNames,!empty($plan->type) ? $plan->type:'',array('class'
                        => 'form-control','required'=>'required','placeholder'=>"Type", "name"=>"type"))}}
          </div>
        </div>
        <div class="form-group row">
          <label for="example-search-input" class="col-sm-2 col-form-label">Mode</label>
          <div class="col-sm-10">
          {{Form::select('', \App\Models\Plan::$planModesNames,!empty($plan->mode) ? $plan->mode:'',array('class'
                        => 'form-control','required'=>'required','placeholder'=>"Mode", "name"=>"mode"))}}
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