<?php

namespace App\Http\Controllers;

use App\Books;
use App\Booklist;
use Request;

class BooksController extends Controller
{
	public function google_api_search($query) {
        $client = new \Google_Client();
        $client->setApplicationName(env("APP_NAME"));
        $client->setDeveloperKey(env("GOOGLE_API_KEY"));

        $service = new \Google_Service_Books($client);
    //  $optParams = array('filter' => 'free-ebooks');
        $optParams = array();   
        $google_results = $service->volumes->listVolumes($query, $optParams);

        $res = [];

        foreach ($google_results as $item) {
            $res[] = $item['volumeInfo'];
        }

        return $res;
	}

	public function start() {

		$form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'home';    
        $data['view'] = 'home';

		if(isset($form_data['query']) && !empty($form_data['query'])) {
			$results = $this->google_api_search($form_data['query']);
            foreach($results as &$item) {
                $item['book_id'] = -1;

                if(isset($item['industryIdentifiers'][0])) {
                    $item['book_id'] = $item['industryIdentifiers'][0]['identifier'];
                }

                $item['book_id'] = preg_replace("[A-Z\:]", "", $item['book_id']);
                $book = Books::where('external_id', '=', $item['book_id'])->get();

                if(count($book)==0) { 
                    $book = new Books;
                } else {
                    $book = Books::find($book[0]['id']);
                }

                $item['booklist_id'] = $book->booklist_id;

                $book->external_id = $item['book_id'];
                $book->description = substr($item['description'], 0 , 900);
                $book->name = $item['title'];
                $book->imageurl = $item['imageLinks']['thumbnail'];
                $book->infourl = $item['infourl'];
                $book->save();             
             }
		} else { 
            $form_data['query'] = "";
        }

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = "";
        }     

        if(!isset($form_data['book_id']) || empty($form_data['book_id'])) {
            $form_data['book_id'] = "";
        }     

        if($form_data['booklist_id'] && $form_data['book_id'] && $form_data['assign']) {
            $book = Books::where('external_id', '=', $form_data['book_id'])->get();
            if(count($book)) { 
                $book = Books::find($book[0]['id']);
                $book->booklist_id = $form_data['booklist_id'];
                $book->save();

            }
        }

        if(isset($form_data['dellist']) && !empty($form_data['dellist'])) {
            $data['view'] = 'lists';
            $booklist = Booklist::find($form_data['dellist']);
            if($booklist) {
                $booklist->delete();
            }
        }

        if(isset($form_data['newlist']) && !empty($form_data['newlist'])) {
            $data['view'] = 'lists';
            $booklist = new Booklist;
            $booklist->listname = $form_data['newlist'];
            $booklist->save();
        }        

        if(isset($form_data['mylists']) && !empty($form_data['mylists'])) {
            $data['view'] = 'lists';
        }        

        $booklists = Booklist::all();
        $booklist_script = "<select name='booklist_id'>";
        foreach ( $booklists as $booklist ) {
            $booklist_script .= "<option ". ($form_data['booklist_id'] == $booklist->id ? 'SELECTED' : '') . " value='" . $booklist->id . "'>" . $booklist->listname ."</option>";
        }
        $booklist_script .= "</select>";

        if($data['view'] == 'lists'){
            $results = $booklists;
        }


        $data['query'] = $form_data['query'];
        $data['search_results'] = $results;
        $data['booklist_script'] = $booklist_script;
        $data['booklists'] = $booklists;
    	return view($data['view'], $data );
    }        
}
