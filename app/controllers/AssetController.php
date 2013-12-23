<?php

class AssetController extends \BaseController {

	public function uploadReplay($gid) {
		if (!Input::hasFile('replay'))
			return Response::json(array("status" => 1, "message" => "You didn't upload a replay"));
		
		$file = Input::file('replay');
		$data = base64_encode(file_get_contents($file->getRealPath()));
		if (!$data) {
			return Response::json(array('status' => 1, "message" => "Error encoding replay"));
		}
		$post = array("fileName" => Input::file('replay')->getClientOriginalName(),
		              "fileContent" => $data,
					  "token" => Config::get('app.ggtrackertoken'));
		
		$ch = curl_init("http://ggtracker.com/replays/drop");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		if (!$response) {
			return Response::json(array('status' => 1, 'message' => "Posting to GGTracker failed. Try again."));
		}
		
		$uploadResult = new SimpleXMLElement($response);
		$replayUrl = (string)$uploadResult->replayUrl;

		$game = Game::find($gid);
		$game->replay_url = $replayUrl;
		$game->save();
	
		$url_array = explode("/", $replayUrl);
		$match_id = $url_array[count($url_array) -1];
		$url = "http://api.ggtracker.com/api/v1/matches/" . $match_id . ".json";
		sleep(4);
		$matchData = json_decode(file_get_contents($url), true);
		$bnet_ids = array();
		
		foreach ($matchData['entities'] as $player) {
			$bnet_ids[] = $player['identity']['bnet_id'];
		}
		
		if(!$game->setActives($bnet_ids)) {
			return Response::json(array('status' => 2, 
			                            'message' => 'Both players not found in replay, manual override engaged', 
										'replay_url' => $replayUrl));
		};

		$winner_bnet_id = $bnet_ids[$matchData['winning_team'] - 1];
		
		if ($game->playerone->bnet_id == $winner_bnet_id) {
			$game->reportWinner($game->player1);
		} elseif ($game->playertwo->bnet_id == $winner_bnet_id) {
			$game->reportWinner($game->player2);
		} else {
			return Response::json(array('status' => 2, 
			                            'message' => 'Could not determine winner, manual override engaged',
										'replay_url' => $replayUrl));
		}

		return Response::json(array('status' => 3, 
		                            'replay_url' => $replayUrl, 'message' => 'Please ensure this information is correct'));
	}
	
	public function uploadProfileImage($id) {
		$user = User::find($id);
		if (!Input::hasFile('image')) 
			return Response::json(array('status' => 1, 'message' => 'You did not choose an image'));
		$file = Input::file('image');
		$path = $file->getRealPath();
		
		$img = Image::make($path);
		$arr = explode(".", $file->getClientOriginalName());
		$ext = array_pop($arr);
		$img->resize(100, 100, true);
		$img->save('img/uid_' . $id . "." . $ext);

		$user->img_url = "/img/uid_" . $id . "." . $ext;
		$user->save();

		return Response::json(array('status' => 0));

	}
}
