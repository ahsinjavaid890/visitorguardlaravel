<link rel="stylesheet" type="text/css" href="{{ url('public/front/tabs/pricelayouteight.css') }}">
<script>
    <?php
$ded = DB::select("SELECT `deductible1` FROM wp_dh_insurance_plans_deductibles WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$data->pro_id') GROUP BY `deductible1` ORDER BY `deductible1`");
?>
var Slider_Values = [<?php
                $d = 0;
                $havethousand = 'no';
                foreach($ded as $r){
                    $d++;
                        echo $dedivalue = $r->deductible1;
                    if($d < count($ded)){
                        echo ', ';
                    }
                    if($dedivalue == 1000)
                    { 
                        $havethousand = 'yes'; 
                    }
                } ?>];
<?php if($havethousand == 'yes'){?>
var dValue = Slider_Values.indexOf(1000);
<?php } else { ?>
var dValue = Slider_Values[0];
<?php } ?>
if(dValue == '-1'){ dValue = '0'; }
$(function () {
    $("#slider2").slider({
        range: "min",
        min: 0,
        max: Slider_Values.length - 1,
        step: 1,
        value: dValue,
        slide: function (event, ui) {
            $('#coverage_deductible').text(Slider_Values[ui.value]);
            //alert(Slider_Values.length);
            for (i = 0; i < Slider_Values.length; i++) {
                var group = Slider_Values[i];
                $('.deductable-'+group).css('display' , 'none');
            }
            $('.deductable-'+Slider_Values[ui.value]).css('display' , 'flex');
            $( "#coverage_deductible" ).val( "$" + Slider_Values[ui.value] );
            var uniqueClasses = {};
            $('#listprices .pricearray').each(function () {
                var currentClass = $(this).attr('class');
                if (!uniqueClasses.hasOwnProperty(currentClass)) {
                    uniqueClasses[currentClass] = true;
                } else {
                    $(this).hide();
                }
            });
        }
    });
});

<?php
$sum = DB::select("SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$data->pro_id') GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");
?>
//Sum Insured Slider
var SliderValues = [0,<?php
                $s = 0;
                foreach($sum as $r){
                $s++;
                echo $sumamount = $r->sum_insured;
                if($s < count($sum)){
                echo ', ';
                }
                } ?>];
var iValue = SliderValues.indexOf({{ $request->sum_insured2 }});
$(function () {
    $("#sum_slider2").slider({
        range: "min",
        min: 0,
        max: SliderValues.length - 1,
        step: 1,
        value: iValue,
        slide: function (event, ui) {
            $('#coverage_amount2').text(SliderValues[ui.value]);
            //alert(SliderValues.length);
            for (i = 0; i < SliderValues.length; i++) {
                var group = SliderValues[i];
                $('.coverage-amt-'+group).hide();
            }
            $('.coverage-amt-'+SliderValues[ui.value]).show();
            $( "#coverage_amount2" ).val( "$" + SliderValues[ui.value] );
            var uniqueClasses = {};
            $('#listprices .pricearray').each(function () {
                var currentClass = $(this).attr('class');
                if (!uniqueClasses.hasOwnProperty(currentClass)) {
                    uniqueClasses[currentClass] = true;
                } else {
                    $(this).hide();
                }
            });
        }
    });

});
</script>
<div class="dh-listings container paddingleftrightzeroonmobile" id="dh-get-quote">
    <?php
//  error_reporting(E_ERROR);
$startdate = $request->departure_date;
$enddate = $request->return_date;

$dStart = new DateTime($request->departure_date);
$dEnd  = new DateTime($request->return_date);
$dDiff = $dStart->diff($dEnd);
$dDiff->format('%R'); // use for point out relation: smaller/greater
$num_of_days = $dDiff->days + 1;
if($num_of_days > 365 || $num_of_days == 364){ $num_of_days = 365; }

//$num_of_days = 365;
$prosupervisa = $data->pro_supervisa;
$product_name = $data->pro_name;

if($prosupervisa == '1'){
$supervisa = 'yes';
$num_of_days = 365;
} else {
$supervisa = 'no';
}

    $enable_family_plan = (!empty($request->familyplan)) ? true : false;
    $enable_pre_existing = (!empty($request->pre_existing)) ? true : false;

    if($request->familyplan_temp == 'yes'){
    $enable_family_plan = true;
    } else {
    $enable_family_plan = false;
    }
    if($request->pre_existing == 'Yes'){
    $enable_pre_existing = true;
    } else {
    $enable_pre_existing = false;
    }

    $oldest_traveller = 0;
    $family_plan      = false;
 
    $years = array();

    foreach ($request->years as $r) {
        if($r)
        {
            $bday = new DateTime($r); // Your date of birth
            $today = new Datetime(date('m.d.y'));
            $diff = $today->diff($bday);
            $years[] =  $diff->y;
        }
    }


    if (is_array($years)){
        $ages_array = array_filter($years);
        $younger_age = min($ages_array);
        $elder_age = max($ages_array);
        $number_travelers = count($ages_array);
    }
    else {
        $younger_age = 0;
        $elder_age = 0;
        $number_travelers = 1;
    }

