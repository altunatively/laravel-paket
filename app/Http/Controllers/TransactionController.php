<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Connote;
use App\Models\Koli;
use Illuminate\Http\Request;

use Validator;
use Carbon;

class TransactionController extends Controller
{
    //Global Validation Rules
    protected $rules = [
        'transaction_id' => 'required',
        'customer_name' => 'required',
        'customer_code' => 'required|numeric',
        'transaction_amount' => 'required|numeric',
        'transaction_discount' => 'numeric',
        'transaction_additional_field' => 'max:64',
        'transaction_payment_type' => 'required',
        'transaction_state' => 'required',
        'transaction_code' => 'required',
        'transaction_order' => 'required|numeric',
        'location_id' => 'required',
        'organization_id' => 'required|numeric',
        'transaction_payment_type_name' => 'required',
        'transaction_cash_amount' => 'required|numeric',
        'transaction_cash_change' => 'required|numeric',

        'customer_attribute.Nama_Sales' => 'required',
        'customer_attribute.TOP' => 'required',
        'customer_attribute.Jenis_Pelanggan' => 'required',

        'connote_id' => 'required',

        'origin_data.customer_name' => 'required',
        'origin_data.customer_address' => 'required',
        'origin_data.customer_email' => 'required|email',
        'origin_data.customer_phone' => 'required',
        'origin_data.customer_zip_code' => 'required|numeric|digits:5',
        'origin_data.zone_code' => 'required',
        'origin_data.organization_id' => 'required|numeric',
        'origin_data.location_id' => 'required',

        'destination_data.customer_name' => 'required',
        'destination_data.customer_address' => 'required',
        'destination_data.customer_phone' => 'required|numeric',
        'destination_data.customer_address_detail' => 'required',
        'destination_data.customer_zip_code' => 'required|numeric|digits:5',
        'destination_data.zone_code' => 'required',
        'destination_data.organization_id' => 'required|numeric',
        'destination_data.location_id' => 'required',

        'custom_field.catatan_tambahan' => 'required|max:64',

        'currentLocation.name' => 'required',
        'currentLocation.code' => 'required',
        'currentLocation.type' => 'required',

        'connote.connote_id' => 'required',
        'connote.connote_number' => 'required|numeric',
        'connote.connote_service' => 'required',
        'connote.connote_service_price' => 'required|numeric',
        'connote.connote_amount' => 'numeric',
        'connote.connote_code' => 'max:64',
        'connote.connote_booking_code' => '',
        'connote.connote_order' => 'required|numeric',
        'connote.connote_state' => 'required',
        'connote.connote_state_id' => 'required|numeric',
        'connote.zone_code_from' => 'required',
        'connote.zone_code_to' => 'required',
        'connote.actual_weight' => 'required|numeric|min:1',
        'connote.volume_weight' => 'required|numeric',
        'connote.chargeable_weight' => 'required|numeric|min:1',
        'connote.organization_id' => 'required|numeric',
        'connote.location_id' => 'required',
        'connote.connote_total_package' => 'required|numeric',
        'connote.connote_surcharge_amount' => 'required|numeric',
        'connote.connote_sla_day' => 'required|numeric',
        'connote.location_name' => 'required',
        'connote.location_type' => 'required',
        'connote.source_tariff_db' => 'required',
        'connote.id_source_tariff' => 'required|numeric',

        'koli_data.*.koli_length' => 'required|numeric',
        'koli_data.*.awb_url' => 'required',
        'koli_data.*.koli_chargeable_weight' => 'required|numeric',
        'koli_data.*.koli_width' => 'required|numeric',
        'koli_data.*.koli_height' => 'required|numeric',
        'koli_data.*.koli_description' => 'required',
        'koli_data.*.connote_id' => 'required',
        'koli_data.*.koli_volume' => 'required|numeric',
        'koli_data.*.koli_weight' => 'required|numeric',
        'koli_data.*.koli_id' => 'required',
        'koli_data.*.koli_code' => 'required',
    ];

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        if(count(Transaction::where('transaction_id', '=', $request->transaction_id)->get()) > 0)return response()->json(["error" => "ID Transaksi telah terpakai"], 400);

        Transaction::unguard();

