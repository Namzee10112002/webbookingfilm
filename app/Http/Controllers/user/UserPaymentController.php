<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class UserPaymentController
{
public static function callMomoPayment($amount)
{
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    $orderInfo = "Thanh toán đơn hàng";
    $orderId = time() . "";
    $redirectUrl = route('payment.momo.return');
    $ipnUrl = route('payment.momo.return');
    $extraData = "";
    $requestId = time() . "";

    $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'extraData' => $extraData,
        'requestType' => 'captureWallet',
        'signature' => $signature
    ];

    $response = Http::post($endpoint, $data);
    return $response->json();
}
public function momoReturn(Request $request)
{
    if ($request->resultCode == 0) {
        return redirect()->route('home')->with('success', 'Thanh toán MOMO thành công!');
    } else {
        return redirect()->route('cart.index')->with('error', 'Thanh toán MOMO thất bại!');
    }
}
}
