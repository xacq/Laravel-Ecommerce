<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\OrderStatus;
use App\Models\OrdersLog;
use App\Models\OrderItemStatus;
use App\Models\User;
use Session;
use Auth;
use Dompdf\Dompdf;

class OrderController extends Controller
{
    public function orders(){
        Session::put('page','orders');
        $adminTipo = Auth::guard('admin')->user()->tipo;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminTipo == "vendedor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Su cuenta de proveedor aún no está aprobada. Por favor asegúrese de llenar su formulario válido: datos personales, comerciales y bancarios');
            }
        }
        if($adminTipo=="vendedor"){
            $orders = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->orderBy('id','Asc')->get()->toArray();
        }else{
            $orders = Order::with('orders_products')->orderBy('id','Asc')->get()->toArray();
        }
        /* dd($orders); */
        return view('admin.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id){
        Session::put('page','orders');
        $adminTipo = Auth::guard('admin')->user()->tipo;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminTipo == "vendedor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Su cuenta de proveedor aún no está aprobada. Por favor asegúrese de llenar su formulario válido: datos personales, comerciales y bancarios');
            }
        }
        if($adminTipo=="vendedor"){
            $orderDetails = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->where('id',$id)->first()->toArray();
        }else{
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }


        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        $orderItemStatuses = OrderItemStatus::where('status',1)->get()->toArray();
        $orderLog = OrdersLog::with('orders_products')->where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        /* dd($orderLog); */

        $total_items = 0;
        foreach($orderDetails['orders_products'] as $product){
            $total_items = $total_items + $product['producto_qty'];
        }
        //calular el decuento
        if($orderDetails['cupon_amount']>0){
            $item_discount = round($orderDetails['cupon_amount']/$total_items,2);
        }else{
            $item_discount = 0;
        }

        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderItemStatuses','orderLog','item_discount'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);

            //actualizar el nombre de mensajero y el numero de rastreo
            if(!empty($data['nombre_mensajero'])&&!empty($data['numero_rastreo'])){
                Order::where('id',$data['order_id'])->update(['nombre_mensajero'=>$data['nombre_mensajero'],'numero_rastreo'=>$data['numero_rastreo']]);
            }

            //actualizar el log de pedido
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();


            $deliveryDetails = Order::select('celular','email','nombre')->where('id',$data['order_id'])->first()->toArray();

            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();

            if(!empty($data['nombre_mensajero'])&&!empty($data['numero_rastreo'])){
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'nombre' => $deliveryDetails['nombre'],
                    'order_id' => $data['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_status'],
                    'nombre_mensajero' => $data['nombre_mensajero'],
                    'numero_rastreo' => $data['numero_rastreo'],
                ];
                Mail::send('emails.order_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Status del Pedido Actualizado..!');
                });
            }else{
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'nombre' => $deliveryDetails['nombre'],
                    'order_id' => $data['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_status'],
                ];
                Mail::send('emails.order_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Status del Pedido Actualizado..!');
                });
            }




            $message = "El status del pedido se actualizo correctamente!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function updateOrderItemStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            OrdersProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);

            //actualizar el nombre de mensajero y el numero de rastreo
            if(!empty($data['item_nombre_mensajero'])&&!empty($data['item_numero_rastreo'])){
                OrdersProduct::where('id',$data['order_item_id'])->update(['nombre_mensajero'=>$data['item_nombre_mensajero'],'numero_rastreo'=>$data['item_numero_rastreo']]);
            }

            $getOrderId = OrdersProduct::select('order_id')->where('id',$data['order_item_id'])->first()->toArray();

            //actualizar el log de pedido
            $log = new OrdersLog;
            $log->order_id = $getOrderId['order_id'];
            $log->order_item_id = $data['order_item_id'];
            $log->order_status = $data['order_item_status'];
            $log->save();

            $deliveryDetails = Order::select('celular','email','nombre')->where('id',$getOrderId['order_id'])->first()->toArray();

            $order_item_id = $data['order_item_id'];
            $orderDetails = Order::with(['orders_products'=>function($query)use($order_item_id){
                $query->where('id',$order_item_id);
            }])->where('id',$getOrderId['order_id'])->first()->toArray();

            if(!empty($data['item_nombre_mensajero'])&&!empty($data['item_numero_rastreo'])){
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'nombre' => $deliveryDetails['nombre'],
                    'order_id' => $getOrderId['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_item_status'],
                    'nombre_mensajero' => $data['item_nombre_mensajero'],
                    'numero_rastreo' => $data['item_numero_rastreo'],
                ];
                Mail::send('emails.order_item_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Item del Status en su Pedido  esta actualizado..!');
                });
            }else{
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'nombre' => $deliveryDetails['nombre'],
                    'order_id' => $getOrderId['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_item_status'],
                ];
                Mail::send('emails.order_item_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Item del Status en su Pedido  esta actualizado..!');
                });
            }



            $message = "El item status del pedido se actualizo correctamente!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function viewOrderInvoice($order_id){
        $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function viewPDFInvoice($order_id){
        $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();

        $invoiceHTML = '<!DOCTYPE html>
                        <html>
                        <head>
                            <title>Facturación AmbatoShop</title>
                            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                            <meta http-equiv="content-type" content="text-html; charset=utf-8">
                            <style type="text/css">
                                html, body, div, span, applet, object, iframe,
                                h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                                a, abbr, acronym, address, big, cite, code,
                                del, dfn, em, img, ins, kbd, q, s, samp,
                                small, strike, strong, sub, sup, tt, var,
                                b, u, i, center,
                                dl, dt, dd, ol, ul, li,
                                fieldset, form, label, legend,
                                table, caption, tbody, tfoot, thead, tr, th, td,
                                article, aside, canvas, details, embed,
                                figure, figcaption, footer, header, hgroup,
                                menu, nav, output, ruby, section, summary,
                                time, mark, audio, video {
                                    margin: 0;
                                    padding: 0;
                                    border: 0;
                                    font: inherit;
                                    font-size: 100%;
                                    vertical-align: baseline;
                                }

                                html {
                                    line-height: 1;
                                }

                                ol, ul {
                                    list-style: none;
                                }

                                table {
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                }

                                caption, th, td {
                                    text-align: left;
                                    font-weight: normal;
                                    vertical-align: middle;
                                }

                                q, blockquote {
                                    quotes: none;
                                }
                                q:before, q:after, blockquote:before, blockquote:after {
                                    content: "";
                                    content: none;
                                }

                                a img {
                                    border: none;
                                }

                                article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                                    display: block;
                                }

                                body {
                                    font-family: "Source Sans Pro", sans-serif;
                                    font-weight: 300;
                                    font-size: 12px;
                                    margin: 0;
                                    padding: 0;
                                }
                                body a {
                                    text-decoration: none;
                                    color: inherit;
                                }
                                body a:hover {
                                    color: inherit;
                                    opacity: 0.7;
                                }
                                body .container {
                                    min-width: 500px;
                                    margin: 0 auto;
                                    padding: 0 20px;
                                }
                                body .clearfix:after {
                                    content: "";
                                    display: table;
                                    clear: both;
                                }
                                body .left {
                                    float: left;
                                }
                                body .right {
                                    float: right;
                                }
                                body .helper {
                                    display: inline-block;
                                    height: 100%;
                                    vertical-align: middle;
                                }
                                body .no-break {
                                    page-break-inside: avoid;
                                }

                                header {
                                    margin-top: 20px;
                                    margin-bottom: 50px;
                                }
                                header figure {
                                    float: left;
                                    width: 60px;
                                    height: 60px;
                                    margin-right: 10px;
                                    background-color: #8BC34A;
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header figure img {
                                    margin-top: 13px;
                                }
                                header .company-address {
                                    float: left;
                                    max-width: 150px;
                                    line-height: 1.7em;
                                }
                                header .company-address .title {
                                    color: #8BC34A;
                                    font-weight: 400;
                                    font-size: 1.5em;
                                    text-transform: uppercase;
                                }
                                header .company-contact {
                                    float: right;
                                    height: 60px;
                                    padding: 0 10px;
                                    background-color: #8BC34A;
                                    color: white;
                                }
                                header .company-contact span {
                                    display: inline-block;
                                    vertical-align: middle;
                                }
                                header .company-contact .circle {
                                    width: 20px;
                                    height: 20px;
                                    background-color: white;
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header .company-contact .circle img {
                                    vertical-align: middle;
                                }
                                header .company-contact .phone {
                                    height: 100%;
                                    margin-right: 20px;
                                }
                                header .company-contact .email {
                                    height: 100%;
                                    min-width: 100px;
                                    text-align: right;
                                }

                                section .details {
                                    margin-bottom: 55px;
                                }
                                section .details .client {
                                    width: 50%;
                                    line-height: 20px;
                                }
                                section .details .client .name {
                                    color: #8BC34A;
                                }
                                section .details .data {
                                    width: 50%;
                                    text-align: right;
                                }
                                section .details .title {
                                    margin-bottom: 15px;
                                    color: #8BC34A;
                                    font-size: 3em;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                    font-size: 0.9166em;
                                }
                                section table .qty, section table .unit, section table .total {
                                    width: 15%;
                                }
                                section table .desc {
                                    width: 55%;
                                }
                                section table thead {
                                    display: table-header-group;
                                    vertical-align: middle;
                                    border-color: inherit;
                                }
                                section table thead th {
                                    padding: 5px 10px;
                                    background: #8BC34A;
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #FFFFFF;
                                    text-align: right;
                                    color: white;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table thead th:last-child {
                                    border-right: none;
                                }
                                section table thead .desc {
                                    text-align: left;
                                }
                                section table thead .qty {
                                    text-align: center;
                                }
                                section table tbody td {
                                    padding: 10px;
                                    background: #E8F3DB;
                                    color: #777777;
                                    text-align: right;
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #E8F3DB;
                                }
                                section table tbody td:last-child {
                                    border-right: none;
                                }
                                section table tbody h3 {
                                    margin-bottom: 5px;
                                    color: #8BC34A;
                                    font-weight: 600;
                                }
                                section table tbody .desc {
                                    text-align: left;
                                }
                                section table tbody .qty {
                                    text-align: center;
                                }
                                section table.grand-total {
                                    margin-bottom: 45px;
                                }
                                section table.grand-total td {
                                    padding: 5px 10px;
                                    border: none;
                                    color: #777777;
                                    text-align: right;
                                }
                                section table.grand-total .desc {
                                    background-color: transparent;
                                }
                                section table.grand-total tr:last-child td {
                                    font-weight: 600;
                                    color: #8BC34A;
                                    font-size: 1.18181818181818em;
                                }

                                footer {
                                    margin-bottom: 20px;
                                }
                                footer .thanks {
                                    margin-bottom: 40px;
                                    color: #8BC34A;
                                    font-size: 1.16666666666667em;
                                    font-weight: 600;
                                }
                                footer .notice {
                                    margin-bottom: 25px;
                                }
                                footer .end {
                                    padding-top: 5px;
                                    border-top: 2px solid #8BC34A;
                                    text-align: center;
                                }
                            </style>
                        </head>

                        <body>
                            <header class="clearfix">
                                <div class="container">
                                    <figure>
                                        <img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjM5cHgiIGhlaWdodD0iMzFweCIgdmlld0JveD0iMCAwIDM5IDMxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5ob21lNDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPgogICAgICAgIDxnIGlkPSJJTlZPSUNFLTEiIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00Mi4wMDAwMDAsIC00NS4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9IlpBR0xBVkxKRSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIj4KICAgICAgICAgICAgICAgIDxnIGlkPSJob21lNCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIuMDAwMDAwLCAzMC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzguMjc5MzM1LDE0LjAzOTk1MiBMMzIuMzc5MDM3OCw5LjAxMjMzODM1IEwzMi4zNzkwMzc4LDMuMjA0MzM2NzQgQzMyLjM3OTAzNzgsMi4xNTQ0MTY1MyAzMS4zODA1NTkyLDEuMzAzMjk3MjggMzAuMTQ2MDE3NiwxLjMwMzI5NzI4IEMyOC45MTQ2MTk2LDEuMzAzMjk3MjggMjcuOTE2MTQxMSwyLjE1NDQxNjUzIDI3LjkxNjE0MTEsMy4yMDQzMzY3NCBMMjcuOTE2MTQxMSw1LjIwOTMzODY1IEwyMy41MjI2OTc3LDEuNDY1NzY5OTggQzIxLjM1MDM4NzksLTAuMzgzODc0MjAyIDE3LjU3MzY3NTEsLTAuMzgwNjA5NjggMTUuNDA2NjcsMS40NjkwMzQ1IEwwLjY1MzA3ODA4NiwxNC4wMzk5NTIgQy0wLjIxNzU5NDQ1OCwxNC43ODM1MDk1IC0wLjIxNzU5NDQ1OCwxNS45ODY3Nzg1IDAuNjUzMDc4MDg2LDE2LjcyODk5NjYgQzEuNTI0NjM0NzYsMTcuNDcyNTU0MSAyLjkzOTQ0MDgxLDE3LjQ3MjU1NDEgMy44MTAxMTMzNSwxNi43Mjg5OTY2IEwxOC41NjIxMzM1LDQuMTU4MDc5MTUgQzE5LjA0MzAwMjUsMy43NTA2ODM2NSAxOS44ODk5MDE4LDMuNzUwNjgzNjUgMjAuMzY4MDIwMiw0LjE1NjgyMzU2IEwzNS4xMjIyOTk3LDE2LjcyODk5NjYgQzM1LjU2MDE0MTEsMTcuMTAwNzMzNSAzNi4xMzA0MDU1LDE3LjI4NTgwNjcgMzYuNzAwNjcsMTcuMjg1ODA2NyBDMzcuMjcyMDE1MSwxNy4yODU4MDY3IDM3Ljg0MzQ1ODQsMTcuMTAwNzMzNSAzOC4yNzk3MjgsMTYuNzI4OTk2NiBDMzkuMTUwNzkzNSwxNS45ODY3Nzg1IDM5LjE1MDc5MzUsMTQuNzgzNTA5NSAzOC4yNzkzMzUsMTQuMDM5OTUyIEwzOC4yNzkzMzUsMTQuMDM5OTUyIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjAuMjQxMzkyOSw3Ljc2Njk2NTM5IEMxOS44MTI3ODU5LDcuNDAyMDA4NjcgMTkuMTE4OTM5NSw3LjQwMjAwODY3IDE4LjY5MTUxMTMsNy43NjY5NjUzOSBMNS43MTQyMzY3OCwxOC44MjEzMDM2IEM1LjUwOTMxNDg2LDE4Ljk5NTU3ODggNS4zOTMzOTU0NywxOS4yMzM5NzI1IDUuMzkzMzk1NDcsMTkuNDgyNDEwOSBMNS4zOTMzOTU0NywyNy41NDUzNTk2IEM1LjM5MzM5NTQ3LDI5LjQzNzE5MTQgNy4xOTM1ODQzOCwzMC45NzEwMTQxIDkuNDEzODMzNzUsMzAuOTcxMDE0MSBMMTUuODM4NzE1NCwzMC45NzEwMTQxIEwxNS44Mzg3MTU0LDIyLjQ5MjU1MDUgTDIzLjA5MjUxODksMjIuNDkyNTUwNSBMMjMuMDkyNTE4OSwzMC45NzEwMTQxIEwyOS41MTc4OTE3LDMwLjk3MTAxNDEgQzMxLjczODE0MTEsMzAuOTcxMDE0MSAzMy41MzgyMzE3LDI5LjQzNzE5MTQgMzMuNTM4MjMxNywyNy41NDUzNTk2IEwzMy41MzgyMzE3LDE5LjQ4MjQxMDkgQzMzLjUzODIzMTcsMTkuMjMzOTcyNSAzMy40MjMwOTgyLDE4Ljk5NTU3ODggMzMuMjE3NDg4NywxOC44MjEzMDM2IEwyMC4yNDEzOTI5LDcuNzY2OTY1MzkgWiIgaWQ9IkZpbGwtMyI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="Ambato Shop Imagen">
                                    </figure>
                                    <div class="company-address">
                                        <h2 class="title">AMBATO SHOP</h2>
                                        <p>
                                            Kevin Masabanda<br>
                                            Ecuador, Ambato
                                        </p>
                                    </div>
                                    <div class="company-contact">

                                        <div class="email right">
                                            <span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt="Ambato Shop Imagen"><span class="helper"></span></span>
                                            <a href="mailto:kevinmasabanda2c@gmail.com">kevinmasabanda2c@gmail.com</a>
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                </div>
                            </header>

                            <section>
                                <div class="container">
                                    <div class="details clearfix">
                                        <div class="client left">
                                            <p>FACTURADO A:</p>
                                            <p class="name">'.$orderDetails['nombre'].'</p>
                                            <p>'.$orderDetails['direccion'].', '.$orderDetails['ciudad'].', '.$orderDetails['estado'].', '.$orderDetails['pais'].' - '.$orderDetails['pincodigo'].'</p>
                                            <a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a>
                                        </div>
                                        <div class="data right">
                                            <div class="title">Pedido ID: '.$orderDetails['id'].'</div>
                                            <div class="date">
                                                Fecha: '.date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])).'<br>
                                                Monto del Pedido: $ '.$orderDetails['total_general'].'<br>
                                                Status del Pedido:'.$orderDetails['order_status'].'<br>
                                                Metodo de Pago:'.$orderDetails['payment_method'].'<br>
                                            </div>
                                        </div>
                                    </div>

                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="desc">Código del Producto</th>
                                                <th class="qty">Tamaño</th>
                                                <th class="qty">Color</th>
                                                <th class="qty">Cantidad</th>
                                                <th class="unit">Precio Unitario</th>
                                                <th class="total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        $subTotal = 0;
                                        foreach($orderDetails['orders_products'] as $product){
                                            $invoiceHTML .=  '<tr>
                                                <td class="desc">'.$product['producto_codigo'].'</td>
                                                <td class="qty">'.$product['producto_tamano'].'</td>
                                                <td class="qty">'.$product['producto_color'].'</td>
                                                <td class="qty">'.$product['producto_qty'].'</td>
                                                <td class="unit">$ '.$product['producto_precio'].'</td>
                                                <td class="total">$ '.$product['producto_qty']*$product['producto_precio'].'</td>
                                            </tr>';
                                            $subTotal = $subTotal + ($product['producto_precio'] * $product['producto_qty']);
                                        }

                                        $invoiceHTML .= '</tbody>
                                    </table>
                                    <div class="no-break">
                                        <table class="grand-total">
                                            <tbody>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="total" colspan=2>SUBTOTAL</td>
                                                    <td class="total">$ '.$subTotal.'</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="total" colspan=2>ENVÍO</td>
                                                    <td class="total">$ '.$orderDetails['shipping_charges'].'</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="total" colspan=2>DESCUENTO</td>';
                                                    if($orderDetails['cupon_amount']>0){
                                                        $invoiceHTML .= '<td class="total">$ '.$orderDetails['cupon_amount'].'</td>';
                                                    }else{
                                                        $invoiceHTML .= '<td class="total">$ 0</td>';
                                                    }
                                                $invoiceHTML .= '</tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="desc"></td>
                                                    <td class="total" colspan="2">TOTAL</td>
                                                    <td class="total">$ '.$orderDetails['total_general'].'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <footer>
                                <div class="container">
                                    <div class="thanks">¡Gracias por confiar en nosotros! Fue un gusto atenderte</div>

                                    <div class="end">Impulsando el comercio en línea en Ambato, conectando negocios con tus necesidades.</div>
                                </div>
                            </footer>

                        </body>

                        </html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($invoiceHTML);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}