        Transaction::create([
            'transaction_id' => $request->transaction_id,
            'customer_name' => $request->customer_name,
            'customer_code' => $request->customer_code,
            'transaction_amount' => $request->transaction_amount,
            'transaction_discount' => $request->transaction_discount,
            'transaction_additional_field' => $request->transaction_additional_field,
            'transaction_payment_type' => $request->transaction_payment_type,
            'transaction_state' => $request->transaction_state,
            'transaction_code' => $request->transaction_code,
            'transaction_order' => $request->transaction_order,
            'location_id' => $request->location_id,
            'organization_id' => $request->organization_id,
            'transaction_payment_type_name' => $request->transaction_payment_type_name,
            'transaction_cash_amount' => $request->transaction_cash_amount,
            'transaction_cash_change' => $request->transaction_cash_change,

            'nama_sales' => $request->customer_attribute["Nama_Sales"],
            'top' => $request->customer_attribute["TOP"],
            'jenis_pelanggan' => $request->customer_attribute["Jenis_Pelanggan"],

            'connote_id' => $request->connote_id,

            'origin_customer_name' => $request->origin_data["customer_name"],
            'origin_customer_address' => $request->origin_data["customer_address"],
            'origin_customer_email' => $request->origin_data["customer_email"],
            'origin_customer_phone' => $request->origin_data["customer_phone"],
            'origin_customer_address_detail' => $request->origin_data["customer_address_detail"],
            'origin_customer_zip_code' => $request->origin_data["customer_zip_code"],
            'origin_zone_code' => $request->origin_data["zone_code"],
            'origin_organization_id' => $request->origin_data["organization_id"],
            'origin_location_id' => $request->origin_data["location_id"],

            'destination_customer_name' => $request->destination_data["customer_name"],   
            'destination_customer_address' => $request->destination_data["customer_address"],
            'destination_customer_email' => $request->destination_data["customer_email"],
            'destination_customer_phone' => $request->destination_data["customer_phone"],
            'destination_customer_address_detail' => $request->destination_data["customer_address_detail"],
            'destination_customer_zip_code' => $request->destination_data["customer_zip_code"],
            'destination_zone_code' => $request->destination_data["zone_code"],
            'destination_organization_id' => $request->destination_data["organization_id"],
            'destination_location_id' => $request->destination_data["location_id"],

            'catatan_tambahan' => $request->custom_field["catatan_tambahan"],

            'location_name' => $request->currentLocation["name"],
            'location_code' => $request->currentLocation["code"],
            'location_type' => $request->currentLocation["type"],
        ]);
        Transaction::reguard();

        Connote::unguard();

        Connote::create([
            'connote_id' => $request->connote["connote_id"],
            'connote_number' => $request->connote["connote_number"],
            'connote_service' => $request->connote["connote_service"],
            'connote_service_price' => $request->connote["connote_service_price"],
            'connote_amount' => $request->connote["connote_amount"],
            'connote_code' => $request->connote["connote_code"],
            'connote_booking_code' => $request->connote["connote_booking_code"],
            'connote_order' => $request->connote["connote_order"],
            'connote_state' => $request->connote["connote_state"],
            'connote_state_id' => $request->connote["connote_state_id"],
            'zone_code_from' => $request->connote["zone_code_from"],
            'zone_code_to' => $request->connote["zone_code_to"],
            'surcharge_amount' => $request->connote["surcharge_amount"],
            'transaction_id' => $request->connote["transaction_id"],
            'actual_weight' => $request->connote["actual_weight"],
            'volume_weight' => $request->connote["volume_weight"],
            'chargeable_weight' => $request->connote["chargeable_weight"],
            'organization_id' => $request->connote["organization_id"],
            'location_id' => $request->connote["location_id"],
            'connote_total_package' => $request->connote["connote_total_package"],
            'connote_surcharge_amount' => $request->connote["connote_surcharge_amount"],
            'connote_sla_day' => $request->connote["connote_sla_day"],
            'location_name' => $request->connote["location_name"],
            'location_type' => $request->connote["location_type"],
            'source_tariff_db' => $request->connote["source_tariff_db"],
            'id_source_tariff' => $request->connote["id_source_tariff"],
        ]);

        Connote::reguard();

