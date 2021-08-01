<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Employee;

use App\Http\Requests\EmployeeStorageRequest;

class EmployeeController extends BaseController
{

  /**
   * Display a listing of the resource.
   *
	 * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {      
      $collection = new Employee();      

      $collection = $collection
      ->with(['company'])
      ->when($request->first_name,function($query,$first_name){
        $query->where('first_name', 'like', '%'.$first_name.'%');
      })
      ->when($request->last_name,function($query,$last_name){
        $query->where('last_name', 'like', '%'.$last_name.'%');
      })
      ->when($request->email,function($query,$email){
        $query->where('email', 'like', '%'.$email.'%');
      })
      ->when($request->phone,function($query,$phone){
        $query->where('phone', 'like', '%'.$phone.'%');
      })
      ->when($request->company,function($query,$company){
        $query->whereHas('company', function($query) use($company){
          $query->Search($company);
        });
      });
     

      //Order collection action
      $collection = $collection->orderBy(($request->sortActive ?? 'first_name'),($request->sortDirection ?? 'Asc'));     

      //Paginate collection
      $response = $this->paginate(array(
          "collection" => $collection
      ),$request);
      
      return $response;
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Requests\EmployeeStorageRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(EmployeeStorageRequest $request)
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
  	$model = Employee::find($id);    
    return $model; 
  }

 

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Requests\EmployeeStorageRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(EmployeeStorageRequest $request, $id)
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
      $oEmployee = Employee::find($id);
      
      if($oEmployee->delete()){
          return $this->responseSuccess(['message' => 'Registro eliminado exitosamente']);
      }else{
          return $this->responseError();
      }
  }




  /**
     * Create or Update resource in storage.
     *
     * @param  App\Http\Requests\EmployeeStorageRequest $request
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    private function save($request,$id = 0){

      DB::beginTransaction();

      try {
          if($id > 0){
              $model = Employee::find($id);    
          }else{
              $model = new Employee();
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
