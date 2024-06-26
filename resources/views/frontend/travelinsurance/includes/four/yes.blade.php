<div class="col-md-9 mt-3" style="padding:0;" id="listprices">

                <?php
        $addinquery = '';
        $lessquery = '';
        if($request->pre_existing == 'yes' || $request->pre_existing == '1'){
            $addinquery .= "AND `premedical`='1'";
        }
        if($family_plan == 'yes'){
            $addinquery .= "AND `family_plan`='1'";
        }
        if($num_of_days < '365'){
            $lessquery = " AND `rate_base`<>'2'";
        }
        $plans_q = DB::select("SELECT * FROM wp_dh_insurance_plans WHERE `product`='$data->pro_id' AND `status`='1' $lessquery $addinquery ORDER BY `id`");

        foreach($plans_q as $plan){

        $plan_id = $plan->id;
        $plan_name = $plan->plan_name;
        $pre_existing_name = $plan->pre_existing_name;
        $without_pre_existing_name = $plan->without_pre_existing_name;
        $insurance_company = $plan->insurance_company;
        $premedical = $plan->premedical;
        $rate_base = $plan->rate_base;  //0=Daily 1=Monthly 2=Yearly 3=Multi
        $monthly_two = $plan->monthly_two;
        $flatrate = $plan->flatrate;
        $flatrate_type = $plan->flatrate_type;
        $sales_tax = $plan->sales_tax;
        $smoke_rate = $plan->smoke_rate;
        $smoke = $plan->smoke;
        $directlink = $plan->directlink;
        $status = $plan->status;
        $cdiscountrate = $plan->cdiscountrate;
        $plan_discount = $plan->discount;
        $plan_discount_rate = $plan->discount_rate;

        $post_dest = str_replace(' ', '', strtolower($request->primary_destination));
        if($sales_tax != 0)
        {
            $salestaxeplode = explode('%', $sales_tax);
            $salestax_rate = $salestaxeplode[0];
            $salestax_dest = str_replace(' ', '', $salestaxeplode[1]);
        }
        


        //COMPANY Details
        $company = DB::table('wp_dh_companies')->where('comp_id' , $insurance_company)->first();
        $comp_id = $company->comp_id;
        $comp_name = $company->comp_name;
        $comp_logo = $company->comp_logo;


        $deductsloop = DB::select("SELECT `deductible1` FROM wp_dh_insurance_plans_deductibles WHERE `plan_id` IN (SELECT `id` FROM wp_dh_insurance_plans WHERE `product`='$data->pro_id') GROUP BY `deductible1` ORDER BY `deductible1`");
        foreach($deductsloop as $deductsloop_f){
            if($deductsloop_f)
            {
                $deductible = $deductsloop_f->deductible1;
            }
            
            $deduct = '';
            $deduct_rate = '';
            $deduct_plan_id = '';
            $deductsq = DB::table('wp_dh_insurance_plans_deductibles')->where('plan_id' , $plan_id)->where('deductible1' , $deductible)->first();

            if($deductsq)
            {
                $deduct = $deductsq->deductible1;
                  $deduct_rate = str_replace('-', '', $deductsq->deductible2);
            $deduct_plan_id = $deductsq->plan_id;
            }
            
          
            if($supervisa == 'yes'){
                $addinbenefit = "AND CAST(`sum_insured` AS DECIMAL)>='100000'";
            }else{
                $addinbenefit = "";
            }
            $sum_insured= '';        
            $sumin = DB::select("SELECT `sum_insured` FROM `wp_dh_insurance_plans_rates` WHERE `plan_id`='$deduct_plan_id' $addinbenefit GROUP BY `sum_insured` ORDER BY CAST(`sum_insured` AS DECIMAL)");

        foreach($sumin as $suminsu){
        $sum_insured = $suminsu->sum_insured;
        $sumamt = '';

        $sumqry = DB::table('wp_dh_insurance_plans_rates')->where('plan_id' , $plan_id)->where('sum_insured' , $sum_insured)->first();
        $sumamt = $sumqry->sum_insured;


        //getting prices for each ages

            if($rate_base == '3'){
                $rates_table_name = "wp_dh_plan_day_rate";
                $addquery = "AND '$num_of_days' BETWEEN `min_range` AND `max_range`";
            } else {
                $rates_table_name = "wp_dh_insurance_plans_rates";
                $addquery = "";
            }

            $total_price = 0;
            $daily_rate = 0;
            //$single_person_rate = 0;
            //$single_person_rate = array();
            $display = array();
            if($family_plan == 'yes'){
                $plan_rates = DB::select("SELECT * FROM $rates_table_name WHERE `plan_id`='$deduct_plan_id' AND '$elder_age' BETWEEN `minage` AND `maxage` AND `sum_insured`='$sumamt' $addquery");
                $countarray =  count($plan_rates);
                if($countarray > 0)
                {
                    $maxs = array_keys($ages_array, max($ages_array));
                    $preexistingcondition =  $request->pre_existing[$maxs[0]];
                    if($preexistingcondition == 'yes')
                    {
                        $daily_rate = $plan_rates[0]->rate_with_pre_existing  * 2;
                    }else{
                        $daily_rate = $plan_rates[0]->rate_without_pre_existing * 2;
                    }                
                    if(!$daily_rate){ $display = '0'; }
                }
                else{
                    $daily_rate = 500;
                    if(!$daily_rate){ $display = '0'; }
                }
            } else {
                $perone = 0;
                foreach($ages_array as $person_age){
                    $perone++;
                   $plan_rates = DB::select("SELECT * FROM $rates_table_name WHERE `plan_id`='$deduct_plan_id' AND '$person_age' BETWEEN `minage` AND `maxage` AND `sum_insured`='$sumamt' $addquery");
                   
                   $countarray =  count($plan_rates);
                   if($countarray > 0)
                   {

                        if($request->pre_existing[$perone-1]=='yes')
                        {
                            $dailyrate = $plan_rates[0]->rate_with_pre_existing;
                            $daily_rate += $dailyrate;
                            if($dailyrate == ''){ $dailyrate = 0; }
                            $display[] =  $dailyrate;
                            $dailyrate = 0;
                        }else{
                            $dailyrate = $plan_rates[0]->rate_without_pre_existing;
                            $daily_rate += $dailyrate;
                            if($dailyrate == ''){ $dailyrate = 0; }
                            $display[] =  $dailyrate;
                            $dailyrate = 0;
                        }

 
                   }
                    
                }
            }


//NUM OF MONTHS
$num_months = $num_of_days / 30;
$num_months = ceil($num_months);
if ($num_months > 12) {
    $num_months = 12;
}
if ($rate_base == '0') {
    // if daily rate
    $total_price = $daily_rate * $num_of_days;
} else if ($rate_base == '1') {
    // if monthly rate
    $total_price = $daily_rate * $num_months;
    $monthly_price = $total_price / $num_months;
} else if ($rate_base == '2') {
    // if yearly rate
    $total_price = $daily_rate;
} else if ($rate_base == '3') {
    // if multi days rate
    $total_price = $daily_rate;
}
// Total days price
$totaldaysprice = $total_price;
// Sales Tax
$post_dest = str_replace(' ', '', strtolower($request->primary_destination));
if ($sales_tax != 0) {
    if ($salestax_dest == $post_dest) {
        $salestaxes = ($salestax_rate * $totaldaysprice) / 100;
    } else {
        $salestaxes = 0;
    }
} else {
    $salestaxes = 0;
}
// Smoke Rate
if ($request->Smoke12 == 'yes' || $request->traveller_Smoke == 'yes') {
    if ($smoke == '0') {
        $smoke_price = ($smoke_rate == 0) ? 0 : $smoke_rate;
    } else if ($smoke == '1') {
        $smoke_price = ($totaldaysprice * $smoke_rate) / 100;
    }
} else {
    $smoke_price = 0;
}
// Others
$others = $salestaxes + $smoke_price;
// Deductible
$deduct_discount = ($total_price * $deduct_rate) / 100;
$cdiscount = ($total_price * $cdiscountrate) / 100;
if (strpos($deductsq->deductible2, '-') !== false) {
    // if deductible is negative
    $discount = $deduct_discount + $cdiscount;
    $adddeductible = 0;
} else {
    // if deductible is positive
    $discount = $cdiscount;
    $adddeductible = $deduct_discount;
}
$total_price = ($total_price - $discount) + ($others + $adddeductible);
// Discount on plan calculation
if ($number_travelers > 1) {
    $discountonplan = 0;
    if ($plan_discount == '1') {
        $discountonplan = ($plan_discount_rate * $total_price) / 100;
    }
    $total_price = $total_price - $discountonplan;
}
if ($flatrate_type == 'each') {
    if($plan->flat_rate_type == 'fix')
    {
       $flat_price = $flatrate * $number_travelers; 
    }else{
        $number = $total_price;
        $percentageValue = $flatrate;
        $flatratepercentage = $number * ($percentageValue / 100);
        $flat_price = $flatratepercentage;
    }
} else if ($flatrate_type == 'total') {
    if($plan->flat_rate_type == 'fix')
    {
       $flat_price = $flatrate;
    }else{
        $number = $total_price;
        $percentageValue = $flatrate;
        $flatratepercentage = $number * ($percentageValue / 100);
        $flat_price = $flatratepercentage;
    }
} else {
    $flat_price = 0;
}
if ($monthly_two == '1') {
    $monthly_price = ($total_price + $flat_price) / $num_months;
}

if (in_array("0", $display)){ $show = '0'; } else {$show = '1'; }


if($show == '1' && $total_price > 0){
?>
@if(Cmf::checkallrates($ages_array , $rates_table_name, $deduct_plan_id , $sumamt) == 1)
<div class="desktop-compare listing-item" data-listing-price="{{ str_replace(',', '', number_format($total_price)) }}">
    <div class="coverage-amt pricearray coverage-amt-{{ $sum_insured }} pricearray{{ $comp_id }}{{ $total_price }}"
        style="display: <?php if($_REQUEST['sum_insured2'] == $sum_insured ){ echo 'block'; } else { echo 'none'; } ?>;">
        <div class="row plan-details align-items-center  deductable-<?php echo $deductible; ?>"
            style=" display: <?php if($deductible == '1000'){ echo 'flex'; } else if($havethousand == 'no' && $deductible == '0'){ echo 'flex'; } else { echo 'none'; } ?>;">
            <div class="col-md-1 col-sm-6 mobile-deisply-none">
                <div class=" center aligned middle aligned column">
                    <div class="compare col-md-12 text-center">
                        <i class="fa fa-exclamation-circle dh-toggle"onclick="showdetails({{ 1+$deductible.$plan_id }})"aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="mobile-deisply-show" style="display: none;width: 100%;">
                <div class="d-flex col-md-12">
                    <div class="asdsadsad">
                        <i class="fa fa-exclamation-circle dh-toggle"onclick="showdetails({{ 1+$deductible.$plan_id }})"aria-hidden="true"></i>
                    </div>
                    <div class="logo"style="margin-left: 20%;">
                        <img style="width: 200px;height: 80px;" class="img-thumbnail" src="https://lifeadvice.ca/public/images/{{ $comp_logo }}" />
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xs-6 logogd mobile-deisply-none" style="border:0px solid #000;  text-align:center; padding: 5px 0; text-align: center ">
                <img style="width: 200px;height: 80px;" class="img-thumbnail" src="https://lifeadvice.ca/public/images/{{ $comp_logo }}" />
            </div>
            <div class="col-md-4 col-xs-6 text-center" id="price">
                <h3 style="display:inline;color: #000;font-weight: bold;    font-size: 30px;">
                    $
                    <?php $explode = explode('.',number_format($total_price,2));
                        ?><span>
                        <?php echo str_replace(',', '',$explode[0]).'.';?><sup class="superior">
                            <?php echo $explode[1];?>
                        </sup>
                    </span>
                </h3>
                <?php if($monthly_two == '1'){?>

                <h2
                    style="margin: 0; font-size: 15px; font-weight: bold; color: #333; font-family: arial; padding: 3px; line-height: normal; margin-bottom: 0px; width: auto;">
                    $
                    <?php echo number_format($monthly_price,2);?>/Month<small
                        style="color: #f5821f;font-weight: bold;margin-left: 1px;">
                        <?php echo $num_months;?>
                    </small>
                </h2>
                <?php } ?>
                <p>
                    $
                    <?php echo $deductible; ?> Deductible <br />
                </p>

            </div>
            <div class="col-md-12 visible-xs">
                <div style="clear:both;"></div>
            </div>
            <div class="col-md-3 col-xs-6 text-center">
                <button onclick="$('.buynow_{{ $deductible.$plan_id }}').slideToggle();" class="submit-btn">
                    <i class="fa fa-shopping-cart text-white"></i> Buy Now
                </button>
                @php
                    $createbuynowarray = array(
                        'plan_id'=>$plan_id,
                        'pro_id'=>$data->pro_id,
                        'sum_insured'=>$sum_insured,
                        'deductible'=>$deductible,
                        'savers_email'=>$request->savers_email,
                        'fname'=>$request->fname,
                        'lname'=>$request->lname,
                        'number_travelers'=>$number_travelers,
                        'deduct_rate'=>$deduct_rate,
                        'date_of_birth'=>$request->date_of_birth,
                        'years'=>$request->years,
                        'preexisting'=>$request->pre_existing,
                        'num_of_days'=>$num_of_days,
                        'comp_name'=>$comp_name,
                        'comp_id'=>$comp_id,
                        'plan_name'=>$plan_name,
                        'startdate'=>$startdate,
                        'enddate'=>$enddate,
                        'total_price'=>$total_price,
                        'product_name'=>$product_name,
                        'primary_destination'=>$request->primary_destination,
                        'ages_array'=>$ages_array[0],
                        'num_of_days'=>$num_of_days
                    );
                    $savetoplan = serialize($createbuynowarray)
                @endphp
                @if(in_array('yes',$request->pre_existing) && in_array('no',$request->pre_existing))

                @else
                <label onclick="savecompareplans('{{ $savetoplan }}')" class="submit-btn mt-1" style="background-color: #12b48b;" id="compare"><i class="fa fa-database text-white"></i> Compare</label>
                @endif
            </div>

            

            @include('frontend.travelinsurance.includes.policydetails')
            @include('frontend.travelinsurance.includes.buynowform')

        </div>


    </div>
</div>
@endif

                <?php
    if ($sum_insured == $request->sum_insured2){
        $mailitem[] = [
            'deductible' => $deductible,
            'sum_insured' => $sum_insured,
            'planproduct' => $product_name,
            'price' => $total_price,
            'quote' => $quoteNumber,
            'logo' => $comp_logo,
            'url' => 'test',
            'buynow' => 'test',
        ];
        $price[] = $total_price;
    }
    $display = ''; }}}} ?>

                
            </div>