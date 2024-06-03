<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{asset('assets/images/angels-mini-lending.png')}}">
    <title>Angels Mini Lending Invoice</title>
</head>
<style>
   @page { margin: 0px; }
   body { margin: 0px; }
</style>
<body style="font-family:Tahoma, Geneva, sans-serif;letter-spacing:3px;margin-top:10px" onload="print()">
    <div style="margin-left:15px;margin-right:15px;">
        <div style="max-width:100%;height:auto;padding:100px;padding-top:0!important;padding-bottom:0!important">
            <center>
                <img align="center" src="{{ isset($response['image_path'])?$response['image_path']:asset('assets/images/print-icon.png') }}" style="width:30%">
                   <p style="font-size:10px">Angels Mini Lending Transaction Summary</p><br>
            </center>
            <p align="center" style="font-size:9px;"><i>Admin's Copy</i></p>
            <span style="display:block;border-bottom:1.6px dashed #000000;"></span>
            <div style="margin:auto">
                <table width="100%" cellpadding="0" cellspacing="0" style="line-height:2.8;">
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Reference Number:</td>
                        <td align="right"style="font-size:9px;"><strong>{{$response['transactions']->reference}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Name:</td>
                        <td align="right" style="font-size:9px;"><strong>{{$response['transactions']->fullname}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Tenurity: </td>
                        <td align="right" style="font-size:9px;"><strong>{{$response['transactions']->tenurity}} {{$response['transactions']->tenurity!='1'?'months':'month'}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Rate: </td>
                        <td align="right" style="font-size:9px;"><strong>{{str_replace(['0.0','0.'], '', $response['transactions']->rate)}} %</strong></td>
                    </tr>
                    <tr >
                        <td style="font-size:10px;">Principal Amount:</td>
                        <td align="right" style="font-size:10px;"><strong><span style="font-family: DejaVu Sans; sans-serif;line-height:2">&#x20B1;</span>{{number_format($response['transactions']->amount,2)}}</strong></td>
                    </tr>
                    <tr >
                        <td style="font-size:10px;">Total Amount:</td>
                        <td align="right" style="font-size:10px;"><strong><span style="font-family: DejaVu Sans; sans-serif;line-height:2">&#x20B1;</span>{{number_format($response['transactions']->amount + $response['transactions']->interest,2)}}</strong></td>
                    </tr>
                </table>
            </div>
            <span style="display:block;border-bottom:1.6px dashed #000000;margin-top:5px"></span>
            <p style="font-size:9px;">Date of Transaction: <strong>{{date('M d, Y', strtotime($response['transactions']->last_payment_date))}}</strong></p>
            <p style="font-size:9px;">Processed By: <strong>Angels Mini Lending</strong></p>
            <p style="font-size:9px;">IMPORTANT:<strong>This will serve as your official receipt.</strong></p>
         </div>
    </div>
    <br><br><br><br><br><br>
    <span style="display:block;border-bottom:1.6px dashed #000000;margin-bottom:10px"></span>
    <div style="margin-left:15px;margin-right:15px;">
        <div style="max-width:100%;height:auto;padding:100px;padding-top:0!important;padding-bottom:0!important">
            <center>
                <img align="center" src="{{ isset($response['image_path'])?$response['image_path']:asset('assets/images/print-icon.png') }}" style="width:30%">
                   <p style="font-size:10px">Angels Mini Lending Transaction Summary</p><br>
            </center>
            <p align="center" style="font-size:9px;"><i>Admin's Copy</i></p>
            <span style="display:block;border-bottom:1.6px dashed #000000;"></span>
            <div style="margin:auto">
                <table width="100%" cellpadding="0" cellspacing="0" style="line-height:2.8;">
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Reference Number:</td>
                        <td align="right"style="font-size:9px;"><strong>{{$response['transactions']->reference}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Name:</td>
                        <td align="right" style="font-size:9px;"><strong>{{$response['transactions']->fullname}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Tenurity: </td>
                        <td align="right" style="font-size:9px;"><strong>{{$response['transactions']->tenurity}} {{$response['transactions']->tenurity!='1'?'months':'month'}}</strong></td>
                    </tr>
                    <tr style="border-bottom:2px solid #F0F0F0;">
                        <td style="font-size:9px;">Rate: </td>
                        <td align="right" style="font-size:9px;"><strong>{{str_replace(['0.0','0.'], '', $response['transactions']->rate)}} %</strong></td>
                    </tr>
                    <tr >
                        <td style="font-size:10px;">Principal Amount:</td>
                        <td align="right" style="font-size:10px;"><strong><span style="font-family: DejaVu Sans; sans-serif;line-height:2">&#x20B1;</span>{{number_format($response['transactions']->amount,2)}}</strong></td>
                    </tr>
                    <tr >
                        <td style="font-size:10px;">Total Amount:</td>
                        <td align="right" style="font-size:10px;"><strong><span style="font-family: DejaVu Sans; sans-serif;line-height:2">&#x20B1;</span>{{number_format($response['transactions']->amount + $response['transactions']->interest,2)}}</strong></td>
                    </tr>
                </table>
            </div>
            <span style="display:block;border-bottom:1.6px dashed #000000;margin-top:5px"></span>
            <p style="font-size:9px;">Date of Transaction: <strong>{{date('M d, Y', strtotime($response['transactions']->last_payment_date))}}</strong></p>
            <p style="font-size:9px;">Processed By: <strong>Angels Mini Lending</strong></p>
            <p style="font-size:9px;">IMPORTANT:<strong>This will serve as your official receipt.</strong></p>
         </div>
    </div>
</body>
</html>


