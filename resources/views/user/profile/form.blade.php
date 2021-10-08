 <!-- Plain fields -->
 <div class="columns is-vcentered">
     <div class="column is-8 is-offset-2">
         <div class="flex-card light-bordered light-raised">
             <div class="card-body">

                 <form class="padding-20">
                     <div class="field">
                         <label class="form-label">Full Name</label>
                         <div class="control">
                             <input type="text" class="input is-medium" name="full_name"
                                 value="{{ !empty($profile->full_name) ? $profile->full_name:'' }}" required>


                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Address</label>
                         <div class="control">

                             <input type="text" class="input is-medium" name="address"
                                 value="{{ !empty($profile->address) ? $profile->address:'' }}" lines="5" required>
                         </div>
                     </div>
                     <div class="field mt-20">
                         <label class="form-label">Gender</label>
                         <div class="control">
                             {{Form::select('gender', array('0' => 'Male', '1' => 'Female','2'=>'Others'),  !empty($profile->gender) ? $profile->gender:'',array('class'
                        => 'input is-medium'))}}

                         </div>
                     </div>

                     <div class="field mt-20">
                         <label class="form-label">Photo</label>
                         <div class="control">
                             <div id="photo" class="input-images mt-5"></div>


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