<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller {

    public function index(){
        $transaksiPending['listPending'] = Transaksi::whereStatus("MENUGGU")->get();

        $transaksiSelesai['listDone'] = Transaksi::where("Status", "NOT LIKE", "%MENUGGU%")->get();

        return view('transaksi')->with($transaksiPending)->with($transaksiSelesai);
    }

    public function batal($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi dibatalkan', "Transaksi produk ". $transaksi->details[0]->produk->name ." berhasil dibatalkan", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "BATAL"
        ]);
        return redirect('transaksi');
    }

    public function confirm($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Diproses', "Transaksi produk ". $transaksi->details[0]->produk->name ." sedang diproses", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "PROSES"
        ]);
        return redirect('transaksi');
    }

    public function kirim($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Dikirim', "Transaksi produk ". $transaksi->details[0]->produk->name ." sedang dalam pengiriman", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "DIKIRIM"
        ]);
        return redirect('transaksi');
    }

    public function selesai($id){
        $transaksi = Transaksi::with(['details.produk', 'user'])->where('id', $id)->first();
        $this->pushNotif('Transaksi Selesai', "Transaksi produk ". $transaksi->details[0]->produk->name ." sudah selesai", $transaksi->user->fcm);
        $transaksi->update([
            'status' => "SELESAI"
        ]);
        return redirect('transaksi');
    }

    public function pushNotif($title, $message, $mFcm) {

        $mData = [
            'title' => $title,
            'body' => $message
        ];

        $fcm[] = "$mFcm";

        $payload = [
            'registration_ids' => $fcm,
            'notification' => $mData
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: key=AAAAYN3IIIA:APA91bGPStYaSqsCCdtEvENi5zAOk6gEFHr6rqDdtcM0uMSPLpqsQLwduaYGrxEr6IEsQQJxFEIRTjMIcDCD_QTiAfPXte0E7YWjpEts0LDNUAcSRUZgVSRm6-hPxm4MI6fWdwXV9h6h"
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = [
            'success' => 1,
            'message' => "Push notif success",
            'data' => $mData,
            'firebase_response' => json_decode($response)
        ];
        return $data;
    }
}
