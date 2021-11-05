 <!-- Plain fields -->
 <div class="columns is-vcentered">
     <div class="column is-8 is-offset-2">
         <div class="flex-card light-bordered light-raised">
             <div class="card-body">

                 <form class="padding-20">
                     <div class="field">
                         <label class="form-label">Title</label>
                         <div class="control">
                             <input type="text" class="input is-medium" name="title"
                                 value="{{ !empty($opportunity->title) ? $opportunity->title:'' }}" required>

                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Subtitle</label>
                         <div class="control">
                             <input type="text" class="input is-medium" name="subtitle"
                                 value="{{ !empty($opportunity->subtitle) ? $opportunity->subtitle:'' }}" lines="5"
                                 required>
                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Description</label>
                         <div class="control">

                             <textarea class="input is-medium" rows="5" name="description"
                                 id="description">{{ !empty($opportunity->description) ? $opportunity->description:'' }}</textarea>
                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Opportunity Date</label>
                         <div class="control">

                             <input type="date" class="input is-medium" name="opportunity_date"
                                 value="{{ !empty($opportunity->opportunity_date) ? $opportunity->opportunity_date:'' }}"
                                 required>
                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Duration (days)</label>
                         <div class="control">


                             <input type="number" class="input is-medium" name="duration"
                                 value="{{ !empty($opportunity->duration) ? $opportunity->duration:'' }}" required>
                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Reward ($)</label>
                         <div class="control">

                             <input type="number" class="input is-medium" name="reward"
                                 value="{{ !empty($opportunity->reward) ? $opportunity->reward:'' }}" required>

                         </div>
                     </div>
                    @if($opportunity!=null)
                     <div class="field mt-20">
                         <label class="form-label">Enrollment</label>
                         <div class="control">
                             {{Form::select('is_active', array('0' => 'Continue', '1' => 'Stop'),  !empty($opportunity->is_active) ? $opportunity->is_active:'',array('class'
                        => 'input is-medium'))}}

                         </div>
                     </div>
                     @endif
                     <div class="field mt-20">
                         <label class="form-label">Icon Image</label>
                         <div class="control">
                             <div id="icon_image" class="input-images mt-5"></div>


                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Cover Image</label>
                         <div class="control">
                             <div id="cover_image" class="input-images mt-5"></div>


                         </div>
                     </div>
                     <div class="mt-20 has-text-right">
                         <button type="submit"
                             class="button button-cta no-lh btn-align secondary-btn is-bold raised">{{ $submitButtonText }}</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>