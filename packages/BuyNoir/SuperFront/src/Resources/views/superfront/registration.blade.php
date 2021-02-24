@extends('superfront_view::superfront.layouts.master')

@php
    $channel = company()->getCurrentChannel();
    
    if ( $channel ) {
        $homeSEO = $channel->home_seo;

        if (isset($homeSEO)) {
            $homeSEO = json_decode($channel->home_seo);

            $metaTitle = $homeSEO->meta_title;

            $metaDescription = $homeSEO->meta_description;

            $metaKeywords = $homeSEO->meta_keywords;
        }
    }
@endphp

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
    
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif



@endsection

@section('content-wrapper')

    {!! view_render_event('bagisto.saas.companies.home.content.before') !!}
 

    <div id="wrapper">
        <div id="content">
            <section class="section_account section-registration">
                <div class="container-fluid">
                     
                      
                     
                  <div class="row ">
                    <div class="col-12 text-right pt-3">
                      <a href={{config('app.url')}} class='btn outline btn-lg' id="regisCloseLink" ><i class='icon cross-icon'></i></a>
                    </div>
                    
                    <div class="col-md-8 col-lg-8 mx-auto">
                          <seller-registration></seller-registration>

                          @push('scripts')
                              <script type="text/x-template" id="seller-registration">
                                  <div class="company-content" id="buynoir-shop-registration">
                                      <div class="form-container" v-bind:style=" step_four ? 'margin-top: -30px;border: none;' : 'border: none;' ">
                                        <div class="head_nav">

                                            <div class="brand-logo">
                                                <a href="{{ route('buynoir.home.index') }}" class="btn btn_logo">
                                                        <img src="{{ asset('vendor/webkul/ui/assets/images/logo.png') }}" alt="{{ config('app.name') }}"/>
                                                </a>
                                            </div>

                                          </div>

                                        <form class="registration" data-vv-scope="step-one" v-if="step_one" @submit.prevent="validateForm('step-one')">
                                        

                                            <div class="step-navigator">
                                            <div class='registration-subtitle'>Launch your online business now.<br/>
                                                Free for 10 days</div>
                                            </div>


                                            <div class="control-group" :class="[errors.has('step-one.email') ? 'has-error' : '']">
                                                {{-- <label for="email" class="required">{{ __('saas::app.tenant.registration.email') }}</label> --}}

                                                <input type="text" v-validate="'required|email|max:191'" class="control" v-model="email" name="email" data-vv-as="&quot;{{ __('saas::app.tenant.registration.email') }}&quot;" placeholder="Email Address">

                                                <span class="control-error" v-show="errors.has('step-one.email')">@{{ errors.first('step-one.email') }}</span>
                                            </div>

                                            <div class="control-group" :class="[errors.has('step-one.password') ? 'has-error' : '']">
                                                {{-- <label for="password" class="required">{{ __('saas::app.tenant.registration.password') }}</label> --}}

                                                <input type="password" name="password" v-validate="'required|min:6'" ref="password" class="control" v-model="password" placeholder="Password" data-vv-as="&quot;{{ __('saas::app.tenant.registration.password') }}&quot;">

                                                <span class="control-error" v-show="errors.has('step-one.password')">@{{ errors.first('step-one.password') }}</span>
                                            </div>

                                            <div class="control-group" :class="[errors.has('step-one.password_confirmation') ? 'has-error' : '']">
                                                {{-- <label for="password_confirmation" class="required">{{ __('saas::app.tenant.registration.cpassword') }}</label> --}}

                                                <input type="password" v-validate="'required|min:6|confirmed:password'" class="control" v-model="password_confirmation" name="password_confirmation" placeholder="Confirm Password" data-vv-as="&quot;{{ __('saas::app.tenant.registration.cpassword') }}&quot;">

                                                <span class="control-error" v-show="errors.has('step-one.password_confirmation')">@{{ errors.first('step-one.password_confirmation') }}</span>
                                            </div>

                                            <div class="control-group text-right">
                                                <!-- <input type="submit" class="btn btn-lg btn-primary" :disabled="errors.has('password') || errors.has('password_confirmation') || errors.has('email')"  value="Continue"> -->
                                                <button class="btn btn-lg btn-warning registration-btn" :disabled="errors.has('step-one.password') || errors.has('step-one.password_confirmation') || errors.has('step-one.email')">{{ __('saas::app.tenant.registration.continue') }}</button>
                                            </div>
                                        </form>

                                        <form class="registration" @submit.prevent="validateForm('step-two')" data-vv-scope="step-two" v-show="step_two">
                                            <div class="step-two">
                                                {{-- <h3 class="mb-30">{{ __('saas::app.tenant.registration.step-2') }}:</h3>

                                                <h4>{{ __('saas::app.tenant.registration.personal') }}</h4> --}}

                                                <div class="step-navigator">
                                                <div class='registration-subtitle'>Tell us about you</div>
                                                </div>

                                                <div class="control-group" :class="[errors.has('step-two.first_name') ? 'has-error' : '']" >
                                                    {{-- <label for="first_name" class="required">{{ __('saas::app.tenant.registration.first-name') }}</label> --}}

                                                    <input type="text" class="control" v-model="first_name" name="first_name" placeholder="First Name" v-validate="'required|alpha_spaces'" data-vv-as="&quot;{{ __('saas::app.tenant.registration.first-name') }}&quot;">

                                                    <span class="control-error" v-show="errors.has('step-two.first_name')">@{{ errors.first('step-two.first_name') }}</span>
                                                </div>

                                                <div class="control-group" :class="[errors.has('step-two.last_name') ? 'has-error' : '']">
                                                    {{-- <label for="last_name">{{ __('saas::app.tenant.registration.last-name') }}</label> --}}

                                                    <input type="text" class="control" name="last_name" v-model="last_name" placeholder="{{ __('saas::app.tenant.registration.last-name') }}" v-validate="'alpha_spaces'" data-vv-as="&quot;{{ __('saas::app.tenant.registration.first-name') }}&quot;">

                                                    <span class="control-error" v-show="errors.has('step-two.last_name')">@{{ errors.first('step-two.last_name') }}</span>
                                                </div>

                                                <div class="control-group" :class="[errors.has('step-two.phone_no') ? 'has-error' : '']">
                                                    {{-- <label for="phone_no" class="required">{{ __('saas::app.tenant.registration.phone') }}</label> --}}

                                                    <input type="text" class="control" pattern="[-+]?\d*" name="phone_no" v-model="phone_no" placeholder="Phone Number" v-validate="'required|numeric'" data-vv-as="&quot;{{ __('saas::app.tenant.registration.phone') }}&quot;">

                                                    <span class="control-error" v-show="errors.has('step-two.phone_no')">@{{ errors.first('step-two.phone_no') }}</span>
                                                </div>

                                                <div class="control-group text-right">
                                                    <button class="btn btn-lg btn-warning registration-btn" :disabled="errors.has('first_name') || errors.has('last_name') || errors.has('step-two.phone_no')">{{ __('saas::app.tenant.registration.next') }}</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form class="registration" @submit.prevent="validateForm('step-three')" data-vv-scope="step-three" v-show="step_three">
                                            <div class="step-three">
                                                {{-- <h3 class="mb-30">{{ __('saas::app.tenant.registration.step-3') }}:</h3>

                                                <h4>{{ __('saas::app.tenant.registration.org-details') }}:</h4> --}}

                                                <div class="step-navigator">
                                                <div class='registration-subtitle'>Last step<br>
                                                    ok, let's talk about your store
                                                </div>
                                                </div>

                                                <div class="control-group" :class="[errors.has('step-three.username') ? 'has-error' : '']">
                                                    {{-- <label for="username" class="required">User Name</label> --}}

                                                    <input type="text" class="control" name="username" v-model="username" placeholder="{{ __('saas::app.tenant.registration.username') }}" v-validate="'required|alpha_spaces'" data-vv-as="&quot;{{ __('saas::app.tenant.registration.username') }}&quot;">

                                                    <span class="control-error" v-show="errors.has('step-three.username')">@{{ errors.first('step-three.username') }}</span>
                                                </div>

                                                <div class="control-group" :class="[errors.has('step-three.productcategory') ? 'has-error' : '']">

                                                    <select class="control" name="productcategory" v-model="productcategory" v-validate="'required'" >
                                                        <option value="" selected>{{ __('saas::app.tenant.registration.org-name') }}</option>
                                                        <option value="Clothing">Clothing</option>
                                                        <option value="CBD Products">CBD Products</option>
                                                        <option value="Food and Beverage">Food and Beverage</option>
                                                        <option value="Health and Beauty">Health and Beauty</option>
                                                        <option value="Home Decor">Home Decor</option>
                                                        <option value="Jewelry">Jewelry</option>
                                                        <option value="Services">Services</option>
                                                        <option value="Other Goods">Other Goods</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                    <span class="control-error" v-show="errors.has('step-three.productcategory')">@{{ errors.first('step-three.productcategory') }}</span>
                                                </div>

                                                <div class="control-group mt-4" :class="[errors.has('step-three.name') ? 'has-error' : '']">
                                                    <label for="elsebusiness" class="">{{ __('saas::app.tenant.registration.else-business') }}</label>
                                                    <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label style="color:#aa5352;">
                                                            <input type="radio" class="" id="elsebusinessStart" name="elsebusiness" v-model="elsebusinessStart" value="START"  v-validate="''" data-vv-as="&quot;{{ __('saas::app.tenant.registration.else-business') }}&quot;">
                                                            {{ __('saas::app.tenant.registration.just-start') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label style="color:#aa5352;">
                                                            <input type="radio" class="" id="elsebusinessMoving" name="elsebusiness" v-model="elsebusinessStart" value="MOVING" v-validate="''" data-vv-as="&quot;{{ __('saas::app.tenant.registration.else-business') }}&quot;">
                                                            {{ __('saas::app.tenant.registration.else-moving') }}
                                                        </label>
                                                    </div>
                                                    </div>

                                                </div>

                                                <div class="control-group text-right">
                                                    <button class="btn btn-lg btn-warning registration-btn" :disabled="errors.has('step-three.username') || errors.has('step-three.name') || createdclicked" style="font-size:18px">{{ __('saas::app.tenant.registration.create-store') }}</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form class="registration" data-vv-scope="step-four" v-show="step_four" id="formStepFour">
                                            <div class="step-three" style="margin-top:-25px">
                                                <div class="step-navigator">
                                                    <div class='registration-subtitle'>
                                                        <p>{{ __('saas::app.tenant.registration.congrats-title') }}</p> 
                                                        {{ __('saas::app.tenant.registration.congrats-subtitle') }}
                                                    </div>
                                                    <p class="text-center mt-4">{{ __('saas::app.tenant.registration.congrats-description') }}</p>
                                                </div>

                                                <div class="control-group text-center" :class="[errors.has('step-three.username') ? 'has-error' : '']">
                                                    <img src="{{ asset('buynoir/superfront/assets/img/congrats.gif') }}" alt="{{ config('app.name') }}" style="height:50vh"/>
                                                </div>

                                            
                                                <div class="row text-center" style="display:none">
                                                    <div class="col-6">
                                                        <a v-bind:href="redirectUrlShop" class="btn btn-lg btn-warning registration-btn" id="btn-congrts" style="font-size:18px">{{ __('saas::app.tenant.registration.visit-shop') }}</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a v-bind:href="redirectUrlAdmin" class="btn btn-lg btn-warning registration-btn" style="font-size:18px">{{ __('saas::app.tenant.registration.login-admin') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>



                                        <ul class="step-list registration-ul mt-3" v-bind:style="step_four?'display:none':''">
                                            <li class="registration-step-item" :class="{ active: isOneActive }" v-on:click="stepNav(1)"></li>
                                            <li class="registration-step-item" :class="{ active: isTwoActive }" v-on:click="stepNav(2)"></li>
                                            <li class="registration-step-item" :class="{ active: isThreeActive }" v-on:click="stepNav(3)"></li>
                                        </ul>

                                      </div>
                                  </div>
                              </script>

                              <script>
                                  
                                  var vDate = new Date();
                                  var nDigit = "BuyNoir-"+vDate.getTime();
                                  var registration = Vue.component('seller-registration', {
                                      template: '#seller-registration',
                                      inject: ['$validator'],
                                      data: () => ({
                                          data_seed_url: @json(route('company.create.data')),
                                          step_one: true,
                                          step_two: false,
                                          step_three: false,
                                          step_four: false,
                                          email: null,
                                          password: null,
                                          password_confirmation: null,
                                          first_name: null,
                                          last_name: null,
                                          phone_no: null,
                                          name: "",
                                          productcategory: "",
                                          elsebusinessStart: "START",
                                          username: null,
                                          createdclicked: false,
                                          registrationData: {},
                                          result: [],
                                          isOneActive: false,
                                          isTwoActive: false,
                                          isThreeActive: false,
                                          redirectUrlShop:"./",
                                          redirectUrlAdmin:"./admin"
                                      }),

                                      mounted() {
                                          this.isOneActive = true;
                                      },

                                      methods: {
                                          validateForm: function(scope) {
                                              var this_this = this;
                                              this.$validator.validateAll(scope).then(function (result) {

                                                  if (result) {
                                                      if (scope == 'step-one') {
                                                          this_this.catchResponseOne();
                                                      } else if (scope == 'step-two') {
                                                          this_this.catchResponseTwo();
                                                      } else if (scope == 'step-three') {
                                                          this_this.catchResponseThree();
                                                      }
                                                  }
                                              });
                                          },

                                          stepNav(step) {
                                              if (step == 1) {
                                                  if (this.isThreeActive == true || this.isTwoActive == true){
                                                      this.step_three = false;
                                                      this.step_two = false;
                                                      this.step_one = true;

                                                      this.isThreeActive = false;
                                                      this.isTwoActive = false;
                                                      this.isOneActive = true;
                                                  }
                                              } else if (step == 2) {
                                                  if (this.isThreeActive == true){
                                                      this.step_three = false;
                                                      this.step_one = false;
                                                      this.step_two = true;

                                                      this.isThreeActive = false;
                                                      this.isOneActive = false;
                                                      this.isTwoActive = true;
                                                  }
                                              }
                                          },

                                          catchResponseOne () {
                                              var o_this = this;

                                              axios.post('{{ route('company.validate.step-one') }}', {
                                                  email: this.email,
                                                  password: this.password,
                                                  password_confirmation: this.password_confirmation
                                              }).then(function (response) {
                                                  o_this.step_two = true;
                                                  o_this.step_one = false;
                                                  o_this.isOneActive = false;
                                                  o_this.isTwoActive = true;

                                                  o_this.errors.clear();
                                              }).catch(function (errors) {
                                                  serverErrors = errors.response.data.errors;

                                                  o_this.$root.addServerErrors('step-one');
                                              });
                                          },

                                          catchResponseTwo () {
                                              this.step_three = true;
                                              this.step_two = false;
                                              this.isTwoActive = false;
                                              this.isThreeActive = true;
                                          },

                                          catchResponseThree () {
                                              this.createdclicked = true;
                                              var o_this = this;
                                              var storeNameTmp = this.username.split(' ').join(''); 
                                              console.log("store name::", storeNameTmp)
                                              axios.post('{{ route('company.validate.step-three') }}', {
                                                  username: storeNameTmp,
                                                  productcategory: this.productcategory,
                                              }).then(function (response) {
                                                  o_this.errors.clear();
                                                  o_this.sendDataToServer();
                                              }).catch(function (errors) {
                                                  serverErrors = errors.response.data.errors;
                                                  o_this.createdclicked = false;
                                                  o_this.$root.addServerErrors('step-three');
                                              });
                                          },

                                          handleErrorResponse (response, scope) {
                                              serverErrors = response.data.errors;
                                              this.$root.addServerErrors(scope);
                                          },

                                          sendDataToServer () {
                                              var o_this = this;
                                              var usernameTm = this.username.split(' ').join(''); 
                                              return axios.post('{{ route('company.create.store') }}', {
                                                  email: this.email,
                                                  first_name: this.first_name,
                                                  last_name: this.last_name,
                                                  phone_no: this.phone_no,
                                                  password: this.password,
                                                  password_confirmation: this.password_confirmation,
                                                  name: "BuyNoir-"+this.username,
                                                  productcategory: this.productcategory,
                                                  username: usernameTm,
                                                  elsebusinessStart: this.elsebusinessStart
                                              }).then(function (response) {
                                                //   window.location.href = response.data.redirect;
                                                document.getElementById("regisCloseLink").style.display="none";
                                                o_this.step_one   = false;
                                                o_this.step_two   = false;
                                                o_this.step_three = false;
                                                o_this.step_four  = true;
                                                

                                                //this.redirectUrlShop = response.data.redirectShop;
                                                //this.redirectUrlAdmin = response.data.redirectAdmin;
                                                setTimeout(function(){
                                                    console.log("success registration");
                                                    //this.step_four = false;
                                                    window.location.href = response.data.redirect;
                                                },5000);
                                               
                                                
                                              }).catch(function (errors) {
                                                  serverErrors = errors.response.data.errors;

                                                  o_this.createdclicked = false;

                                                  for (i in serverErrors) {
                                                      window.flashMessages = [{'type': 'alert-error', 'message': serverErrors[i]}];
                                                  }

                                                  o_this.$root.addFlashMessages();
                                                  o_this.$root.addServerErrors('step-one');
                                                  o_this.$root.addServerErrors('step-two');
                                                  o_this.$root.addServerErrors('step-three');
                                              });
                                          }
                                      }
                                  });

                                  setTimeout(function(){
                                        var elseStart = document.getElementById('elsebusinessStart');
                                        if(elseStart){
                                            elseStart.checked=true;
                                        }
                                  },1500);
                                 

                              </script>
                          @endpush
                      
                    </div><!--- end mx-auto ---->
                  </div>
                </div>
              </section>
        </div><!-- end content -->
    </div><!-- end wrapper -->
    

    {{ view_render_event('bagisto.saas.companies.home.content.after') }}











@endsection