        $kolidata = [];
        Koli::unguard();
        foreach($request->koli_data as $d)
        {
            $surcharge = "";
            $awb = "";
            $harga = 0;
            if(isset($d["koli_surcharge"]))$surcharge = implode("||", $d["koli_surcharge"]);
            foreach($d["koli_custom_field"] as $x)
            {
                if(isset($x["awb_sicepat"]))$awb = $x["awb_sicepat"];
                if(isset($x["harga_barang"]))$harga = $x["harga_barang"];
            }
            $kolidata[] = [
                'koli_length' => $d["koli_length"],
                'awb_url' => $d["awb_url"],
                'koli_chargeable_weight' => $d["koli_chargeable_weight"],
                'koli_width' => $d["koli_width"],
                'koli_surcharge' => $surcharge,
                'koli_height' => $d["koli_height"],
                'koli_description' => $d["koli_description"],
                'koli_formula_id' => $d["koli_formula_id"],
                'connote_id' => $d["connote_id"],
                'koli_volume' => $d["koli_volume"],
                'koli_weight' => $d["koli_weight"],
                'koli_id' => $d["koli_id"],
                'koli_code' => $d["koli_code"],
                'awb_sicepat' => $awb,
                'harga_barang' => $harga,
                'created_at' =>  \Carbon\Carbon::now(), 
                'updated_at' => \Carbon\Carbon::now(),  
            ];
        }
        if(count($kolidata))Koli::insert($kolidata);
        return response()->json(["success" => "Berhasil membuat data transaksi!"], 200);
    }

    public function put(Request $request, $id)
    {
        $trxid = Transaction::where("transaction_id", "=", $id)->first();
        if(empty($trxid))return response()->json(["error" => "ID Transaksi tidak ditemukan"], 404);
        $this->delete($id);
        $this->store($request);
        return response()->json(["success" => "Berhasil mengupdate data transaksi!"], 200);
    }

    public function delete($id)
    {
        $trxid = Transaction::where("transaction_id", "=", $id)->first();
        if(empty($trxid))return response()->json(["error" => "ID Transaksi tidak ditemukan"], 404);
        Connote::where('transaction_id', "=", $trxid->transaction_id)->delete();
        Koli::where('connote_id', "=", $trxid->connote_id)->delete();
        $trxid->delete();
        return response()->json(["success" => "Berhasil menghapus data transaksi!"], 200);
    }

    public function show($id, $forAll = 0)
    {
        $trxid = Transaction::where("transaction_id", "=", $id)->first();
        if(empty($trxid))return response()->json(["error" => "ID Transaksi tidak ditemukan"], 404);

        $con = Connote::where('connote_id', "=", $trxid->connote_id)->first();
        $con_history = array();
        if(isset($con["history"]))$con_history = explode("||", $con["history"]);

        $koli = Koli::where('connote_id', "=", $trxid->connote_id)->get();
        $koli_array = [];
        foreach($koli as $d)
        {
            $koli_array[] = [
                'koli_length' => $d["koli_length"],
                'awb_url' => $d["awb_url"],
                'created_at' => $d["created_at"],
                'koli_chargeable_weight' => $d["koli_chargeable_weight"],
                'koli_width' => $d["koli_width"],
                'koli_surcharge' => $d["koli_surcharge"],
                'koli_height' => $d["koli_height"],
                'updated_at' => $d["updated_at"],
                'koli_description' => $d["koli_description"],
                'koli_formula_id' => $d["koli_formula_id"],
                'connote_id' => $d["connote_id"],
                'koli_volume' => $d["koli_volume"],
                'koli_weight' => $d["koli_weight"],
                'koli_id' => $d["koli_id"],
                'koli_custom_field' => [
                    'awb_sicepat' => $d["awb"],
                    'harga_barang' => $d["harga"]
                ],
                'koli_code' => $d["koli_code"],
            ];
        }
        $array = [
            'transaction_id' => $trxid->transaction_id,
            'customer_name' => $trxid->customer_name,
            'customer_code' => $trxid->customer_code,
            'transaction_amount' => $trxid->transaction_amount,
            'transaction_discount' => $trxid->transaction_discount,
            'transaction_additional_field' => $trxid->transaction_additional_field,
            'transaction_payment_type' => $trxid->transaction_payment_type,
            'transaction_state' => $trxid->transaction_state,
            'transaction_code' => $trxid->transaction_code,
            'transaction_order' => $trxid->transaction_order,
            'location_id' => $trxid->location_id,
            'organization_id' => $trxid->organization_id,
            'created_at' => $trxid->created_at,
            'updated_at' => $trxid->updated_at,
            'transaction_payment_type_name' => $trxid->transaction_payment_type_name,
            'transaction_cash_amount' => $trxid->transaction_cash_amount,
            'transaction_cash_change' => $trxid->transaction_cash_change,
            'customer_attribute' => [
                'Nama_Sales' => $trxid->nama_sales,
                'TOP' => $trxid->top,
                'Jenis_Pelanggan' => $trxid->jenis_pelanggan,
            ],
            'connote' => [
                'connote_id' => $con->connote_id,
                'connote_number' => $con->connote_number,
                'connote_service' => $con->connote_service,
                'connote_service_price' => $con->connote_service_price,
                'connote_amount' => $con->connote_amount,
                'connote_code' => $con->connote_code,
                'connote_booking_code' => $con->connote_booking_code,
                'connote_order' => $con->connote_order,
                'connote_state' => $con->connote_state,
                'connote_state_id' => $con->connote_state_id,
                'zone_code_from' => $con->zone_code_from,
                'zone_code_to' => $con->zone_code_to,
                'surcharge_amount' => $con->surcharge_amount,
                'transaction_id' => $con->transaction_id,
                'actual_weight' => $con->actual_weight,
                'volume_weight' => $con->volume_weight,
                'chargeable_weight' => $con->chargeable_weight,
                'created_at' => $con->created_at,
                'updated_at' => $con->updated_at,
                'organization_id' => $con->organization_id,
                'location_id' => $con->location_id,
                'connote_total_package' => $con->connote_total_package,
                'connote_surcharge_amount' => $con->connote_surcharge_amount,
                'connote_sla_day' => $con->connote_sla_day,
                'location_name' => $con->location_name,
                'location_type' => $con->location_type,
                'source_tariff_db' => $con->source_tariff_db,
                'id_source_tariff' => $con->id_source_tariff,
                'pod' => $con->pod,
                'history' => $con_history,   
            ],
            'connote_id' => $trxid->connote_id,
            'origin_data' => [
                "customer_name" => $trxid->origin_customer_name,
                "customer_address" => $trxid->origin_customer_address,
                "customer_email" => $trxid->origin_customer_email,
                "customer_phone" => $trxid->origin_customer_phone,
                "customer_address_detail" => $trxid->origin_customer_address_detail,
                "customer_zip_code" => $trxid->origin_customer_zip_code,
                "zone_code" => $trxid->origin_zone_code,
                "organization_id" => $trxid->origin_organization_id,
                "location_id" => $trxid->origin_location_id,
            ],
            'destination_data' => [
                "customer_name" => $trxid->destination_customer_name,
                "customer_address" => $trxid->destination_customer_address,
                "customer_email" => $trxid->destination_customer_email,
                "customer_phone" => $trxid->destination_customer_phone,
                "customer_address_detail" => $trxid->destination_customer_address_detail,
                "customer_zip_code" => $trxid->destination_customer_zip_code,
                "zone_code" => $trxid->destination_zone_code,
                "organization_id" => $trxid->destination_organization_id,
                "location_id" => $trxid->destination_location_id,
            ],
            'koli_data' => $koli_array,
            'custom_field' => [
                "catatan_tambahan" => $trxid->catatan_tambahan,
            ],
            'currentLocation' => [
                "name" => $trxid->location_name,
                "code" => $trxid->location_code,
                "type" => $trxid->location_type,
            ],
        ];
        if($forAll)return $array;
        return response()->json($array);
    }

    public function showAll()
    {
        $data = Transaction::orderBy('created_at','DESC')->get('transaction_id');
        $array = [];
        foreach($data as $d)
        {
            $array[] = $this->show($d->transaction_id, 1);
        }
        return response()->json($array);
    }
    
    public function patch(Request $request, $id)
    {
        //Special Rules: Removing required criteria
        $special_rules = [
            'customer_code' => 'numeric',
            'transaction_amount' => 'numeric',
            'transaction_discount' => 'numeric',
            'transaction_additional_field' => 'max:64',
            'transaction_order' => 'numeric',
            'organization_id' => 'numeric',
            'transaction_cash_amount' => 'numeric',
            'transaction_cash_change' => 'numeric',
            
            'origin_data.customer_zip_code' => 'numeric|digits:5',
            'origin_data.customer_email' => 'email',
            'origin_data.organization_id' => 'numeric',
            
            'destination_data.customer_phone' => 'numeric',
            'destination_data.customer_zip_code' => 'numeric|digits:5',
            'destination_data.organization_id' => 'numeric',
            
            'custom_field.catatan_tambahan' => 'max:64',
    
            'connote.connote_number' => 'numeric',
            'connote.connote_service_price' => 'numeric',
            'connote.connote_amount' => 'numeric',
            'connote.connote_code' => 'max:64',
            'connote.connote_order' => 'numeric',
            'connote.connote_state_id' => 'numeric',
            'connote.actual_weight' => 'numeric|min:1',
            'connote.volume_weight' => 'numeric',
            'connote.chargeable_weight' => 'numeric|min:1',
            'connote.organization_id' => 'numeric',
            'connote.connote_total_package' => 'numeric',
            'connote.connote_surcharge_amount' => 'numeric',
            'connote.connote_sla_day' => 'numeric',
            'connote.id_source_tariff' => 'numeric',
            
            'koli_data.*.koli_length' => 'numeric',
            'koli_data.*.koli_chargeable_weight' => 'numeric',
            'koli_data.*.koli_width' => 'numeric',
            'koli_data.*.koli_height' => 'numeric',
            'koli_data.*.koli_volume' => 'numeric',
            'koli_data.*.koli_weight' => 'numeric',
        ];
        $data = $request->all();
        $validator = Validator::make($data, $special_rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $transaction = [
            'transaction_id' => $request->transaction_id,
            'customer_name' => $request->customer_name,
            'customer_code' => $request->customer_code,
            'transaction_amount' => $request->transaction_amount,
            'transaction_discount' => $request->transaction_discount,
            'transaction_additional_field' => $request->transaction_additional_field,
            'transaction_payment_type' => $request->transaction_payment_type,
            'transaction_state' => $request->transaction_state,
            'transaction_code' => $request->transaction_code,
            'transaction_order' => $request->transaction_order,
            'location_id' => $request->location_id,
            'organization_id' => $request->organization_id,
            'transaction_payment_type_name' => $request->transaction_payment_type_name,
            'transaction_cash_amount' => $request->transaction_cash_amount,
            'transaction_cash_change' => $request->transaction_cash_change,
        
            'connote_id' => $request->connote_id,
        ];

        if(isset($request->customer_attribute))
        {
            $transaction += [
                'nama_sales' => $request->customer_attribute["Nama_Sales"],
                'top' => $request->customer_attribute["TOP"],
                'jenis_pelanggan' => $request->customer_attribute["Jenis_Pelanggan"],
            ];
        }

        if(isset($request->origin_data))
        {
            $transaction += [
                'origin_customer_name' => $request->origin_data["customer_name"],
                'origin_customer_address' => $request->origin_data["customer_address"],
                'origin_customer_email' => $request->origin_data["customer_email"],
                'origin_customer_phone' => $request->origin_data["customer_phone"],
                'origin_customer_address_detail' => $request->origin_data["customer_address_detail"],
                'origin_customer_zip_code' => $request->origin_data["customer_zip_code"],
                'origin_zone_code' => $request->origin_data["zone_code"],
                'origin_organization_id' => $request->origin_data["organization_id"],
                'origin_location_id' => $request->origin_data["location_id"],
            ];
        }

        if(isset($request->destination_data))
        {
            $transaction += [
                'destination_customer_name' => $request->destination_data["customer_name"],   
                'destination_customer_address' => $request->destination_data["customer_address"],
                'destination_customer_email' => $request->destination_data["customer_email"],
                'destination_customer_phone' => $request->destination_data["customer_phone"],
                'destination_customer_address_detail' => $request->destination_data["customer_address_detail"],
                'destination_customer_zip_code' => $request->destination_data["customer_zip_code"],
                'destination_zone_code' => $request->destination_data["zone_code"],
                'destination_organization_id' => $request->destination_data["organization_id"],
                'destination_location_id' => $request->destination_data["location_id"],
            ];
        }

        if(isset($request->currentLocation))
        {
            $transaction += [
                'location_name' => $request->currentLocation["name"],
                'location_code' => $request->currentLocation["code"],
                'location_type' => $request->currentLocation["type"],
            ];
        }

        if(isset($request->custom_field))
        {
            $transaction += [
                'catatan_tambahan' => $request->custom_field["catatan_tambahan"],
            ];
        }

        $transaction = $this->array_remove_null($transaction);
        Transaction::unguard();
        $trx = Transaction::where('transaction_id', '=', $id)->first()->update($transaction);
        Transaction::reguard();

        if(isset($request->connote))
        {
            $connote = [
                'connote_id' => $request->connote["connote_id"],
                'connote_number' => $request->connote["connote_number"],
                'connote_service' => $request->connote["connote_service"],
                'connote_service_price' => $request->connote["connote_service_price"],
                'connote_amount' => $request->connote["connote_amount"],
                'connote_code' => $request->connote["connote_code"],
                'connote_booking_code' => $request->connote["connote_booking_code"],
                'connote_order' => $request->connote["connote_order"],
                'connote_state' => $request->connote["connote_state"],
                'connote_state_id' => $request->connote["connote_state_id"],
                'zone_code_from' => $request->connote["zone_code_from"],
                'zone_code_to' => $request->connote["zone_code_to"],
                'surcharge_amount' => $request->connote["surcharge_amount"],
                'transaction_id' => $request->connote["transaction_id"],
                'actual_weight' => $request->connote["actual_weight"],
                'volume_weight' => $request->connote["volume_weight"],
                'chargeable_weight' => $request->connote["chargeable_weight"],
                'organization_id' => $request->connote["organization_id"],
                'location_id' => $request->connote["location_id"],
                'connote_total_package' => $request->connote["connote_total_package"],
                'connote_surcharge_amount' => $request->connote["connote_surcharge_amount"],
                'connote_sla_day' => $request->connote["connote_sla_day"],
                'location_name' => $request->connote["location_name"],
                'location_type' => $request->connote["location_type"],
                'source_tariff_db' => $request->connote["source_tariff_db"],
                'id_source_tariff' => $request->connote["id_source_tariff"],
            ];
            $connote = $this->array_remove_null($connote);
            Connote::unguard();
            $con = Connote::where('transaction_id', '=', $id)->first()->update($connote);
            Connote::reguard();
        }

        
        if(isset($request->koli_data))
        {
            Koli::unguard();
            foreach($request->koli_data as $d)
            {
                $surcharge = "";
                $awb = "";
                $harga = 0;
                if(isset($d["koli_surcharge"]))$surcharge = implode("||", $d["koli_surcharge"]);
                foreach($d["koli_custom_field"] as $x)
                {
                    if(isset($x["awb_sicepat"]))$awb = $x["awb_sicepat"];
                    if(isset($x["harga_barang"]))$harga = $x["harga_barang"];
                }
                $koli = [
                    'koli_length' => $d["koli_length"],
                    'awb_url' => $d["awb_url"],
                    'koli_chargeable_weight' => $d["koli_chargeable_weight"],
                    'koli_width' => $d["koli_width"],
                    'koli_surcharge' => $surcharge,
                    'koli_height' => $d["koli_height"],
                    'koli_description' => $d["koli_description"],
                    'koli_formula_id' => $d["koli_formula_id"],
                    'connote_id' => $d["connote_id"],
                    'koli_volume' => $d["koli_volume"],
                    'koli_weight' => $d["koli_weight"],
                    'koli_id' => $d["koli_id"],
                    'koli_code' => $d["koli_code"],
                    'awb_sicepat' => $awb,
                    'harga_barang' => $harga,
                    'created_at' =>  \Carbon\Carbon::now(), 
                    'updated_at' => \Carbon\Carbon::now(),  
                ];
                $koli = $this->array_remove_null($koli);
                $con = Koli::where('connote_id', '=', $request->connote_id)->first()->update($koli);
            }
            Koli::reguard();
        }
        return response()->json(["success" => "Berhasil memodifikasi data transaksi!"], 200);
    }
    
    public function array_remove_null($item)
    {
        if (!is_array($item)) {
            return $item;
        }
    
       return collect($item)
            ->reject(function ($item) {
                return is_null($item);
            })
            ->flatMap(function ($item, $key) {
    
                return is_numeric($key)
                    ? [$this->array_remove_null($item)]
                    : [$key => $this->array_remove_null($item)];
            })
            ->toArray();
    }
}
