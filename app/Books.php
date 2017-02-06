<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Books extends Model
{
    //
    static function getforweb($query = "") {
    	if(strlen($query) > 0) {
    		$books = Books::where('name', 'like', '%' . $query . '%')
    			->orderBy('name', 'asc')
    			->get();
    	} else {
    		$books = Books::where('id', '>', 0)
    			->orderBy('name', 'asc')
    			->get();    		
    	}
    	return $books->toArray();
    }    

    static function getbybooklist($booklist_id) {
    	$books = Books::where('booklist_id', '=', $booklist_id)
    			->orderBy('name', 'asc')
    			->get();      	
    	return $books->toArray();
    }        

	static function google_api_search($query = "") {
        try {
            $client = new \Google_Client();
            $client->setApplicationName(env("APP_NAME"));
            $client->setDeveloperKey(env("GOOGLE_API_KEY"));

            $service = new \Google_Service_Books($client);
            $optParams = array();   
            $google_results = $service->volumes->listVolumes($query, $optParams);

            $res = [];

            foreach ($google_results as $item) {
                $res[] = $item['volumeInfo'];
            }

            foreach ($res as $item) {
		   		$item['book_id'] = -1;

				foreach($item['industryIdentifiers'] as $ident) {
					$book = Books::where('external_id', '=', $ident['identifier'])->get();
					if(count($book)!=0) { 
						$item['book_id'] = $ident['identifier'];
						break;
					}
				}

			    if(count($book)==0) { 
			        $book = new Books;
			        $book->save();
			    } else {
			        $book = Books::find($book[0]['id']);
			    }

			    $t = "";
			    if(is_array($item['authors'])) {
			        foreach ($item['authors'] as $author) {
			            $t .= ", " . $author;
			        }
			    } 

			    if($t) { 
			        $book->author = $t;
			    }

			    if(substr($book->author, 0, 2) == ', ') {
			        $book->author = substr($book->author, 2);
			    }

			    $t = "";
			    if(is_array($item['categories'])) {
			        foreach ($item['categories'] as $category) {
			            $t .= ", " . $category;
			        }
			    } 

			    if($t) { 
			        $book->category = $t;
			    }                

			    if(substr($book->category, 0, 2) == ', ') {
			        $book->category = substr($book->category, 2);
			    }

			    $item->author = $book->author;
			    $book->external_id = $item['book_id'];
			    $book->page_count = ($item['pageCount'] ? $item['pageCount'] : 0);
			    $book->description = ($item['description'] ? $item['description'] : "");
			    $book->name = ($item['title'] ? $item['title'] : "");
			    $book->imageurl = ($item['imageLinks']['thumbnail'] ? $item['imageLinks']['thumbnail'] : "");
			    $book->infourl = $item['infoLink'];
			    $book->category = ($book['category'] ? $book['category']  : "");
			    $book->author = ($book['author'] ? $book['author']  : "");
			    $book->save();              	
		    }

        } catch (Exception $e) {
            Session::flash('message', 'There was a problem connecting to the Google API server, please retry.');
            return false;
        }
        
        return true;

	}
}
