<?php
namespace App\Http;

class MessageService
{

    /**
     * Sending OTP to a mobile
     */
    public static function sendOtp($mobile)
    {
        $curl = curl_init();

        $authKey = config("app_config.OTP.AUTH_KEY");
        $message = urlencode(config("app_config.OTP.MESSAGE"));
        $sender = config("app_config.OTP.SENDER");
        $curlUrl = "http://control.msg91.com/api/sendotp.php?otp_length=6&authkey=$authKey&message=$message&sender=$sender&mobile=$mobile";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $curlUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    /**
     * Verifying OTP for a mobile
     */
    public static function verifyOtp($otpData)
    {
        $curl = curl_init();

        $authKey = config("app_config.OTP.AUTH_KEY");
        $mobile = decrypt($otpData['mobile']);
        $otp = $otpData['otp'];

        $curlUrl = "https://control.msg91.com/api/verifyRequestOTP.php?authkey=$authKey&mobile=$mobile&otp=$otp";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $curlUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
}
