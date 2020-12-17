<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\SoldierTeam;
use App\Models\Soldier;

class TeamController extends Controller
{
    //

    public function createTeam(Request $request)
	{
		
		$response = "";

		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el equipo
		if($data){

			$team = new Team();

			//TODO: Validar los datos antes de guardar el equipo

			$team->name = $data->name;
			
			if(isset($data->soldier_id)){
				$team->soldier_id = $data->soldier_id;
		   }

		   if(isset($data->mission_id)){
			$team->mission_id = $data->mission_id;
	   		}
            
			try{
				$team->save();
				$response = "Añadido!";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

		}else{
			$response = "No has introducido un equipo válido";
		}

		return response($response);
	}

	public function updateTeam(Request $request, $id){

		$response = "";

		//Buscar el autor por su id

		$team = Team::find($id);

		if($team){

			//Leer el contenido de la petición
			$data = $request->getContent();

			//Decodificar el json
			$data = json_decode($data);

			//Si hay un json válido, buscar el equipo
			if($data){
			
				//TODO: Validar los datos antes de guardar el autor
				$team->name = (isset($data->name) ? $data->name : $team->name);

				try{
					$team->save();
					$response = "OK";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}

			
		}else{
			$response = "No team";
		}
		
		return response($response);
	}

	public function deleteTeam(Request $request, $id){

		$response = "";
		
		//Buscar el autor por su id

		$team = Team::find($id);

		if($team){

			try{
				$team->delete();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}
						
		}else{
			$response = "No team";
		}

		return response($response);
	}

	public function addLeader(Request $request, $id){

		$response = "";
		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		$team = Team::find($id);

		//Si hay un json válido, crear el libro
		if($data&&$team&&Soldier::find($data->leader)){

			//TODO: Validar los datos antes de guardar el libro

			$team->leader_id = (isset($data->leader) ? $data->leader : $team->leader_id);
			
			try{
				$team->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

		}
		return response($response);

	}

	public function addSoldier(Request $request){

		$response = "";
		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el libro
		if($data&&Team::find($data->team)&&Soldier::find($data->soldier)){

			$soldierTeam = new SoldierTeam();

			//TODO: Validar los datos antes de guardar el libro

			$soldierTeam->team_id = $data->team;
			$soldierTeam->soldier_id = $data->soldier;
			try{
				$soldierTeam->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

		}
		return response($response);

	}

}