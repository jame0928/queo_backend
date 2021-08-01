<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    
    /**
     * It allows to return the errors of the application in an organized way
     *
     * @param  array $aOptions
     * @return void
     */
    public function responseError($aOptions = []){

    	$aDefaultOptions = array(
			"json" => true,
			"type" => "error",
			"cod" => 500,
            "message" => null
		);

		$aOptions = array_merge($aDefaultOptions,$aOptions);

		$aMessages =  [
          404 => "Recurso no encontado",
          500 => "Se ha producido un error durante la ejecución",
          551 => "No se pudo guardar el registro!",
          552 => "El registro ya existe!",
          553 => "No se pudo subir el archivo!",
        ];
        if(empty($aOptions['message'])){
            if(empty( $aMessages[$aOptions["cod"]]) ){
                $message = "Sin mensaje especifico";
            }else{
                $message = $aMessages[$aOptions["cod"]];
            }
        }else{
            $message = $aOptions['message'];
        }
		if($aOptions["json"]){

			return Response::json(
                ["messages" => [
                      [
                        "message" => $message,
                        "type" => $aOptions["type"]
                      ]
                    ]
                ],
                $aOptions["cod"]
            );
		}

    	return [
            "message" => $aMessages[$aOptions["cod"]],
        		"type" => $aOptions["type"]
        ];
    }


    /**
     * Receive an array and response code and return a Response instance
     *
     * @param  array $data
     * @param  int $cod
     * @return void
     */
    public function responseSuccess($data = [],$cod = 200){
        return Response::json($data,$cod,[],JSON_NUMERIC_CHECK);
    }


    /**
     * Receive an array of options within which to send a collection to be transformed 
     * to return the records in a paginated way if the currentPage and perPage parameters 
     * are received otherwise return the complete collection
     *
     * @param  mixed $aOptions
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function paginate($aOptions = [],$request){
        $aDefaultOptions = array(
            "collection" => null,
            "withTotal" => false,
            "perPage" => $request->input('perPage', ''),
            "currentPage" => $request->input('currentPage', ''),
            "return" => "json"
        );

        $aOptions = array_merge($aDefaultOptions,$aOptions);

        if($aOptions['currentPage'] < 1){
            $aOptions['currentPage'] = 1;
        }
        
        if($aOptions['currentPage']!= '' && $aOptions['perPage']  != '' ){

            $paginateData = $aOptions["collection"]->paginate($perPage = $aOptions['perPage'], $columns = ['*'], $pageName = 'currentPage');
            $aOptions["collection"] = $paginateData->items();
            $response["currentPage"] = $aOptions['currentPage'];
            $response["perPage"] = $aOptions['perPage'];
            $response["totalItems"] = $paginateData->total();

        }else{
                                    
            $aOptions["collection"] = $aOptions["collection"]->get();
            $response["totalItems"] = count($aOptions["collection"]);

        }

        $response["data"] = $aOptions["collection"];
       
        
        switch($aOptions['return']){
            case 'array':{
                return $response;
            }
            break;
            case 'json':{
                return $this->responseSuccess($response);
            }
            break;
        }
    }
}
