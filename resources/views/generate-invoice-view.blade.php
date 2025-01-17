<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $invoice->seller_name }} | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/AdminLTE.min.css">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ config('app.app_public_path') }}/js/qrcode.js"></script>
    <style>
        body {
            font-family: sans-serif;
        }
        .invoice {
            width: 793px !important;
            margin: 0 auto;
            font-size: 14px;
            height: auto;
            min-height: 99vh;
            padding-bottom: 485px !important;
        }

        .header {
            min-height: 110px;
            background-color: #414143;
            color: #ccc;
            padding-top: 30px;
            /* background-image: linear-gradient(to right, #f12711, #f44d03, #f56800, #f67f00, #f69400, #e9881b, #da7d28, #cb7330, #9f4f34, #6c322e, #381c20, #000000); */
        }

        .header strong {
            color: #fff;
        }

        .mid_header {
            min-height: 137px;
            padding-top: 30px;
        }

        .invoice_word {
            letter-spacing: 6px;
            font-size: 48px;
            font-weight: bold;
            padding-left: 50px;
        }

        .customer_name {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 16px;
            letter-spacing: 2px;
        }

        .color_theme {
            color: #ca8236;
        }

        .invoice_number {
            color: #888;
            letter-spacing: 2px;
            font-size: 16px;
            padding-left: 50px;
        }

        .invoice_to {
            font-size: 12px;
            font-weight: bold;
        }

        .base_color {
            color: #666;
        }

        .item_list_header {
            background-color: #414143;
            min-height: 30px;
            margin-left: -15px;
            margin-right: -15px;
            font-size: 16px;
            color: #fff;
            /* background-image: linear-gradient(to right, #f12711, #f44d03, #f56800, #f67f00, #f69400, #e9881b, #da7d28, #cb7330, #9f4f34, #6c322e, #381c20, #000000); */
        }

        .item_table td {
            color: #666;
            font-size: 13px;
        }

        .item_table td.dark {
            color: #333;
        }

        .total_heading {
            font-size: 15px;
            color:#666;
            font-weight: bold;
        }

        .total_value {
            font-size: 14px;
            color:#333;
            letter-spacing: 2px;
            font-weight: bold;
            font-family: sans-serif;
        }

        .grand_total_heading {
            font-size: 18px;
            font-weight: bold;
        }

        .grand_total_value {
            font-size: 18px;
            letter-spacing: 2px;
            font-weight: bold;
            font-family: sans-serif;
        }

        .invoice-col {
            margin-left: 15px;
            font-size: 12px;
        }

        .totals-col hr {
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .text_amount_row {
            margin-top: 10px;
        }

        .text_amount_row span, .text_amount_row div{
            letter-spacing: 0px;
            font-size: 12px;
        }

        .border_black {
            /* border: 1px solid #eee; */
        }

        .seller_info div {
            font-size: 12px;
        }

        .seller_info span {
            font-family: sans-serif;
            letter-spacing: 1px;
            font-size: 12px;
        }

        .t_c div {
            font-size: 12px;
        }

        .company_info {
            text-align: center;
            font-size: 12px;

        }

        .bottom {
            width: 751px;
            padding: 10px;
            bottom: 0;
            position: absolute;
        }

        .signature {
            margin-top:60px;
            float: right;
        }

        .grand_total_row {
            background-color: #414143;
            color:#fff;
            padding-top:10px;
            padding-bottom:10px;
        }

        .signature_wrapper {
            margin-top: 10px;
        }

        .seller_name {
            font-size: 15px !important;
            margin-top:10px;
        }

        .print-btns {
            position: absolute;
            top: 0;
            left: 0;
            margin-top: 10px;
            margin-left: 10px;
        }

        .invoice-type{
            position: absolute;
            right: 24px;
            top: 30px;
            color: #464646;
            font-weight: bold;
        }

        .signature_border{
            border: 1px solid #000 !important;
            display: flow-root;
            padding: 0px 10px;
        }

        html, body {
            height: 100%;
        }
        .page-wrap {
            min-height: 100%;
            /* equal to footer height */
            margin-bottom: -495px;
        }
        .page-wrap:after {
            content: "";
            display: block;
        }
        .site-footer, .page-wrap:after {
            height: 495px;
            margin-top: 25px;
        }
    </style>
    @if (!empty($invoice->deleted_at))
        <style>
            section.invoice::before {
                content: "Cancelled Invoice";
                font-size: 90px;
                position: absolute;
                color: #cccccc7a;
                transform: rotateZ(45deg);
                z-index: 99;
                top: 300px;
            }
        </style>
    @endif
    <link rel="stylesheet" media="print" href="{{ config('app.app_public_path') }}/css/invoice-print.css">
</head>


<body>
    <div class="wrapper">

        <!-- Main content -->
        <section class="invoice">
        <div class="page-wrap">
                <div class="row mid_header">
                    @if (empty($invoice->deleted_at))
                        <span class="invoice-type">Original</span>
                    @else
                        <span class="invoice-type">Cancelled Invoice</span>
                    @endif
                    <div class="col-md-5 col-xs-5">
                            <div class="invoice-col">
                                <span class="invoice_to">Invoice To</span>
                                <address class="base_color">
                                    <div class="customer_name color_theme">{{ $invoice->customer_name }}</div>
                                    <div><strong>Mobile </strong> {{ $invoice->customer_mobile }}</div>
                                    <div><strong>Email </strong> {{ $invoice->customer_email }}</div>
                                    <div style="text-transform:capitalize;"><strong>Address </strong> {{ $invoice->customer_address }}</div>
                                    <div style="text-transform:uppercase;"><strong>GST </strong> {{ $invoice->buyer_gstin }}</div>
                                </address>
                            </div>
                    </div>
                    <div class="col-md-7 col-xs-7">
                        <div class="invoice_word color_theme">
                            TAX INVOICE
                        </div>
                        <div class="invoice_number">
                            <div>
                                Date: {{ date('d-M-Y', strtotime($invoice->created_at)) }}
                            </div>
                            <div>
                                Invoice No: {{ $invoice->invoice_number }}
                            </div>
                        </div>
                    </div>
                </div>



                <!-- <div class="item_list_section">
                    <div class="item_list_header"></div>
                </div> -->

                <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-bordered item_table">
                        <thead class="item_list_header">
                            <tr>
                                <th style="width:25%">Product/Service</th>
                                <th>HSN/SAC</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceDetails as $item)
                            <tr>
                                <td class="dark">{{ $item->item_name }}</td>
                                <td class="dark">{{ ($item->type=="treatment") ?config('app_config.TREATMENT_SAC_NUMBER'):$item->hsn_number }}</td>
                                <td><span class='WebRupee'>Rs. </span>{{ $item->item_cost_without_tax }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->discount }} %</td>
                                <td>{{ $item->tax_percent }} %</td>
                                <td class="dark"><span class='WebRupee'>Rs. </span>{{ round($item->sub_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
            <div class="bottom site-footer">
                <div>
                    <span style="font-weight:bold;">Total In Word:</span>
                    <span id="amount_in_words"></span>
                </div>
                <hr style="margin-bottom:10px;border-color: #000;margin-top:10px;">
                <div class="row ">
                    <!-- accepted payments column -->
                    <div class="col-xs-5">
                        <!-- <hr style="margin-top:10px;margin-bottom:10px;"> -->
                            <div>Seller's GSTIN: <span>{{ $invoice->seller_gstin }} </span> </div>
                            <div>Seller's PAN: <span>{{ $invoice->seller_pan }} </span> </div>
                            <div>Seller's CIN: <span>{{ $invoice->seller_cin }} </span> </div>
                        </div>
                    <div class="col-xs-2">
                        <div style="margin-top: 0px;" id="qrcode"></div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-5 totals-col">
                        <div class="row">
                            <div class="col-xs-5 total_heading">Sub Total:</div>
                            <div class="col-xs-7 total_value"><span class='WebRupee'>Rs. </span> {{ $invoice->total_without_tax }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-5 total_heading">Discount:</div>
                            <div class="col-xs-7 total_value"><span class='WebRupee'>Rs. </span> {{ $invoice->total_discount }}</div>
                        </div>
                        <hr>
                        @if ($invoice->customer_state == $invoice->seller_state)
                        <div class="row">
                            <div class="col-xs-5 total_heading">SGST:</div>
                            <div class="col-xs-7 total_value"><span class='WebRupee'>Rs. </span> {{ round($invoice->total_tax/2, 2) }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-5 total_heading">CGST:</div>
                            <div class="col-xs-7 total_value"><span class='WebRupee'>Rs. </span> {{ round($invoice->total_tax/2, 2) }}</div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-xs-5 total_heading">IGST:</div>
                            <div class="col-xs-7 total_value"><span class='WebRupee'>Rs. </span> {{ $invoice->total_tax }}</div>
                        </div>
                        @endif
                        <hr>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-5"></div>
                    <div class="col-xs-7">
                        <div>
                            <div class="col-xs-5 grand_total_heading grand_total_row">Grand Total:</div>
                            <div class="col-xs-7 grand_total_value grand_total_row"><span class='WebRupee'>Rs. </span> {{ $invoice->total }}</div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <hr style="margin-bottom:10px;margin-top:10px;">
                <div class="row text_amount_row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12 border_black t_c">
                                <h5 style="font-weight:bold;">Terms & Conditions:-</h5>
                                @foreach ( config('app_config.SELLER_TERMS_AND_CONDITIONS') as $term )
                                    <div>- {{ $term }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 border_black seller_info">
                        <div class="row">
                            <div class="col-xs-12">
                                <h5 style="margin-top:0;font-weight:bold;">Bank Details:-</h5>
                                <div><span style="font-weight:bold;">Paytm:</span> <span> 9311155553 </span> </div>
                                <div><span style="font-weight:bold;">Bank:</span> <span>{{ $invoice->seller_bank }} </span> </div>
                                <div><span style="font-weight:bold;">Branch:</span> <span>{{ $invoice->seller_branch }} </span> </div>
                                <div><span style="font-weight:bold;">IFS Code:</span> <span>{{ $invoice->seller_ifsc }} </span> </div>
                                <div><span style="font-weight:bold;">Account:</span> <span>{{ $invoice->seller_account_number }} </span> </div>
                            </div>
                        </div>
                        <div class="row signature_wrapper">
                            <div class="col-xs-12">
                                <div class="signature_border">
                                    <div class="seller_name">{{ $invoice->seller_name }}</div>
                                    <div class="signature">Authorised Signatory</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="margin-bottom:10px;margin-top:10px;">
                <div class="company_info">
                    Registered Address: 3556, Aggarwal Building Morigate Delhi - 110006
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    @if (empty($invoice->deleted_at))
    <div class="print-btns">
        <button class="btn btn-info" data-type="Original" id="original">Print Original</button>
        <button class="btn btn-info" data-type="Duplicate" id="duplicate">Print Duplicate</button>
        <button class="btn btn-info" data-type="Triplicate" id="triplicate">Print Triplicate</button>
    </div>
    @endif
    <!-- ./wrapper -->
</body>
<script>
    var qrcode = new QRCode("qrcode", {
        text: "{{ $invoice->customer_name }}: {{ $invoice->seller_name }} | Total Amount Due: Rs. {{ $invoice->total }}",
        width: 96,
        height: 96,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

    function Rs(amount) {
        var words = new Array();
        words[0] = 'Zero'; words[1] = 'One'; words[2] = 'Two'; words[3] = 'Three'; words[4] = 'Four'; words[5] = 'Five'; words[6] = 'Six'; words[7] = 'Seven';
        words[8] = 'Eight'; words[9] = 'Nine'; words[10] = 'Ten'; words[11] = 'Eleven'; words[12] = 'Twelve'; words[13] = 'Thirteen'; words[14] = 'Fourteen';
        words[15] = 'Fifteen'; words[16] = 'Sixteen'; words[17] = 'Seventeen'; words[18] = 'Eighteen'; words[19] = 'Nineteen'; words[20] = 'Twenty';
        words[30] = 'Thirty'; words[40] = 'Forty'; words[50] = 'Fifty'; words[60] = 'Sixty'; words[70] = 'Seventy'; words[80] = 'Eighty'; words[90] = 'Ninety'; var op;
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++ , j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++ , j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split(" ").join(" ");
        }
        return words_string;
    }
    function RsPaise(n) {
        nums = n.toString().split('.')
        var whole = Rs(nums[0])
        if (nums[1] == null) nums[1] = 0;
        if (nums[1].length == 1) nums[1] = nums[1] + '0';
        if (nums[1].length > 2) { nums[1] = nums[1].substring(2, length - 1) }
        if (nums.length == 2) {
            if (nums[0] <= 9) { nums[0] = nums[0] * 10 } else { nums[0] = nums[0] };
            var fraction = Rs(nums[1])
            if (whole == '' && fraction == '') { op = 'Zero only'; }
            if (whole == '' && fraction != '') { op = fraction + ' paise only'; }
            if (whole != '' && fraction == '') { op = 'Rupees ' + whole + ' only'; }
            if (whole != '' && fraction != '') { op = 'Rupees ' + whole + 'and ' + fraction + ' paise only'; }
            amt = n;
            if (amt > 999999999.99) { op = 'Oops!!! The amount is too big to convert'; }
            if (isNaN(amt) == true) { op = 'Error : Amount in number appears to be incorrect. Please Check.'; }
            console.log(op);

            return op;
        }
    }

    $(function(){
        $('#amount_in_words').html(RsPaise( Math.round( {{ $invoice->total }} * 100) / 100  ));

        $('.print-btns button').on('click', function(event) {
            $('.invoice-type').html($(this).data('type'));
            window.print();
        });
    });
</script>

</html>
