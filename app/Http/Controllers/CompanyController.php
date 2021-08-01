<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Company;

use App\Http\Requests\CompanyStorageRequest;
use App\Traits\StorageTrait;

class CompanyController extends BaseController
{

  use StorageTrait;

  /**
   * Display a listing of the resource.
   *
	 * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {      
      $collection = new Company();      

      $collection = $collection
      ->when($request->name,function($query,$name){
        $query->where('name', 'like', '%'.$name.'%');
      })
      ->when($request->email,function($query,$email){
        $query->where('email', 'like', '%'.$email.'%');
      })
      ->when($request->website,function($query,$website){
        $query->where('website', 'like', '%'.$website.'%');
      });
     

      //Order collection action
      $collection = $collection->orderBy(($request->sortActive ?? 'name'),($request->sortDirection ?? 'Asc'));     

      //Paginate collection
      $response = $this->paginate(array(
          "collection" => $collection
      ),$request);
      
      return $response;
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Requests\CompanyStorageRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CompanyStorageRequest $request)
  {
    return $this->save($request);
  }



  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  	$model = Company::find($id);    
    return $model; 
  }

 

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Requests\CompanyStorageRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(CompanyStorageRequest $request, $id)
  {
    return $this->save($request,$id);        
  }




  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy( $id)
  {
      $oCompany = Company::find($id);
      
      if($oCompany->delete()){
          return $this->responseSuccess(['message' => 'Registro eliminado exitosamente']);
      }else{
          return $this->responseError();
      }
  }




  /**
     * Create or Update resource in storage.
     *
     * @param  App\Http\Requests\CompanyStorageRequest $request
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    private function save($request,$id = 0){

      DB::beginTransaction();

      try {
          if($id > 0){
              $model = Company::find($id);    
          }else{
              $model = new Company();
          }
          
          
          if ($request->hasFile('file')) {

            $dataStorage = $this->putFile($request->file('file'),['path' => 'logos']);
            $request->merge([
                'logo' => $dataStorage['url'],
            ]);
        }

          $model->fill($request->input());

          $model->save();

          DB::commit();

          return $model;
      }
      catch (\Illuminate\Database\QueryException $e) {
          DB::rollBack();          
          return $this->responseError();
      }
  }  
  
}
