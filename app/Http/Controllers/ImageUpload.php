<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUpload extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        return  response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('file');
        // $imageName =$image->getClientOriginalName();
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'),$imageName);

        return response()->json(['success'=>"true","file"=>$imageName]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,string $id)
    {


        $fileId = $id;
        $filePath = public_path('images/' . $fileId);
        if (file_exists($filePath)) {
            unlink($filePath);
            return response()->json(['message' => 'File deleted successfully','file' => $fileId]);
        } else {
            return response()->json(['error' => 'File not found','file' => $fileId], 404);
        }
    }

    public function apiDHL()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-mock.dhl.com/mydhlapi/rates',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"customerDetails":{"shipperDetails":{"postalCode":"14800","cityName":"Prague","countryCode":"CZ","provinceCode":"CZ","addressLine1":"addres1","addressLine2":"addres2","addressLine3":"addres3","countyName":"Central Bohemia"},"receiverDetails":{"postalCode":"14800","cityName":"Prague","countryCode":"CZ","provinceCode":"CZ","addressLine1":"addres1","addressLine2":"addres2","addressLine3":"addres3","countyName":"Central Bohemia"}},"accounts":[{"typeCode":"shipper","number":"123456789"}],"productCode":"P","localProductCode":"P","valueAddedServices":[{"serviceCode":"II","localServiceCode":"II","value":100,"currency":"GBP","method":"cash"}],"productsAndServices":[{"productCode":"P","localProductCode":"P","valueAddedServices":[{"serviceCode":"II","localServiceCode":"II","value":100,"currency":"GBP","method":"cash"}]}],"payerCountryCode":"CZ","plannedShippingDateAndTime":"2020-03-24T13:00:00GMT+00:00","unitOfMeasurement":"metric","isCustomsDeclarable":false,"monetaryAmount":[{"typeCode":"declaredValue","value":100,"currency":"CZK"}],"requestAllValueAddedServices":false,"estimatedDeliveryDate":{"isRequested":false,"typeCode":"QDDC"},"getAdditionalInformation":[{"typeCode":"allValueAddedServices","isRequested":true}],"returnStandardProductsOnly":false,"nextBusinessDay":false,"productTypeCode":"all","packages":[{"typeCode":"3BX","weight":10.5,"dimensions":{"length":25,"width":35,"height":15}}]}',
        CURLOPT_HTTPHEADER => array(
            'content-type: application/json',
            'Message-Reference: SOME_STRING_VALUE',
            'Message-Reference-Date: SOME_STRING_VALUE',
            'Plugin-Name: SOME_STRING_VALUE',
            'Plugin-Version: SOME_STRING_VALUE',
            'Shipping-System-Platform-Name: SOME_STRING_VALUE',
            'Shipping-System-Platform-Version: SOME_STRING_VALUE',
            'Webstore-Platform-Name: SOME_STRING_VALUE',
            'Webstore-Platform-Version: SOME_STRING_VALUE',
            'x-version: SOME_STRING_VALUE',
            'Authorization: Basic REPLACE_BASIC_AUTH'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
}
