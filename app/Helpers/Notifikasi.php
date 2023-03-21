<?php

function send_wa($no_hp, $pesan)
{

    try {
        $message = 'INFO! HR System:
------------------------------------------------
' . $pesan . '
------------------------------------------------
Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem
Mohon untuk tidak dibalas karena tidak akan direspon oleh sistem
------------------------------------------------';

        $no_hp = nomor_wa($no_hp);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://web.wa-gateway.site/api/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'name' => 'Andang',
                'receiver' => $no_hp,
                'message' => $message
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    } catch (\Throwable $th) {
        echo $th;
    }
}

function nomor_wa($telepon)
{
    $telepon = str_replace(" ", "", str_replace("-", "", $telepon));

    if (strpos($telepon, '/') !== false) {
        $ex = explode('/', $telepon);
        $telepon = $ex[0];
    }

    return $telepon;
}

function telat_sore($tanggalIn, $jam_tepat_pulang)
{
    if ($tanggalIn != "") {
        // Pengurangan Cepat Pulang Selain Jumat
        if (strtotime($tanggalIn) < strtotime(date("Y-m-d", strtotime($tanggalIn)) . $jam_tepat_pulang)) {
            $dateTimeObject1 = date_create(date("Y-m-d", strtotime($tanggalIn)) . " " . $jam_tepat_pulang);
            $dateTimeObject2 = date_create($tanggalIn);

            $difference = date_diff($dateTimeObject1, $dateTimeObject2);

            $telat_sore = $difference->h * 60;
            $telat_sore += $difference->i;
            return $telat_sore;
        }
        return 0;
    }
}
