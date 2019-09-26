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
        .watermark {
            position: absolute;
            top: 35%;
            width: 95%;
            left: 2%;
            opacity: 0.1;
            z-index: 999;
            transform: rotate(-35deg);
        }
    </style>
</head>


<body>
    <div class="wrapper">

        <!-- Main content -->
        <section class="invoice">

            <!-- title row -->
            <div class="row">
                <h1 style="margin-left:15px;">{{ $invoice->customer_name }}: {{ $invoice->seller_name }}</h1><br>
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <!-- <strong>Wheelers Detailers Pvt Ltd</strong>
                        <br>A-10/64, Ground Floor, Opposite DPS
                        <br>Ghaziabad Gate No. 5 Site-3,
                        <br>Industrial Area Meerut Road
                        <br>Ghaziabad-201001 -->

                        <strong>{{ $invoice->seller_name }}</strong>
                        <br>{{ $invoice->seller_address_line1 }}
                        <br>{{ $invoice->seller_address_line2 }}
                        <br>{{ $invoice->seller_address_line3 }}

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $invoice->customer_name }}</strong>
                        <br> Mobile: {{ $invoice->customer_mobile }}
                        <br> Email: {{ $invoice->customer_email }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <br>
                    <b>GSTIN No.: </b> {{ $invoice->gs_tin }}  <!-- 07AABCW6278Q1ZG -->
                    <br>
                    <b>Invoice: </b>#{{ $invoice->id }}
                    <br>
                    <b>Date & Time: </b> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}
                    <br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Product/Service</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Discount %</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceDetails as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_cost }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->discount }}</td>
                                <td>{{ round($item->sub_total, 2) }}</td>
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
                <div class="col-xs-6">
                    <div style="margin-top: 25px;" id="qrcode"></div>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <p class="lead">Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-M-Y') }}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <!-- <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>Rs. 33000</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>Rs. 0</td>
                            </tr> -->
                            <tr>
                                <th>Total:</th>
                                <td> Rs. {{ $invoice->total }}</td>
                            </tr>
                        </table>
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
