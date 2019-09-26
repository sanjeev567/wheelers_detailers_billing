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
        .invoice {
            width: 1164px !important;
            margin: 0 auto;
            font-size: 14px;
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
            padding-bottom: 30px;
        }

        .invoice_word {
            letter-spacing: 20px;
            font-size: 64px;
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
            letter-spacing: 10px;
            margin-top:-15px;
            font-size: 16px;
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
            color: #fff;
            /* background-image: linear-gradient(to right, #f12711, #f44d03, #f56800, #f67f00, #f69400, #e9881b, #da7d28, #cb7330, #9f4f34, #6c322e, #381c20, #000000); */
        }

        .item_table td {
            color: #666;
        }

        .item_table td.dark {
            color: #333;
        }

        .grand_total_heading {
            font-size: 20px;
            color:#666;
        }

        .grand_total_value {
            font-size: 20px;
            color:#333;
            letter-spacing: 2px;
        }

        .invoice-col {
            margin-left: 15px;
        }
    </style>
    <link rel="stylesheet" media="print" href="{{ config('app.app_public_path') }}/css/invoice-print.css">
</head>


<body>
    <div class="wrapper">

        <!-- Main content -->
        <section class="invoice">

                <div class="row header">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-8">
                        <div class="col-xs-4">
                            <strong>Web</strong>
                            <address>
                            {{ $invoice->web_link }}
                            </address>
                        </div>
                        <div class="col-xs-4">
                            <strong>Phone</strong>
                            <address>
                                {{ $invoice->seller_phone1 }}<br>
                                {{ $invoice->seller_phone2 }}
                            </address>
                        </div>
                        <div class="col-xs-4">
                            <strong>Address</strong>
                            <address>
                                {{ $invoice->seller_address_line1 }}<br>
                                {{ $invoice->seller_address_line2 }}<br>
                                {{ $invoice->seller_address_line3 }}
                            </address>
                        </div>
                    </div>
                </div>


                <div class="row mid_header">
                    <div class="col-md-7 col-xs-7">
                            <div class="invoice-col">
                                <span class="invoice_to">Invoice To</span>
                                <address class="base_color">
                                    <div class="customer_name color_theme">{{ $invoice->customer_name }}</div>
                                    <div><strong>M</strong> {{ $invoice->customer_mobile }}</div>
                                    <div><strong>E</strong> {{ $invoice->customer_email }}</div>
                                </address>
                            </div>
                    </div>
                    <div class="col-md-5 col-xs-5">
                        <div class="invoice_word color_theme">
                            INVOICE
                        </div>
                        <div class="invoice_number">
                            No. #{{ $invoice->id }}
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
                                <th>Product/Service</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
                                <th>Quantity</th>
                                <th>Discount %</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceDetails as $item)
                            <tr>
                                <td class="dark">{{ $item->item_name }}</td>
                                <td><span class='WebRupee'>&#x20B9; </span>{{ $item->item_cost - $item->tax_value }}</td>
                                <td>{{ $item->tax_percent }} %</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->discount }} %</td>
                                <td class="dark"><span class='WebRupee'>&#x20B9; </span>{{ round($item->sub_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-8">
                    <div style="margin-top: 25px;" id="qrcode"></div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <div class="row">
                        <div class="col-xs-6 grand_total_heading">Grand Total:</div>
                        <div class="col-xs-6 grand_total_value"><span class='WebRupee'>&#x20B9; </span> {{ $invoice->total }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 due_date_heading">Due Date:</div>
                        <div class="col-xs-6 due_date_value">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-M-Y') }}</div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->



        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>
<script>
    var qrcode = new QRCode("qrcode", {
        text: "{{ $invoice->customer_name }}: {{ $invoice->seller_name }} | Total Amount Due: Rs. {{ $invoice->total }}",
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</html>
