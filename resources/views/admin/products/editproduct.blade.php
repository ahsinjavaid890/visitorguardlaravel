@extends('admin.layouts.main-layout')
@section('title', 'Edit Product')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container-fluid ">
                @include('alerts.index')
                <form method="post" action="{{ url('admin/products/updateproducts') }}" id="productform"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->pro_id }}" name="id">
                    <div id="content" class="padding-20">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-custom">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Product Details
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6" style="padding:0;">
                                                <div class="col-md-12"> <label><strong>Supervisa Product ?</strong>
                                                        <small>(Is this super visa product ?)</small></label> </div>
                                                <div class="col-md-12">
                                                    <label class="switch switch-green switch-success switch-round">
                                                        <input type="checkbox" class="switch-input" name="pro_supervisa"
                                                            id="pro_supervisa" value="1"
                                                            @if ($data->pro_supervisa == 1) checked="" @endif>
                                                        <span class="switch-label" data-on="YES" data-off="NO"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"> <label><strong>Life Insurance Product ?</strong>
                                                        <small>(Is this life insurance product ?)</small></label> </div>
                                                <div class="col-md-12">
                                                    <label class="switch switch-green switch-success switch-round">
                                                        <input type="checkbox" class="switch-input" name="pro_life"
                                                            id="pro_life" value="1"
                                                            @if ($data->pro_life == 1) checked="" @endif>
                                                        <span class="switch-label" data-on="Yes" data-off="NO"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Product Category</label>
                                                    <select name="category_id" class="form-control">
                                                        <option>Select Category</option>
                                                        @foreach (DB::table('product_categories')->get() as $r)
                                                            <option @if ($data->category_id == $r->id) selected @endif
                                                                value="{{ $r->id }}">{!! $r->name !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Parent Product</label>
                                                    <select class="form-control" name="pro_parent" id="pro_parent">
                                                        <option value="">--- None ---</option>
                                                        @foreach (DB::table('wp_dh_products')->get() as $r)
                                                            <option @if ($data->pro_parent == $r->pro_id) selected @endif
                                                                value="{{ $r->pro_id }}">{{ $r->pro_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input class="form-control" type="text" id="pro_name" name="pro_name"
                                                placeholder="Enter product name" value="{{ $data->pro_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Description</label>
                                            <textarea class="form-control" rows="6" name="description">{{ $data->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Vector</label>
                                            <input class="form-control" name="vector" type="file">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Buynow URL</label>
                                            <input class="form-control" type="text" id="pro_url" name="pro_url"
                                                placeholder="https://" value="{{ $data->pro_url }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Redirect URL <small style="color:red;">Use <b>(product/)</b> For Quote
                                                    Form if want details then only add url</small></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{ url('') }}</span>
                                                </div>
                                                <input class="form-control" type="text" id="redirect_from_url"
                                                    name="redirect_from_url" value="{{ $data->redirect_from_url }}">
                                            </div>
                                        </div>
                                        <link rel="stylesheet" type="text/css"
                                            href="{{ asset('public/admin/assets/css/sortable.css') }}">
                                        @php
                                            $form_layout = $pro_fields['form_layout'];
                                            $price_layout = $pro_fields['price_layout'];
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>
                                                    <strong>Choose Quote Form <span class="text-danger">*</span></strong>
                                                    <small>Select the quote form design you want to use.</small>
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="design-select @if ($form_layout == 'layout_1') selected @endif"
                                                    onclick="formone()" id="form1">
                                                    <img src="{{ asset('public/front/layouts/form-one.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_2') selected @endif"
                                                    onclick="formtwo()" id="form2">
                                                    <img src="{{ asset('public/front/layouts/form-two.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_3') selected @endif"
                                                    onclick="formthree()" id="form3">
                                                    <img src="{{ asset('public/front/layouts/form-three.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_4') selected @endif"
                                                    onclick="formfour()" id="form4">
                                                    <img src="{{ asset('public/front/layouts/form-four.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_5') selected @endif"
                                                    onclick="formfive()" id="form5">
                                                    <img src="{{ asset('public/front/layouts/form-five.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_6') selected @endif"
                                                    onclick="formsix()" id="form6">
                                                    <img src="{{ asset('public/front/layouts/form-six.png') }}">
                                                </div>
                                                <div class="design-select @if ($form_layout == 'layout_7') selected @endif"
                                                    onclick="formseven()" id="form7">
                                                    <img src="{{ asset('public/front/layouts/form-seven.png') }}">
                                                </div>
                                                <input type="hidden" name="prod[form_layout]" id="form_layout"
                                                    value="{{ $form_layout }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>
                                                    <strong>Choose Prices Display <span
                                                            class="text-danger">*</span></strong>
                                                    <small>Select the design you want to use to show prices.</small>
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="design-select @if ($price_layout == 'layout_1') selected @endif"
                                                    onclick="pricesone()" id="prices1">
                                                    <img src="{{ asset('public/front/layouts/prices-one.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_2') selected @endif"
                                                    onclick="pricestwo()" id="prices2">
                                                    <img src="{{ asset('public/front/layouts/prices-two.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_3') selected @endif"
                                                    onclick="pricesthree()" id="prices3">
                                                    <img src="{{ asset('public/front/layouts/prices-three.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_4') selected @endif"
                                                    onclick="pricesfour()" id="prices4">
                                                    <img src="{{ asset('public/front/layouts/prices-four.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_5') selected @endif"
                                                    onclick="pricesfive()" id="prices5">
                                                    <img src="{{ asset('public/front/layouts/prices-five.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_6') selected @endif"
                                                    onclick="pricessix()" id="prices6">
                                                    <img src="{{ asset('public/front/layouts/prices-six.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_7') selected @endif"
                                                    onclick="pricesseven()" id="prices7">
                                                    <img src="{{ asset('public/front/layouts/prices-seven.png') }}">
                                                </div>
                                                <div class="design-select @if ($price_layout == 'layout_8') selected @endif"
                                                    onclick="priceseight()" id="prices8">
                                                    <img src="{{ asset('public/front/layouts/prices-eight.png') }}">
                                                </div>
                                                <input type="hidden" name="prod[price_layout]" id="price_layout"
                                                    value="{{ $price_layout }}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-6" style="padding:0;">
                                                <div class="col-md-12"> <label><strong>Active Quotation Form on Stylish
                                                            Page</strong></label> </div>
                                                <div class="col-md-12">
                                                    <label class="switch switch-green switch-success switch-round">
                                                        <input onchange="selectstylishform(this.value)" type="checkbox"
                                                            class="switch-input" name="quotation_form_on_stylish_page"
                                                            id="quotation_form_on_stylish_page" value="1"
                                                            @if ($data->quotation_form_on_stylish_page == 1) checked="" @endif>
                                                        <span class="switch-label" data-on="YES" data-off="NO"></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div id="stylishformlayoutrow"
                                            @if ($data->quotation_form_on_stylish_page == 1) @else style="display:none"; @endif
                                            class="row">
                                            <div class="col-md-12">
                                                <label>
                                                    <strong>Choose Form Layout <span class="text-danger">*</span></strong>
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_1') selected @endif"
                                                    onclick="stylishformlayout('layout_1')"
                                                    id="stylishformlayoutonelayout_1">
                                                    <img src="{{ asset('public/front/layouts/form-one.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_2') selected @endif"
                                                    onclick="stylishformlayout('layout_2')"
                                                    id="stylishformlayoutonelayout_2">
                                                    <img src="{{ asset('public/front/layouts/form-two.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_3') selected @endif"
                                                    onclick="stylishformlayout('layout_3')"
                                                    id="stylishformlayoutonelayout_3">
                                                    <img src="{{ asset('public/front/layouts/form-three.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_4') selected @endif"
                                                    onclick="stylishformlayout('layout_4')"
                                                    id="stylishformlayoutonelayout_4">
                                                    <img src="{{ asset('public/front/layouts/form-four.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_5') selected @endif"
                                                    onclick="stylishformlayout('layout_5')"
                                                    id="stylishformlayoutonelayout_5">
                                                    <img src="{{ asset('public/front/layouts/form-five.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_6') selected @endif"
                                                    onclick="stylishformlayout('layout_6')"
                                                    id="stylishformlayoutonelayout_6">
                                                    <img src="{{ asset('public/front/layouts/form-six.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_7') selected @endif"
                                                    onclick="stylishformlayout('layout_7')"
                                                    id="stylishformlayoutonelayout_7">
                                                    <img src="{{ asset('public/front/layouts/form-seven.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_8') selected @endif"
                                                    onclick="stylishformlayout('layout_8')"
                                                    id="stylishformlayoutonelayout_8">
                                                    <img src="{{ asset('public/front/layouts/form-eight.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclass @if ($data->stylish_form_layout == 'layout_9') selected @endif"
                                                    onclick="stylishformlayout('layout_9')"
                                                    id="stylishformlayoutonelayout_9">
                                                    <img src="{{ asset('public/front/layouts/form-nine.png') }}">
                                                </div>
                                                <input type="hidden" name="stylish_form_layout" id="stylish_form_layout"
                                                    value="{{ $data->stylish_form_layout }}">
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <label>
                                                    <strong>Choose Price Layout <span class="text-danger">*</span></strong>
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_1') selected @endif"
                                                    onclick="stylishpricelayout('layout_1')"
                                                    id="stylishpricelayoutonelayout_1">
                                                    <img src="{{ asset('public/front/layouts/form-one.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_2') selected @endif"
                                                    onclick="stylishpricelayout('layout_2')"
                                                    id="stylishpricelayoutonelayout_2">
                                                    <img src="{{ asset('public/front/layouts/form-two.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_3') selected @endif"
                                                    onclick="stylishpricelayout('layout_3')"
                                                    id="stylishpricelayoutonelayout_3">
                                                    <img src="{{ asset('public/front/layouts/form-three.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_4') selected @endif"
                                                    onclick="stylishpricelayout('layout_4')"
                                                    id="stylishpricelayoutonelayout_4">
                                                    <img src="{{ asset('public/front/layouts/form-four.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_5') selected @endif"
                                                    onclick="stylishpricelayout('layout_5')"
                                                    id="stylishpricelayoutonelayout_5">
                                                    <img src="{{ asset('public/front/layouts/form-five.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_6') selected @endif"
                                                    onclick="stylishpricelayout('layout_6')"
                                                    id="stylishpricelayoutonelayout_6">
                                                    <img src="{{ asset('public/front/layouts/form-six.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_7') selected @endif"
                                                    onclick="stylishpricelayout('layout_7')"
                                                    id="stylishpricelayoutonelayout_7">
                                                    <img src="{{ asset('public/front/layouts/form-seven.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_8') selected @endif"
                                                    onclick="stylishpricelayout('layout_8')"
                                                    id="stylishpricelayoutonelayout_8">
                                                    <img src="{{ asset('public/front/layouts/form-eight.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_9') selected @endif"
                                                    onclick="stylishpricelayout('layout_9')"
                                                    id="stylishpricelayoutonelayout_9">
                                                    <img src="{{ asset('public/front/layouts/form-nine.png') }}">
                                                </div>
                                                <div class="mt-3 design-select stylishlayoutclassprice @if ($data->stylish_price_layout == 'layout_10') selected @endif"
                                                    onclick="stylishpricelayout('layout_10')"
                                                    id="stylishpricelayoutonelayout_10">
                                                    <img src="{{ asset('public/front/layouts/form-ten.png') }}">
                                                </div>
                                                <input type="hidden" name="stylish_price_layout"
                                                    id="stylish_price_layout" value="{{ $data->stylish_price_layout }}">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function selectstylishform(id) {
                                            $('#stylishformlayoutrow').toggle('slow');

                                        }

                                        function stylishformlayout(id) {
                                            $('.stylishlayoutclass').removeClass('selected');
                                            $('#stylish_form_layout').val(id);
                                            $('#stylishformlayoutone' + id).addClass('selected');
                                        }

                                        function stylishpricelayout(id) {
                                            $('.stylishlayoutclassprice').removeClass('selected');
                                            $('#stylish_price_layout').val(id);
                                            $('#stylishpricelayoutone' + id).addClass('selected');
                                        }
                                    </script>
                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-success" value="Submit Changes">
                                        <a href="{{url('admin/products/allproducts')}}" class="btn btn-success">Back</a>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-custom">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                Product Fields & Ordering
                                                <div class="text-muted pt-2 font-size-sm">Drag and drop to set ordering
                                                </div>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="sortables"
                                                    class="sortlist row no-gutters d-block connectedSortable sortingfields ui-sortable">
                                                    <?php  for($i=1;$i<=17;$i++){ ?>
                                                    <?php if(array_search("id_1",$pro_sort) == $i){?>
                                                    <li class="ui-state-default ui-sortable-handle"
                                                        id="{{ $i }}">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_1" type="hidden">
                                                            <input <?php if(array_key_exists('fname', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[fname]" id="fname" type="checkbox"> First
                                                            Name
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_2",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_2">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_2" type="hidden">
                                                            <input <?php if(array_key_exists('lname', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[lname]" id="lname" type="checkbox"> Last
                                                            Name
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_5",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_5">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_5" type="hidden">
                                                            <input <?php if(array_key_exists('Smoke12', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[Smoke12]" id="Smoke12" type="checkbox">
                                                            Smoke in last 12 month (yes/no)
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_17",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_17">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="sum_insured_sort" value="id_17"
                                                                type="hidden"><input <?php if(array_key_exists('sum_insured', $pro_fields)){?> checked=""
                                                                <?php } ?> name="prod[sum_insured]"
                                                                id="sum_insured" type="checkbox"> Sum Insured Amount
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_6",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_6">
                                                        <label class="checkbox" style="display: inline-block;">
                                                            <input name="sort[]" value="id_6" type="hidden">
                                                            <input <?php if(array_key_exists('Country', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[Country]" id="Country"
                                                                type="checkbox"><i></i> Destination Country</label><br>
                                                        <label>
                                                            <input <?php if($data->pro_travel_destination == 'worldwide'){?> checked="" <?php } ?>
                                                                type="radio" name="destinationtype" value="worldwide">
                                                            Worldwide
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="destinationtype" value="canada"
                                                                <?php if($data->pro_travel_destination == 'canada'){?> checked=""
                                                                <?php } ?>>Canada Only
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_8",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_8">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="sdate_sort" value="id_8"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('sdate', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[sdate]" id="sdate" type="checkbox"> Start
                                                            Date</label>
                                                    </li>
                                                    <?php } if(array_search("id_9",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_9">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="edate_sort" value="id_9"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('edate', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[edate]" id="edate" type="checkbox">
                                                            End Date
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_10",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_10">
                                                        <label class="checkbox" style="display: inline-block;">
                                                            <input name="sort[]" id="traveller_sort" value="id_10"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('traveller', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[traveller]" id="traveller" type="checkbox">
                                                            Number of Traveller's
                                                        </label>
                                                        <input type="number" name="prod[traveller_number]"
                                                            value="5" min="1" max="8" step="1">
                                                    </li>
                                                    <?php } if(array_search("id_3",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_3">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_3" type="hidden">
                                                            <input <?php if(array_key_exists('dob', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[dob]" id="dob" type="checkbox"> Date of
                                                            Birth
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_16",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_16">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="pre_existing_sort" value="id_16"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('pre_existing', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[pre_existing]" id="pre_existing"
                                                                type="checkbox"> Pre-existing Condition
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_15",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_15">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="fplan_sort" value="id_15"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('fplan', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[fplan]" id="fplan" type="checkbox">
                                                            <i></i> Family Plan
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_4",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_4">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_4" type="hidden">
                                                            <input <?php if(array_key_exists('email', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[email]" id="email" type="checkbox"> Email
                                                            Address
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_7",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_7">
                                                        <label class="checkbox">
                                                            <input name="sort[]" value="id_7" type="hidden">
                                                            <input <?php if(array_key_exists('phone', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[phone]" id="phone" type="checkbox">
                                                            Phone Number
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_11",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_11"
                                                        style="">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="smoked_sort" value="id_11"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('smoked', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[smoked]" id="smoked" type="checkbox">
                                                            <i></i> Traveller Smoked
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_12",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_12">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="traveller_gender_sort"
                                                                value="id_12" type="hidden">
                                                            <input <?php if(array_key_exists('traveller_gender', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[traveller_gender]" id="traveller_gender"
                                                                type="checkbox"> <i></i> Oldest Traveller's Gender
                                                        </label>
                                                    </li>
                                                    <?php } if(array_search("id_13",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_13">
                                                        <label class="checkbox" style="display: inline-block;">
                                                            <input name="sort[]" id="us_stop_sort" value="id_13"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('us_stop', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[us_stop]" id="us_stop" type="checkbox">
                                                            <i></i> Stopover in US (Days)
                                                        </label>
                                                        <input type="number" name="prod[us_stop_days]" min="0"
                                                            max="30" step="1" value="0"
                                                            style="display:none3;">
                                                    </li>
                                                    <?php } if(array_search("id_14",$pro_sort) == $i){ ?>
                                                    <li class="ui-state-default ui-sortable-handle" id="id_14">
                                                        <label class="checkbox">
                                                            <input name="sort[]" id="gender_sort" value="id_14"
                                                                type="hidden">
                                                            <input <?php if(array_key_exists('gender', $pro_fields)){?> checked="" <?php } ?>
                                                                name="prod[gender]" id="gender" type="checkbox">
                                                            Gender
                                                        </label>
                                                    </li>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
                            <style>
                                #sortable {
                                    list-style-type: none;
                                    margin: 0;
                                    padding: 0;
                                    width: 60%;
                                }

                                #sortable li {
                                    margin: 0 3px 3px 3px;
                                    padding: 0.4em;
                                    padding-left: 1.5em;
                                    font-size: 1.4em;
                                    height: 18px;
                                }

                                #sortable li span {
                                    position: absolute;
                                    margin-left: -1.3em;
                                }
                            </style>
                            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
                        </div>
                        <input type="hidden" name="update_id" value="23">
                        <input name="savesortlist" id="savesortlist" type="hidden" value="">
                    </div>

                </form> <!-- /PANEL -->
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/sortable.js') }}"></script>
@endsection
