<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manish Yadav | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.min.css">

    <link rel="stylesheet" href="css/style.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="qrcode.js"></script>
</head>


<body>
    <div class="wrapper">

        <!-- Main content -->
        <section class="invoice">

            <!-- title row -->
			<div class="row">
				<h1 style="margin-left:15px;">Manish Yadav: Mars Car Care Invoice</h1><br>
			</div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>Manish Yadav</strong>
                        <br> B-22, Tirupati Nagar,
                        <br> Near CBI Colony, Jagatpura
                        <br> Jaipur, 302017
                        <br> Email: manishyadav0012@gmail.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>Mars Car Care services Pvt Ltd</strong>
                        <br>IInd Floor, Rana Complex
                        <br>Panchsheel Park, Rajender
                        <br>Nagar G.T.Road Sahibabad
                        <br>Ghaziabad-201005
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                    <br>
                    <b>Invoice #</b>RBST004
                    <br>
                    <b>Date:</b> 20-July-2019
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
                                <th>Qty</th>
                                <th>Product/Service</th>
                                <th>Description</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>MARS Supervisor Project Website & App Development(July)</td>
                                <td>Mars Supervisor project develpment and server management</td>
                                <td>Rs. 33000</td>
                            </tr>
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
                    <p class="lead">Due Date: 20-Jul-2019</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>Rs. 33000</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>Rs. 0</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>Rs. 33000</td>
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
        text: "Manish Yadav: July invoice for Mars Car Care",
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</html>