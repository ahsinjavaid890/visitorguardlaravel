<link rel="stylesheet" type="text/css" href="{{ asset('public/front/tabs/formlayoutone.css')}}"> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="container">
   <div class="row">
      <div class="col-md-12 text-center mt-4 mb-0">
         <h1 class="form-one-heading text-danger">{{ $data->pro_name }}</h1>
         <h2 class="mb-2 heading-description mobile-deisply-none">It's fast and easy using our secure online application.</h2>
      </div>
   </div>
         <div class="row mainsection birthdate">
            <div class="col-md-7 leftsection">
               <form method="POST" action="{{ url('quotes') }}">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $data->pro_id }}">
                  <div class="row">
                     @for($orderi=1;$orderi<=17;$orderi++)
                     @if(array_search("id_1",$orderdata) == $orderi)
                     @if(isset($fields['fname']))
                     @if($fields['fname'] == 'on')
                     <div class="col-md-5 ">
                        <label for="firstname" class="form-label d-md-block lables">First name</label>
                     </div>
                     <div class="col-md-7">
                        <label for="firstname" class="d-sm-none  ">First name</label>
                        <div class="custom-form-control">
                           <input type="text" name="fname" placeholder="firstname" required id="firstname" class="form-input">
                        </div>
                     </div>
                     @endif
                     @endif
                     @if(isset($fields['lname']))
                     @if($fields['lname'] == 'on')
                     <div class="col-md-5">
                        <label for="lname" class="form-label lables" >Last name</label>
                     </div>
                     <div class="col-md-7">
                        <label for="lname" class=" d-sm-none">Last name</label>
                        <div class="custom-form-control">
                           <input type="text" name="lname" placeholder="lastname" required id="lname" class="form-input">                        </div>
                     </div>
                     @endif
                     @endif
                     @endif
                     @if(array_search("id_7",$orderdata) == $orderi)
                     @if(isset($fields['phone']))
                     @if($fields['phone'] == 'on')
                     <div class="col-md-5">
                        <label for="phone" class="form-label lables" >Phone <b id="phone_error" class="text-danger"></b></label>
                     </div>
                     
                     <div class="col-md-7">
                        <label class="icon-left" for="phonenumbermask" style="color: rgb(245, 130, 31);font-size: 17px;height: 19px;line-height: 38px !important;opacity: .6;position: absolute;text-align: center;top:0px;width: 42px;z-index: 2; left:14px;">
                           <i class="fa fa-phone" style="border-right: 1px solid #666;padding-right: 8px;"></i>
                        </label>
                        <label for="phonenumbermask" class="d-sm-none" >Phone Number<b id="phone_error" class="text-danger"></b></label>
                        <div class="custom-form-control">
                           <input onkeyup="validatephone()" type="text" id="phonenumbermask"  name="phone" placeholder="000-000-0000" data-placeholder="000-000-0000" inputmode="numeric" required id="phone" class="oldTraveler" style="padding-left: 40px !important">
                        </div>
                     </div>
                     <script>
                        function validatephone(){
                           var checkphone = document.getElementById('phone').value;
                           document.getElementById('phone').value = checkphone.replace(/\D/g,'');
                           if (checkphone.length < 10) {
                           document.getElementById('phone_error').innerHTML = '<small>(Must be 10 digits)</small>';
                           document.getElementById('getquote').disabled = true;  
                           } else {
                           document.getElementById('getquote').disabled = false; 
                           document.getElementById('phone_error').innerHTML = '';
                           }
                           }
                     </script>
                     @endif
                     @endif
                     @endif
                     @if(array_search("id_17",$orderdata) == $orderi)
                     @if(isset($fields['sum_insured']))
                     @if($fields['sum_insured'] == 'on')
                     <div class="col-md-5">
                        <label for="coverageammount "  class="form-label lables ">Maximum Coverage Amount</label>
                     </div>
                     <div class="col-md-7">
                        <label for="coverageammount" class="d-sm-none">Maximum Coverage Amount</label>
                        <div class="custom-form-control">
                           <select required class="form-input" name="sum_insured2" id="coverageammount">
                              <option value="">Coverage Amount</option>
                              @foreach($sum_insured as $key=> $r)
                              <option value="{{ $r->sum_insured }}" @if($key == 0) selected
                              @endif>${{ $r->sum_insured }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     @endif
                     @endif
                     @endif

                     @if(array_search("id_6",$orderdata) == $orderi)
                     @if(isset($fields['Country']))
                        @if($fields['Country'] == "on" )
                           @if($data->pro_travel_destination == 'worldwide')
                            <script>
                              function CountryState(id) {
                                  if(id=="Canada")
                                  {
                                      $('#canadastate').fadeIn();
                                    //   $('#country').removeClass('col-md-12')
                                    //   $('#country').addClass('col-md-6')
                                    //   $('#cnt').css("margin-left","7.8rem");
                                  }else 
                                  {
                                      $('#canadastate').hide();
                                      $('#country').removeClass('col-md-6')
                                      $('#country').addClass('col-md-12')
                                      
                                 }
                              }
                           </script>
                           <div id="country" class="col-md-12" >
                              <div class="row">

                         
                              <div class="col-sm-5">
                                 <label style="margin-left: -11.5px;" for="primary_destination" class="form-label lables" >Primary Destination</label>
                              </div>
                              <div class="col-md-7 " style="margin-right:0 !important">
                                 <label  for="primary_destination" class="d-sm-none">Primary Destination</label>
                              <div class="custom-form-control form-select" id="cnt">
                                 <select style=" width: 386px;border-radius: 1px;" onchange="CountryState(this.value)" required class="form-input" name="primary_destination" id="primary_destination">
                                    <option value="">Select Country</option>
                                    @foreach(DB::table('countries')->get() as $r)
                                       <option value='{{ $r->name }}'  data-imagecss="flag {{ $r->data_imagecss }}" data-title="{{ $r->name }}">{{ $r->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              </div>
                           </div>    
                         </div>
                           <div id="canadastate" class="col-md-12" style="display:none;">
                              <div class="row">
                              <div class="col-md-5">
                                 <label style="margin-left: -11.5px;" for="primary_destination" class="form-label lables" id="">States In Canda</label>
                              </div>
                              <div class="col-md-7">
                                 <label for="primary_destination" class="d-sm-none" >States In Canda</label>
                                 <div class="custom-form-control" id="states">
                                    <select style=" width: 386px;border-radius: 1px;"  required class="form-input" name="primary_destination" id="primary_destination">
                                       <option value="">Primary destination in Canada</option>
                                       @foreach(DB::table('primary_destination_in_canada')->get() as $r)
                                          <option @if($r->name == 'Ontario') selected @endif value="{{ $r->name }}">{{ $r->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                           @else
                           <div class="col-md-5">
                              <label for="primary_destination" class="form-label lables" id="">Primary destination in Canada</label>
                           </div>
                           <div class="col-md-7" >
                              <label for="primary_destination" class="d-sm-none">Primary destination in Canada</label>
                              <div class="custom-form-control">
                                 <select required class="form-input" name="primary_destination" id="primary_destination">
                                    <option value="">Primary destination in Canada</option>
                                    @foreach(DB::table('primary_destination_in_canada')->get() as $r)
                                       <option @if($r->name == 'Ontario') selected @endif value="{{ $r->name }}">{{ $r->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           @endif
                        @endif
                     @endif
                     @endif

                     @if(array_search("id_3",$orderdata) == $orderi)
                     @if(isset($fields['traveller']) && $fields['traveller'] == "on" )
                        @php
                           $number_of_travel = $fields['traveller_number'];
                        @endphp
                        @if($number_of_travel > 0)
                        <div class="col-md-5">
                              <label for="number_travelers" class="form-label lables" id="">Number of Travellers</label>
                           </div>
                           <div class="col-md-7">
                           <label for="number_travelers" class="d-sm-none">Number of Travellers</label>
                           <div class="custom-form-control">
                              <select onchange="checknumtravellers(this.value)" required class="form-input" name="number_travelers" id="number_travelers">
                                 <option value="">Number of Travellers</option>
                                 @for($i=1;$i<=$number_of_travel;$i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                           </div>
                        </div>


                        @if(isset($fields['dob']) && $fields['dob'] == "on" )

                           @php
                              $ordinal_words = array('oldest', 'oldest', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth');
                              $c = 0;
                           @endphp

                           @for($i=1;$i<=$number_of_travel;$i++)
                           <div style="display: none;" id="traveler{{ $i }}" class="no_of_travelers col-md-12">
                              <div class="row">
                                 <div class="col-md-5">
                                    <label for="day" class="form-label lables" id="" style="    margin-left: -11.5px;">Birth date of the <?php echo $ordinal_words[$i];?> Traveller</label>
                                 </div>
                                 <div class="col-md-7 padding-left-eight-on-mobile" style="padding-right:0px !important">
                                       <label for="day" class="d-sm-none" >Birth date of the oldest Traveller</label>
                                       <div class="custom-form-control">
                                          <input id="dateofbirthfull{{ $i }}" class=" oldTraveler" type="text" inputmode="numeric" placeholder="MM/DD/YYYY" name="years[]" >
                                       </div>
                                    </div>
                                    <div class="col-md-5">
                                       <label for="day" class="form-label lables" id="" style="    left:0">Pre Existing of <?php echo $ordinal_words[$i];?></label>
                                    </div>
                                    <div style="padding-right: 0px;" class="col-md-7 padding-left-eight-on-mobile">
                                       <label for="day" class="d-sm-none">Select Pre Existing</label>
                                       <div class="custom-form-control">
                                          <select id="pre_existing{{ $i }}" name="pre_existing[]" class="form-input">
                                             <option value="">Select Pre Existing Condition</option>
                                             <option value="yes">Yes</option>
                                             <option value="no">No</option>
                                           </select>
                                       </div>
                                    </div>
                                 </div>
               
      
                           </div>
                           @endfor
                        @endif
                        @endif
                     @endif
                     @endif
                     @if(array_search("id_8",$orderdata) == $orderi)
                     @if(isset($fields['sdate']) && $fields['sdate'] == "on" && isset($fields['edate']) && $fields['edate'] == "on")
                     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                     <div class="col-md-5 col-xs-12 ">
                        <label class="input-label preinfo">Start Date of Coverage <i class="fa fa-info" style="z-index: 99999;"><span>
                                    <strong>Start Date</strong><br>
                              The date of the coverage start from.
                              </span></i>
                        </label>
                     </div>
                     <div class="col-md-7 input">
                           <label for="departure_date" class="d-none">Start Date of Coverage</label>
                           <label  for="" onclick="(this.type='date')" style="color: rgb(245, 130, 31);font-size: 17px;height: 19px;line-height: 38px !important;opacity: .6;position: absolute;text-align: center;top:0px;width: 42px;z-index: 2; left:14;">
                           <i class="fa fa-calendar"   style="border-right: 1px solid #666;padding-right: 8px;"></i>
                     </label>
                        <div class="custom-form-control">
                           <input style="padding-left:40px;    border: 1px solid rgb(173, 173, 173) !important;" id="departure_date" autocomplete="off" name="departure_date" value=""  class="form-control"  type="text" placeholder="Start Date" required <?php if($data->pro_supervisa == 1){?> onchange="supervisayes()" <?php } ?>>
                           <script>
                           $('#departure_date').datepicker({
                           format: 'yyyy-mm-dd',
                           todayHighlight:'TRUE',
                           autoclose: true,
                           });
                        </script>                      
                        </div>
                     </div>
                     <div class="col-md-5 col-xs-12 " style="padding-right:0px;">
                           <label class="input-label preinfo">End Date of Coverage <i class="fa fa-info" style="z-index: 99999;"><span>
                                    <strong>End Date</strong><br>
                              This is the date when your coverage will expire.
                              </span></i> </label>

                     </div>
                     <div class="col-md-7">
                        <label for="departure_date" class="d-none">End Date of Coverage</label>
                        <label  for="departure_date" style="color: rgb(245, 130, 31);font-size: 17px;height: 19px;line-height: 38px !important;opacity: .6;position: absolute;text-align: center;top:0px;width: 42px;z-index: 2; left:14;">
                           <i class="fa fa-calendar" onclick="" style="border-right: 1px solid #666;padding-right: 8px;"></i>
                        </label>
                        <div class="custom-form-control">


                           <input style="padding-left:40px;    border: 1px solid rgb(173, 173, 173) !important;" id="return_date" autocomplete="off" name="return_date" value=""  class="form-control"  type="text" placeholder="End Date" required @if($data->pro_supervisa == 1) readonly type="date" @endif >

                           @if($data->pro_supervisa != 1)
                           <script>
                              $('#return_date').datepicker({
                              format: 'yyyy-mm-dd',
                              todayHighlight:'TRUE',
                              autoclose: true,
                              });
                           </script>  
                           @endif
                           
                        </div>
                     </div>
                     @endif
                     @endif
                     @if(array_search("id_4",$orderdata) == $orderi)
                     @if(isset($fields['email']))
                        @if($fields['email'] == "on" )
                        <div class="col-md-5">
                           <label for="savers_email" class="form-label lables" id="">Email</label>
                        </div>
                        <div class="col-md-7">
                              <label for="savers_email" class="d-sm-none">Email</label>
                              <label class="icon-left" for="savers_email" style="color: rgb(245, 130, 31);font-size: 17px;height: 19px;line-height: 38px !important;opacity: .6;position: absolute;text-align: center;top: 0px;width: 42px;z-index: 2; left:14px;">
                                 <i class="fa fa-envelope-o" style="border-right: 1px solid #666;padding-right: 8px;"></i>
                              </label>
                              <div class="custom-form-control">
                                 <input type="text" name="savers_email" placeholder="name@example.com" required id="savers_email" class="oldTraveler" style="padding-left: 40px !important">
                                 {{-- <label for="savers_email" class="form-label">Email</label> --}}
                              </div>
                           </div>
                        @endif
                     @endif
                     @endif
                     @if(array_search("id_14",$orderdata) == $orderi)
                        @if(isset($fields['gender']) && $fields['gender'] == "on" )
                        <div class="col-md-5">
                           <label for="gender" class="form-label lables" id="">Primary Applicant`s Gender</label>
                        </div>
                        <div class="col-md-7">
                           <label for="gender" class="d-sm-none">Primary Applicant`s Gender</label>
                           <div class="custom-form-control">
                              <select required class="form-input" name="gender" id="gender">
                                 <option value="">Select Gender</option>
                                   <option value="male" >Male</option>
                                   <option value="female" >Female</option>
                              </select>
                           </div>
                        </div>
                        @endif
                        @endif
                        @if(array_search("id_12",$orderdata) == $orderi)
                        @if(isset($fields['traveller_gender']) && $fields['traveller_gender'] == "on" )
                        <div class="col-md-5">
                           <label for="old_traveller_gender" class="form-label lables" id="">Gender of the Oldest traveller</label>
                        </div>
                        <div class="col-md-7">
                           <label for="old_traveller_gender" class="d-sm-none">Gender of the Oldest traveller</label>
                           <div class="custom-form-control">
                              <select required class="form-input" name="old_traveller_gender" id="old_traveller_gender">
                                 <option value="">Select Gender</option>
                                   <option value="male" >Male</option>
                                   <option value="female" >Female</option>
                              </select>
                           </div>
                        </div>
                        @endif
                        @endif
                        @if(array_search("id_5",$orderdata) == $orderi)
                           @if(isset($fields['Smoke12']))
                           @if($fields['Smoke12'] == 'on')
                           <div class="col-md-5">
                              <label for="" class="form-label lables" id="">Do you Smoke in last 12 months?</label>
                           </div>
                           <div class="col-md-7">
                              <label for="" class="d-sm-none">Do you Smoke in last 12 months?</label>
                              <div class="custom-form-control">
                                 <select required class="form-input" name="Smoke12" id="">
                                    <option value="">--- Please Choose ---</option>
                                      <option value="yes" >Yes</option>
                                      <option value="no" >No</option>
                                 </select>
                              </div>
                           </div>
                           @endif
                        @endif
                        @endif
                     
                        @if(array_search("id_12",$orderdata) == $orderi)
                        @if(isset($fields['fplan']))
                           @if($fields['fplan'] == 'on')
                               <div class="col-md-5">
                                 <label for="gender" class="form-label lables" id="">Do you require Family Plan?</label>
                              </div>
                              <div class="col-md-7">
                                 <label for="" class="d-sm-none">Do you require Family Plan ?</label>
                                 <div class="custom-form-control">
                                    <select onchange="changefamilyyes(this.value)" required class="form-input" name="fplan" id="selectfamilyplan">
                                       <option value="">--- Please Choose ---</option>
                                         <option value="yes">Yes</option>
                                         <option value="no">No</option>
                                    </select>
                                 </div>
                              </div>
                                 <input type="hidden" id="familyplan_temp" name="familyplan_temp" value="no">
                                 <script>
                                    function changefamilyyes(id){
                                       if(id == 'yes')
                                       {
                                          document.getElementById('familyplan_temp').value = 'yes';
                                          checkfamilyplan();
                                       }else{
                                          document.getElementById('familyplan_temp').value = 'no';
                                          checkfamilyplan();
                                       }
                                    }
                                 </script>
                           @endif
                        @endif
                        @endif
                     @endfor
                     
                  </div>
                  <div class="row">
                     <div class="col-md-6 width-50-percent" id="lowestprice">
                        <img src="{{ url('public/front/bgs/low_pr_icon.png') }}">
                     </div>
                     <div class="col-md-6 col-xs-6 width-50-percent" style="padding-right: 14px;">
                     <span id="family_error" style="display: none; font-size: 15px;font-weight: bold;text-align: right;padding: 20px;" class="text-danger"><i class="fa fa-warning"></i> </span>
                        <button type="submit" name="GET QUOTES" id="GET_QUOTES" class="btn  pull-right" style="display: block;border-radius: 4px !important;">Get a Quote <i class="fa fa-angle-double-right"></i> </button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="col-md-5 mobile-deisply-none">
                  <div class="imagesection">
                     <div class="row">
                        <div class="">
                           <img src="{{ url('public/front/bgs/Super-Visa-Insurance-visitorguard.ca.jpg') }}">
                        </div>
                        <div class="col-md-12 text-center" style="padding-top:20px;text-align: justify !important;background: #f0f0f0;margin-top: 10px;max-height: 335px;overflow-y: auto;border: 1px solid #ddd;font-size: 14px;line-height: 1.42857143;color: #333;">
                           <strong>Why Choosing us</strong>: we are reputed experience insurance   provider, we provide flexible and affordable Travel Insurance Plan from   multiple insurance companies like <a href="" target="_blank">Manulife Insurance</a>, GMS, <a href="" target="_blank">TIC Insurance</a>,   SRMRM insurance, Travelance Insurance, TUGO, 21st Century,&nbsp;we provide   services in Kitchener, Waterloo, Cambridge, Guelph, Stratford ,Hamilton,   Branford, Woodstock, London, Milton, Mississauga, Brampton, Toronto. <strong>Super Visa Insurance</strong>&nbsp;:&nbsp;Super Visa is a new option for   parents and grandparents of Canadian citizens and permanent residents to   visit their family in Canada. These individuals may be eligible to   apply for the Parent and Grandparent Super Visa to visit their family in   Canada for up to 2 years without the need to renew their status. Super   Visa Insurance provides coverage for emergency medical and hospital care   in Canada. This insurance is valid for 365 days.

                           <h2 style="    color: #000;   margin: 0 0 30px 0;line-height: 1.5; -webkit-font-smoothing: antialiased;">How to Apply for Super Visa Insurance</h2>
                           <ul  style="padding-inline-start: 40px;margin-bottom: 30px;}">
                             <li class="liststyle">
                              Fill out the 
                              <a style="display:inline" href="http://www.cic.gc.ca/english/pdf/kits/forms/IMM5257E.PDF">Application for a Temporary Resident Visa Made Outside of Canada [IMM5257]
                              </a>.
                           </li>
                             <li class="liststyle">Gather any required documentation.</li>
                             <li class="liststyle">Submit your completed form and supporting documents to a visa office.</li>
                             <li class="liststyle">Make sure to pay the 
                              <a href="http://www.cic.gc.ca/english/information/offices/apply-where.asp">fee that coincides with your country or region</a>.
                           </li>
                             <li class="liststyle">Make sure to purchase <a href="">Visitors to Canada insurance</a></li>
                           </ul>

                           <p><strong>Super visa Requirements&nbsp;:&nbsp;</strong>To obtain a Parent or   Grandparent Super Visa for Canada, applicants must have valid Super Visa   Insurance. With Super Visa applications They need to provide a proof   that they have private medical insurance from a Canadian insurance   company valid for a minimum of 1 year from a Canadian insurance company   and that it:    &nbsp; <strong>Here’s the things you need to know before you buy Super Visa Insurance </strong> <strong>Pre-existing Conduction: </strong>A Pre-existing condition   depends on your health condition means the critical illness, injury,   symptom(s) that exists before and after effective date of insurance.   Sometimes a healthy applicant can be deemed to have a pre-existing   condition based on a past health problem or evidence of treatment for a   particular condition. <strong>Deductible:</strong> Most plans have a variety of deductibles.   The deductible is the amount of each claim that you will pay. A $0   deductible means the insurance company pays 100% of each eligible claim.   A $1000 deductible means you will pay up to $1000 of each eligible   claim and the insurance company will only pay amounts in excess of the   $1000. <strong>Multiple Entry</strong>: Multiple entry coverage provides   intermittent coverage that allows you to travel back and forth between   Canada and your home country. Your coverage will be interrupted when you   return to your home country, and then be automatically reinstated when   you return to Canada. Plans that do not offer Multiple Entry have   coverage that stops as soon as you return to your home country. <strong>Side Trip: Side</strong> trip coverage provides travel health   insurance for any trips you take outside Canada during your stay, i.e.   if you take vacations to the U.S. If you expect to spend some time   outside of Canada during the term of your super visa, you should choose a   plan that has side trip coverage. <strong>Refundable</strong>: The government requires that you purchase   coverage for a full year. If you’re planning on staying less than a year   a refundable plan will allow you to receive a refund of the unused   portion of the annual/yearly premiums. These refunds come with   conditions, so again it’s important that you read the policy.</p>
                           </div>
                     </div>
                  </div>
                  
            </div>
         </div>
  
</div>
<script type="text/javascript" src="{{ url('public/front/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
   $( document ).ready(function() {
       $('#dateofbirthfull1').mask('00/00/0000');
       $('#dateofbirthfull2').mask('00/00/0000');
       $('#dateofbirthfull3').mask('00/00/0000');
       $('#dateofbirthfull4').mask('00/00/0000');
       $('#dateofbirthfull5').mask('00/00/0000');
       $('#dateofbirthfull6').mask('00/00/0000');
       $('#phonenumbermask').mask('000-000-0000');
   });
</script>
<script>
       jQuery('#gender:before').click(function() {
           var text = jQuery(this).attr('data-on-text');
   //        var text2 = jQuery(this).attr('data-off-text');
   //        checkbox-6
            console.log(text);
   //         console.log(text2);
       });
       function subform(){
           alert('submit form');
           return false;
       }
       jQuery(document).ready(function($){
        jQuery("#GET_QUOTES").on("click",function(){
        });
   /*
           $("#number_travelers").on("change", function(){
            //Number OF Traveller
            var number_of_traveller = $("#number_travelers").val();
            var aa = "";
            for(var i=2; i<=number_of_traveller; i++){
            var aa = aa + $("#birthday")[0].outerHTML;
            }
            $("#birthday_view").html(aa);
           })
   */
           $("button[type=submit]").on("change", function(){
               //function validateForm() {
               //if($(this).val() > 1){
               ///      alert('fsd');
               //       return false;
               //}
               //}
           });
   
           $('button[type="submit"]').click(function() {
               if($("select[name=number_travelers]").val()>1  && $("select[name=familyplan]").val() == "1"){
                   var counter = 0;
                   var aged=[];
                   $("select[name=birth_month\\[\\]]").each(function(){
                       //alert( $("select[name=birth_month\\[\\]]").eq(counter).val() );
                       var d = new Date( $("select[name=birth_year\\[\\]]").eq(counter).val() ,   $("select[name=birth_month\\[\\]]").eq(counter).val()-1,  $("select[name=birth_day\\[\\]]").eq(counter).val() );
                       var tDate = new Date();
                       var age=tDate.getFullYear() - d.getFullYear();
                       aged.push(age);
                       var max=Math.max.apply(Math,aged);
                       var min=Math.min.apply(Math,aged);
                       //if((max>="21" && max<="58") && (min>="1" && min<"21")){
                       if((max < 58) && (min >0 && min < 21)){
                           $("#familymsg").hide();
                           return true;
                       }else{
                           $("#familymsg").show();
                           return false;
                       }
                       counter++;
                   })
               }else{
                   $("#familymsg").hide();
               }
           });
   
   /*       $('#GET_QUOTES').click(function(){
            var deparature = $('#departure_date').val();
            $('#departuredate').val(deparature);
        var returndate = $('#return_date').val();
            $('#returndate').val(returndate);
        });
   */
       });
</script>
<script src="{{ asset('public/front/js/jquery-1.12.4.min.js')}}"></script>
<script>
   function supervisayes(){
   //window.setTimeout(function(){ 
       var tt = document.getElementById('departure_date').value;
       var date = new Date(tt);
       var newdate = new Date(date);
       newdate.setDate(newdate.getDate() + 364);
       var dd = newdate.getDate();
       var mm = newdate.getMonth() + 1;
       var y = newdate.getFullYear();
       if(mm <= 9){
       var mm = '0'+mm;    
       }
       if(dd <= 9){
       var dd = '0'+dd;    
       }
       var someFormattedDate = mm + '/' + dd + '/' + y;
       // var someFormattedDate = y + '-' + mm + '-' + dd;
       document.getElementById('return_date').value = someFormattedDate;
       //alert(someFormattedDate);
   //}, 1000);
   
      checknumtravellers();
   }
   
   function checktravellers(){
       //Number OF Traveller
       var number_of_traveller = $("#number_travelers").val();
       for(var t=2; t<=8; t++){
           $("#traveller_"+t).hide();
           $("#add_" +t).prop("required", false);
       }
       for(var i=2; i<=number_of_traveller; i++){
           $("#traveller_"+i).show();
           $('#add_'+i).prop("required", true);
       }
       //reset values for other people
       var numt = $('#number_travelers').val() || 1;
       var one = 1;
       var num = parseInt(numt) + parseInt(one);
       for(var a=num; a<8; a++){
           $('#add_'+a).val('');
           $('#add_'+a).prop('required', false);
      }
      checkfamilyplan();
   }
   
   
   function checkfamilyplan(){
       //Eligibility
       var titles = $('input[name^=years]').map(function(idx, elem) {
          return $(elem).val();
        }).get();
         var ages = [];
         for (var i = 0; i < titles.length; i++) {
            if(titles[i])
            {
               dob = new Date(titles[i]);
               var today = new Date();
               var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
               ages.push(age);
            }
         }
         Array.prototype.max = function() {
           return Math.max.apply(null, this);
         };
         Array.prototype.min = function() {
           return Math.min.apply(null, this);
         };
   
       var max_age = ages.max();
       var min_age = ages.min();
       if($('#familyplan_temp').val() == 'yes'){
           if($('#number_travelers').val() >='2' && max_age <=59 && min_age <=21){
               $('#GET_QUOTES').css('display', 'block');
               $('#family_error').html('');
               $('#family_error').css('display', 'none');
           } 
           else {
               $('#GET_QUOTES').css('display', 'none');
               if($('#number_travelers').val() <'2'){
                   $('#family_error').html('<i class="fa fa-warning"></i> Minimum 2 travellers required for family plan.');
               } 
               else if(max_age > 59){
                   $('#family_error').html('<i class="fa fa-warning"></i> Maximum age for family plan should be 59');  
               } 
               else if(min_age > 21){
                   $('#family_error').html('<i class="fa fa-warning"></i> For family plan the youngest traveller shouldn`t be elder than 21'); 
               }
               $('#family_error').css('display', 'block'); 
           }
       } 
       else {
           $('#GET_QUOTES').css('display', 'block');
           $('#family_error').css('display', 'none');  
       }
       
   }
</script>