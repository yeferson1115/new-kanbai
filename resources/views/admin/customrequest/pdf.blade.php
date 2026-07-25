<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    



  

    <style>
       .text-rigth{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .number-fact{
            font-size: 16px;
        }
        .row{
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .d-flex {
            display: flex!important;
        }
        .col1{
            flex: 0 0 auto;
            width: 100%;
        }
        .col2{
            flex: 0 0 auto;
            width: 50%;
        }
        .info-header{
            width: 100%;
            font-family: arial;
            font-size: 14px;
        }
        .border-bottom1{
            border-bottom: solid 1px #acacac;
        }
        .b-r{
            border-right: solid 1px #acacac;
            width: 49.7% !important;
        }
        .p-15{
            padding: 15px;
        }
        table.items{
            width: 100%;
        }
        table.items, table.items th, table.items td {
        border: 1px solid #bdb9b9;
        border-collapse: collapse;
        }       
        .logo{
            max-width: 250px;
        }
        .invoice-title{
            margin-bottom: 0px !important;
            color: #707070;
            font-size: 18px;
        }
        .depara{
            font-size: 18px;
            color: #707070;
            font-weight: 600;
            margin-bottom: 7px !important;
        }
        .text16{
            font-size: 16px;
            color: #707070;
        }
        .border{
            border-bottom: solid 1px #ebe9f1;
        }
        .container{
            padding: 15px;
        }
        .m3{
            margin: 3 !important;
            padding-bottom: 5px;
        }
        .table thead{
            color:#707070;
            font-size: 16px;
        }
        .table tbody tr td{
            padding: 15px;
            color: #707070;
        }
        .table{
            border-collapse: collapse;
        }
        .table thead{
            border-top: solid 1px #bdbdbd;
            border-bottom: solid 1px #bdbdbd;
        }
        .table thead tr th{
            padding-top:15px;
            padding-bottom:15px;
        }
        .border-bottom{
            border-top: solid 1px #bdbdbd;
            border-bottom: solid 1px #bdbdbd;
        }
        .invoice-total-title{
            color:#707070;
            font-size:16px;
        }
        .invoice-total-title span{
            color:#707070;
            font-weight: bold;
        }
      
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>

<div class="container">
    <table style="width: 100%;margin-bottom: 25px;">
        <tr>
            <td><img class="logo" src="{{$logo}}" /></td>
            <td style="text-align: right;">
                <h4 class="invoice-title">Cotización
                    <span class="invoice-number">#P{{$quotation->id}}</span>
                </h4>
                <div class="invoice-date-wrapper">
                    <p class="invoice-date-title">Fecha de solicitud: {{$quotation->created_at}}</p>
                                                    
                </div>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%;margin-bottom: 25px;">
        <tr>
            <td>
                <h6 class="mb-2 depara m3">De:</h6>
                <h6 class="mb-25 text16 m3">Alma de Colombia SAS </h6>
                <p class="card-text mb-25 text16 m3">NIT 901450303 </p>
                <p class="card-text mb-25 text16 m3" >Calle 35sur #45 b 72 </p>
                <p class="card-text mb-25 text16 m3">+57 3104508361</p>
            </td>
            <td>
                <h6 class="mb-2 depara m3">Para:</h6>
                <h6 class="mb-25 text16 m3">
                    @if($quotation->user!=null)
                        {{$quotation->user->name}} {{$quotation->user->lastname}}
                    @endif
                </h6>
                <p class="card-text mb-25 text16 m3">
                    @if($quotation->user!=null)
                        {{$quotation->user->phone}}
                    @endif
                </p>
                <p class="card-text mb-25 text16 m3">
                    @if($quotation->user!=null)
                        {{$quotation->user->email}}
                    @endif
                </p>
            </td>
        </tr>
    </table>

    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="py-1">ITEM</th>
                                                <th class="py-1">DESCRIPCIÓN</th>
                                                <th class="py-1">QTY</th>
                                                <th class="py-1">PRECIO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25">{{$quotation->product}}</p>
                                                  
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{$quotation->observations}}</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{$quotation->quantity}}</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">${{number_format($quotation->price_finish, 0, 0, '.')}}</span>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25">Envio</p>
                                                   
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">Embalaje, preparación y envío</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold"></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">${{number_format($quotation->price_shiping, 0, 0, '.')}}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="card-body invoice-padding pb-0">
                                    <div class=" invoice-sales-total-wrapper">
                                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                            <p class="card-text mb-0">
                                               
                                            </p>
                                        </div>
                                        <div class="col-md-6  justify-content-end order-md-2 order-1" style="text-align: right;">
                                            <div class="invoice-total-wrapper">
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Subtotal: <span>${{number_format(($quotation->price_finish*$quotation->quantity)+$quotation->price_shiping, 0, 0, '.')}}</span></p>
                                                    
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">IVA:<span>${{number_format(((($quotation->price_finish*$quotation->quantity)+$quotation->price_shiping)*$quotation->iva), 0, 0, '.')}}</span></p>
                                                </div>                                              
                                                
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total: <span>${{number_format(($quotation->price_finish*$quotation->quantity)+((($quotation->price_finish*$quotation->quantity)+$quotation->price_shiping)*$quotation->iva)+$quotation->price_shiping, 0, 0, '.')}}</span></p>                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


</div>
   

</body>
<!-- END: Body-->

</html>
