<?php

namespace App\helper;

use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\WhatsappMessage;
class whatsapp_helper
{
    public static function whatsapp_message_config($vendor_id)
    {
        $whatsappp = WhatsappMessage::first();
        if (!empty($vendor_id)) {
            $whatsappp = WhatsappMessage::where('vendor_id', $vendor_id)->first();
        }
        return $whatsappp;
    }

    public static function whatsappmessage($booking_number, $vendor_slug, $vendordata)
    {
        try {
            $getbooking = Booking::where('booking_number', $booking_number)->where('vendor_id', $vendordata->id)->first();
            if ($getbooking->payment_status == "1") {
                $payment_status = trans('labels.unpaid');
            }
            if ($getbooking->payment_status == "2") {
                $payment_status = trans('labels.paid');
            }

            $tax = explode("|", $getbooking->tax);
            $tax_name = explode("|", $getbooking->tax_name);

            $tax_data[] = "";
            if ($tax != "") {
                foreach ($tax as $key => $tax_value) {
                    @$tax_data[] .= "👉 " . $tax_name[$key] . ' : ' . helper::currency_formate((float)$tax[$key], $vendordata->id);
                }
            }
            $tdata = implode("|", $tax_data);


            $tax_val = str_replace('|', '%0a', $tdata);
            $var = ["{service_name}", "{booking_no}", "{payment_status}", "{sub_total}", "{total_tax}", "{offer_code}", "{discount_amount}", "{grand_total}", "{message}", "{customer_name}", "{customer_mobile}", "{customer_email}", "{address}", "{city}", "{state}", '{country}', "{landmark}", "{postal_code}", "{booking_date}", "{start_time}", "{end_time}", "{payment_type}", "{track_booking_url}", "{website_url}"];
            $newvar   = [urlencode($getbooking->service_name), $getbooking->booking_number, $payment_status, helper::currency_formate($getbooking->sub_total, $vendordata->id), $tax_val, $getbooking->offer_code, helper::currency_formate($getbooking->offer_amount, $vendordata->id), helper::currency_formate($getbooking->grand_total, $vendordata->id), $getbooking->booking_notes, $getbooking->customer_name, $getbooking->mobile, $getbooking->email, $getbooking->address, $getbooking->city, $getbooking->state, $getbooking->country, $getbooking->landmark, $getbooking->postalcode, $getbooking->booking_date, $getbooking->booking_time, $getbooking->booking_endtime, @helper::getpayment($getbooking->transaction_type, $vendordata->id)->payment_name, helper::storefront_url($vendordata, 'booking/' . $booking_number), helper::storefront_url($vendordata)];
            $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_message));
            if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 1) {
                $whmessage = str_replace($var, $newvar, str_replace("\r\n", "%0a", @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_message));
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_phone_number_id . '/messages',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                    "messaging_product": "whatsapp",
                    "to": "917016428845",
                    "text": {
                        "body" : "' . $whmessage . '"
                    }
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_access_token . ''
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            }

            return $whmessage;
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public static function orderwhatsappmessage($order_number, $vendor_slug, $vendordata)
    {
        try {
            $pagee[] = "";
            $getorder = Order::where('order_number', $order_number)->where('vendor_id', $vendordata->id)->first();
            if ($getorder->payment_status == "1") {
                $payment_status = trans('labels.unpaid');
            }
            if ($getorder->payment_status == "2") {
                $payment_status = trans('labels.paid');
            }
            if ($getorder->delivery_charge > 0) {
                $delivery_charge = helper::currency_formate($getorder->delivery_charge, $vendordata->id);
            } else {
                $delivery_charge = trans('labels.free');
            }
            $data = OrderDetails::where('order_id', $getorder->id)->get();
            foreach ($data as $value) {
                $item_message = whatsapp_helper::whatsapp_message_config($vendordata->id)->item_message;
                $itemvar = ["{qty}", "{item_name}", "{item_price}", "{total}"];
                $newitemvar = [$value['qty'], urlencode($value['product_name']), helper::currency_formate($value->product_price, $vendordata->id), helper::currency_formate($value->product_price * $value['qty'], $vendordata->id)];
                $pagee[] = str_replace($itemvar, $newitemvar, $item_message);
            }

            $items = implode("|", $pagee);
            $itemlist = str_replace('|', '%0a', $items);

            $tax_amount = explode("|", $getorder->tax_amount);
            $tax_name = explode("|", $getorder->tax_name);

            $tax_data[] = "";
            if ($tax_amount != "") {
                foreach ($tax_amount as $key => $tax_value) {
                    @$tax_data[] .= "👉 " . $tax_name[$key] . ' : ' . helper::currency_formate((float)$tax_amount[$key], $vendordata->id);
                }
            }
            $tdata = implode("|", $tax_data);
            $tax_val = str_replace('|', '%0a', $tdata);

            $var = ["{order_no}", "{item_variable}", "{payment_status}", "{sub_total}", "{total_tax}", "{offer_code}", "{discount_amount}", "{delivery_charge}", "{grand_total}", "{notes}", "{customer_name}", "{customer_mobile}", "{customer_email}", "{address}", "{city}", "{state}", '{country}', "{landmark}", "{postal_code}", "{booking_date}", "{payment_type}", "{store_name}", "{track_order_url}", "{website_url}"];
            $newvar   = [$getorder->order_number, $itemlist, $payment_status, helper::currency_formate($getorder->sub_total, $vendordata->id), $tax_val, $getorder->offer_code, helper::currency_formate($getorder->offer_amount, $vendordata->id), $delivery_charge, helper::currency_formate($getorder->grand_total, $vendordata->id), $getorder->notes, $getorder->user_name, $getorder->user_mobile, $getorder->user_email, $getorder->address, $getorder->city, $getorder->state, $getorder->country, $getorder->landmark, $getorder->postal_code, $getorder->booking_date, @helper::getpayment($getorder->transaction_type, $vendordata->id)->payment_name, $vendordata->name, helper::storefront_url($vendordata, 'order/' . $order_number), helper::storefront_url($vendordata)];
            $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", whatsapp_helper::whatsapp_message_config($vendordata->id)->order_whatsapp_message));
            if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 1) {
                $whmessage = str_replace($var, $newvar, str_replace("\r\n", "%0a", @whatsapp_helper::whatsapp_message_config($vendordata->id)->order_whatsapp_message));
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_phone_number_id . '/messages',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                    "messaging_product": "whatsapp",
                    "to": "917016428845",
                    "text": {
                        "body" : "' . $whmessage . '"
                    }
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_access_token . ''
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            }

            return $whmessage;
        } catch (\Throwable $th) {
        }
    }

    public static function bookingstatusupdatemessage($booking_number, $status, $vendor_id)
    {
        $getbooking = Booking::where('booking_number', $booking_number)->where('vendor_id', $vendor_id)->first();
        $vendordata = User::where('id', $vendor_id)->first();
        $var = ["{booking_no}", "{customer_name}", "{track_booking_url}", "{status}"];
        $newvar = [$booking_number, $getbooking->name, helper::storefront_url($vendordata, 'booking/' . $booking_number), $status];
        $whmessage = str_replace($var, $newvar, str_replace("\r\n", "%0a", @whatsapp_helper::whatsapp_message_config($vendor_id)->status_message));
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_phone_number_id . '/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "messaging_product": "whatsapp",
              "to": "917016428845",
              "text": {
                  "body" : "' . $whmessage . '"
              }
          }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_access_token . ''
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $whmessage;
    }
    public static function orderstatusupdatemessage($order_number, $status, $vendor_id)
    {
        $getorder = Order::where('order_number', $order_number)->where('vendor_id', $vendor_id)->first();
        $vendordata = User::where('id', $vendor_id)->first();
        $var = ["{order_no}", "{customer_name}", "{track_order_url}", "{status}"];
        $newvar = [$order_number, $getorder->user_name, helper::storefront_url($vendordata, 'order/' . $order_number), $status];
        $whmessage = str_replace($var, $newvar, str_replace("\r\n", "%0a", @whatsapp_helper::whatsapp_message_config($vendor_id)->order_status_message));
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_phone_number_id . '/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "messaging_product": "whatsapp",
              "to": "917016428845",
              "text": {
                  "body" : "' . $whmessage . '"
              }
          }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_access_token . ''
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $whmessage;
    }
}
