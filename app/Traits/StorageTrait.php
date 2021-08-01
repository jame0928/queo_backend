<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;

trait StorageTrait
{            
    /**
     * Returns a year / month / week structure, used to generate directories
     *
     * @return void
     */
    public function pathStorage() {
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $week = '';
        switch ($day) {
                case $day > 0 && $day <= 7: {
                    $week .= 'week1';
                    break;
                }
                case $day > 7 && $day <= 14: {
                    $week .= 'week2';
                    break;
                }
                case $day > 14 && $day <= 21: {
                    $week .= 'week3';
                    break;
                }
                case $day > 21 && $day <= 31: {
                    $week .= 'week4';
                    break;
                }
        }
        $path = "{$year}/{$month}/{$week}";

        return $path;

   }
    
    /**
     * Method to save a file in storage
     *
     * @param  mixed $file
     * @param  mixed $options
     * @return array 
     */
    function putFile($file,$options = []){

        try {
            if(!$file){
                throw new Exception('No se recibió un archivo!');
            }

            $options = array_merge([
                'path' => '',//Folder where the file will rest
                'withPathStorage' => true,//If sent to true, the folder structure year / month / week is added to the path parameter
                'name' => '',//Name that you want to give the file, if it is not sent, one is assigned by default
            ],$options);

            if($options['withPathStorage']){
                $options['path'] .= '/'.$this->pathStorage();
            }

            if($options['name'] != ''){
                $path = Storage::putFileAs($options['path'], $file,$options['name']);
            }else{
                $path = Storage::putFile($options['path'], $file);
            }
            $url = Storage::url($path);
            $real_name = $file->getClientOriginalName();

            return [
                'path' => $path,
                'url' => $url,
                'real_name' => $real_name
            ];
        } catch (Exception $e) {
            throw new Exception('Error al intentar guardar el archivo!'.$e->getMessage());
        }
    }

    
    /**
     * method to download a file
     *
     * @param  mixed $file
     * @param  mixed $real_name
     * @return void
     */
    public function downloadFileStorage($file,$real_name = ''){
        $file = Storage::path($file);
        return response()->download($file,$real_name);
    }

    
}
