<div class="row mt-4">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">



                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title"
                            value="{{ !empty($opportunity->title) ? $opportunity->title:'' }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Subtitle</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="subtitle"
                            value="{{ !empty($opportunity->subtitle) ? $opportunity->subtitle:'' }}" lines="5" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" name="description"
                            id="description">{{ !empty($opportunity->description) ? $opportunity->description:'' }}</textarea>


                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Opportunity Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="opportunity_date"
                            value="{{ !empty($opportunity->opportunity_date) ? $opportunity->opportunity_date:'' }}"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Duration (Days)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="duration"
                            value="{{ !empty($opportunity->duration) ? $opportunity->duration:'' }}" required>


                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Reward ($)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="reward"
                            value="{{ !empty($opportunity->reward) ? $opportunity->reward:'' }}" required>


                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Icon Image</label>
                    <div class="col-sm-10">
                        <div id="icon_image" class="input-images mt-5"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Cover Image</label>
                    <div class="col-sm-10">
                        <div id="cover_image" class="input-images mt-5"></div>
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