if($request->familyplan_temp == 'yes'){
    if($number_travelers >= 2 && ($elder_age >= 21 && $elder_age <=58) && ($younger_age <=21)){
        $family_plan = 'yes';
    }
    else {
        $family_plan = 'no';
    }
} else {
    $family_plan = 'no';
}

if($request->familyplan_temp == 'yes' && $family_plan == 'no'){
 //echo "<script>window.location='?action=not_eligible';</script>";
}
?>

    <div class="container paddingleftrightzeroonmobile">
        <div class="row">
            <div class="col-md-4" style="border-top:0px; ">
                <div class="adjust-quoto coverage-mobile-view " style=" background-color: white; border: 2px solid #c0c0c0; padding: 10px; margin-top: 10px; border-radius: 4px; ">
                    <h2 style="margin: 0;font-size: 26px;font-weight: bold;">Adjust your quotes</h2>
                    <h4 class="coverage"style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 0;border: none;text-align: left;"> Coverage: <input type="text" id="coverage_amount2" name="coverage_amount"
                            value="$<?php echo $request->sum_insured2;?>"
                            style="border:0; font-size:24px; color:#444; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 150px;">
                    </h4>
                    <div id="sum_slider2" style="border: 1px solid #c5c5c5;padding: 5px;box-shadow: 0px 0px 5px 0px inset #CCC;border-radius: 10px;margin: 26px 0px;">
                    </div>
                    <h4 class="deductible" style="margin: 0;padding: 0;font-weight: bold;margin-bottom: 0;border: none;text-align: left;">Deductible: <input type="text" id="coverage_deductible" name="coverage_deductible" value="$<?php if($havethousand == 'no'){ echo '0'; } else {echo '1000'; } ?>"
                            style="border:0; font-size:24px; color:#444; font-weight:bold;background: no-repeat;margin: 0;padding: 0;text-align: center;width: 100px;"></h4>
                    <div id="slider2" class="mt-0" style="border: 1px solid #c5c5c5;padding: 5px;box-shadow: 0px 0px 5px 0px inset #CCC;border-radius: 10px;margin: 26px 0px;">
                    </div>
                </div>
                <div class="adjust-quoto coverage-mobile-view pricegurrantee" style=" background-color: white; border: 2px solid #c0c0c0; padding: 10px; margin-top: 10px; border-radius: 4px; ">
                   <div class="card-guarantee text-center">
                      <figure class="card-guarantee__badge"><img src="https://assets.visitorscoverage.com/production/app/img/policy-portal/guarantee-badge.svg" alt="" class="img-fluid"></figure>
                      <div class="card-guarantee__heading" style="
                         margin: 16px 0 8px;
                         font-weight: 800;
                         font-size: 16px;
                         line-height: 18px;
                         ">Price Guarantee</div>
                      <div class="card-guarantee__copy" style="
                         margin-bottom: 0;
                         font-weight: 600;
                         font-size: 12px;
                         line-height: 18px;
                         color: #67778f;
                         ">A price guarantee is your assurance that you won't find the same insurance plan for a lower price elsewhere. Legal regulations are in place to protect consumers and maintain transparency within&nbsp;the&nbsp;industry</div>
                   </div>
                </div>
            </div>
            @if (in_array('yes', $request->pre_existing))
                @include('frontend.travelinsurance.includes.eight.yes')
            @else
                @include('frontend.travelinsurance.includes.eight.yes')
                @include('frontend.travelinsurance.includes.eight.no')
            @endif
        </div>
    </div>
    <!--    row end-->

<script>
    jQuery(function($) {
        var divList = $(".listing-item");
        divList.sort(function(a, b){ return $(a).data("listing-price")-$(b).data("listing-price")});
        $("#listprices").html(divList);
    })
</script>
<script>
    function showdetails(id)
    {
        $('.dh-toggle-show-hide-'+id).slideToggle();
    }
    var buynow_selected = "";
    var info_box = "";
    jQuery(".buynow-btn").click(function () {
        if (buynow_selected != "") {
            jQuery(".buynow-btn-" + buynow_selected).slideToggle();
        }

        if (jQuery(this).data('value') == buynow_selected) {
            buynow_selected = "";
            return false;
        }

        if (info_box != "") {
            jQuery(".dh-toggle-show-hide-" + info_box).slideToggle();
            info_box = "";
        }

        var id = jQuery(this).data('value');
        buynow_selected = id;
        jQuery(".buynow-btn-" + id).slideToggle();
    });
    $(document).ready(function () {
        var uniqueClasses = {};
        $('#listprices .pricearray').each(function () {
            var currentClass = $(this).attr('class');
            if (!uniqueClasses.hasOwnProperty(currentClass)) {
                uniqueClasses[currentClass] = true;
            } else {
                $(this).hide();
            }
        });
    });
    @include('frontend.travelinsurance.includes.sendquoteemailscript')
</script>