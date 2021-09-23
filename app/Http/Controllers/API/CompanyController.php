<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        return response()->json(['status' => 'success', 'data' => $companies], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:companies,name,NULL,id,deleted_at,NULL',
            'email' => 'required|email|unique:companies,email,NULL,id,deleted_at,NULL',
            'website' => 'required|url|unique:companies,website,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('logo')) {
                $file = $request->logo;
                $data = getimagesize($file);
                $width = $data[0];
                if($width < 100){
                    return response()->json(['status' => 'success', 'message' => 'Image should be minimum 100*100'], 409);
                }
                $height = $data[1];
                if($height < 100){
                    return response()->json(['status' => 'error', 'message' => 'Image should be minimum 100*100'], 409);
                }
                $logoName = time() .'.' . $file->getClientOriginalExtension();
                $file->move(public_path('company_logo'), $logoName);
            }
            $company = Company::create([
                'name' => $request->name,
                'email' => $request->email,
                'logo' => $logoName ?? NULL,
                'website' => $request->website,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return response()->json(['status' => 'success', 'data' => $company], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if(isset($company)) {
            return response()->json(['status' => 'success', 'data' => $company], 200);
        }
        return response()->json(['status' => 'error'], 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|string|unique:companies,name,$company->id,id,deleted_at,NULL",
            'email' => "required|email|unique:companies,email,$company->id,id,deleted_at,NULL",
            'website' => "required|url|unique:companies,website,$company->id,id,deleted_at,NULL",
            'logo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {

            $company->update([
                'name' => $request->name,
                'email' => $request->email,
                'website' => $request->website,
            ]);
            if ($request->hasFile('logo')) {
                $file = $request->logo;
                $logoName = time() .'.' . $file->getClientOriginalExtension();
                $file->move(public_path('company_logo'), $logoName);
                $company->logo = $logoName;
                $company->save();
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return response()->json(['status' => 'success', 'data' => $company], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        DB::beginTransaction();
        try {
            $company->delete();
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }
    }
}
