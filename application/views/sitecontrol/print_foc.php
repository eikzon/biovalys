<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
        @media print{
            .print{
             display: none;
            }
        }
        @page {
        /* dimensions for the whole page */
        size: A5;
        font-size: 8px !important;
        margin: 0;
        
        }
        body{
            padding: 20px;
            font-size: 14px !important;
        }
        .border{
            border: 1px solid #000;
            width: 100%;
        }
        .list{
            width: 100%;
            border-collapse: collapse;
            border: 0px;
            font-size: 12px !important;
        }
        .list td{
            border: 1px solid #000;
        }
        .title{
            padding: 0px 10px;
            border-bottom: 1px solid #000;
            font-size: 12px !important;
        }
        .base-line{
            border-collapse: collapse;
            border-bottom: 1px solid #000;
            width: 100%;
            font-size: 12px !important;
        }
        .base-line td{
            float: left;
            padding: 10px;
        }
        .sign{
           font-size: 12px !important;
           width: 100%;
           text-align: center;
        }
        .sign td{
           width: 33%; 
        }
        .sign-data{
           padding-top:40px; 
        }
        .sign-line{
          border-bottom: 1px solid #000;
          width: 150px;
        }
        .main-remark{
            padding-top:20px; 
            width: 100%;
        }
        .haft-line{
            border-right: 1px solid #000;
            width:25%;
            
        }
        .remark{
          width: 80%;
          text-align: left;
          font-size: 12px !important;
        }
        .item-code{
         width:10%;
         text-align: center;
         vertical-align: top;
        }
        .item-qty{
         width:15%;
         text-align: center;
         vertical-align: top; 
        }
        .line-head-width{
            width:150px;
            float: right;
        }
        .line{
         border-bottom: 1px solid #000;
        }
        .right{
         float:right !important;
         font-size: 12px !important;
        }
        .space-remark{
         width: 120px;
         font-size: 12px !important;
        }
        .remark-titile{
         text-align: right;
         vertical-align: top;
         width:0px; 
         font-size: 12px !important;
        }
        .logo{
/*
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
*/
            margin-bottom:10px;
            width: 100px;
        }
        .btn{
            display: inline-block;
            margin-bottom: 0px;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857;
            border-radius: 4px;
            -moz-user-select: none;
            border-radius: 3px;
            box-shadow: none;
            border: 1px solid transparent;
            color: #FFF;
            background-color: #5BC0DE;
            border-color: #46B8DA;
        }
        .btn:hover{
            color: #FFF;
            background-color: #31B0D5;
            border-color: #269ABC;
        }
        .print{
            margin-top: 20px;
            text-align: center;
        }
        </style>
    </head>
    <body>
    <img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="logo">
    <div class="border">
        <div class="title"><h3>F.O.C REQUEST FORM</h3></div>
        <table class="base-line">
            <tr>
                <td>F.O.C No. : <div class="line-head-width"><div class="line"><?PHP echo $customer['order_foc_code']; ?></div></div></td>
                <td class="right">Ref : <div class="line-head-width"><div class="line"><?PHP echo $customer['order_foc_code']; ?></div></div></td>
            </tr>
        </table>
        <table class="base-line" style="width:100%;">
            <tr>
                <td class="haft-line">
                    <div>Purpose</div>
                    <div><input type="checkbox"> Promotion</div>
                    <div><input type="checkbox"> Other</div>
                    <div class="line">&nbsp;</div>
                    <div class="line">&nbsp;</div>
                    <div class="line"><?PHP echo $customer['foc_remark']; ?></div>
                    
                </td>
                <td style="width:60%;float:left;">
                    <div style="width:100%;float:left;"><div style="float: left;border-bottom: 1px #FFF solid;"> Issuer : </div> <?PHP echo @$customer['member_name']; ?><div class="line"></div></div>
                    <div style="width:100%;float:left;"><div style="float: left;border-bottom: 1px #FFF solid;"> Customer ID (A/C) : </div> <?PHP echo $customer['customer_credit_number']; ?><div class="line"></div></div>
                    <div style="width:100%;float:left;"> <div style="float: left;border-bottom: 1px #FFF solid;">Customer Name     : </div> <?PHP echo $customer['customer_name']; ?><div class="line"></div></div>
                    <div style="width:100%;float:left;">&nbsp; <div class="line"></div></div>
                    <div style="width:100%;float:left;">&nbsp; <div class="line"></div></div>
                </td>
            </tr>
        </table>
        <table class="list" cellspacing="0">
            <tr>
                <td class="item-code">Code</td>
                <td>Description</td>
                <td class="item-qty">Packing</td>
                <td class="item-qty">Quanlity</td>
            </tr>
            <?PHP
            $td = $ftd = '';
            $num = 1;
            if(isset($detail) && !empty($detail))
            {
                foreach($detail as $item)
                {
                $td .='<tr>
                        <td class="item-code">'.$item['product_code'].'</td>
                        <td>'.$item['product_name'].$item['product_detail'].'</td>
                        <td class="item-qty">Box</td>
                        <td class="item-qty">'.$item['fdetail_qty'].' Box</td>
                    </tr>';
                $num++;
                }
                echo $td;
            }
            for($i=1;$i<=(7-$num);$i++)
            {
                $ftd .= '<tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                         </tr>';
            }
            echo $ftd;
            ?>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div align="center" class="main-remark">
            <div class="remark">
                <table width="100%">
                    <tr>
                        <td class="remark-titile">Remark</td>
                        <td>
                            <div class="space-remark">:</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark">&nbsp;</div><div class="line"></div>
                            <div class="space-remark"><?PHP echo $customer['foc_remark']; ?></div><div class="line"></div></td>
                    </tr>
                </table>
                
            </div>
        </div>
        <table class="sign">
            <tr>
                <td class="sign-data" align="center">&nbsp;<div class="sign-line"></div></td>
                <td class="sign-data" align="center">&nbsp;<div class="sign-line"></div></td>
                <td class="sign-data" align="center">&nbsp;<div class="sign-line"></div></td>
            </tr>
            <tr>
                <td>Issued by MSR</td>
                <td>Approved by NSM</td>
                <td>Approved by MD</td>
            </tr>
            <tr>
                <td align="center">&nbsp;<div class="sign-line"></div></td>
                <td align="center">&nbsp;<div class="sign-line"></div></td>
                <td align="center">&nbsp;<div class="sign-line"></div></td>
            </tr>
            <tr>
                <td>Date</td>
                <td>Date</td>
                <td>Date</td>
            </tr>
        </table>
    </div>
        <div class="print">
            <button class="btn" type="submit" onclick="window.print();">Print</button>
        </div>
    </body>
</html>
<script>
        window.print();
</script>
