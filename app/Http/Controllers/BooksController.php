<?php

namespace App\Http\Controllers;

use App\Books;
use App\Booklist;
use Request;

class BooksController extends Controller
{
    private $base_url = '';

    public function __construct()
    {
        $this->base_url = env('APP_URL');
        if($this->base_url && substr($this->base_url, strlen($this->base_url) - 1) !== '/') {
            $this->base_url .= '/';
        }
    }

	public function google_api_search($query) {
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

        } catch (Exception $e) {
            
        }
        
        return $res;
	}

    public function start() {

        $form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'boojbooks | Welcome to boojbooks.';    
        $data['view'] = 'home';

        $data['query'] = "";
        $data['search_results'] = [];
        $data['booklists'] = "";
        $data['nav_class'] = "home";
        $data['base_url'] = $this->base_url;
        return view($data['view'], $data );
    }       

    public function about() {

        $form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'boojbooks | About boojbooks.';    
        $data['view'] = 'about';

        $data['query'] = "";
        $data['search_results'] = [];
        $data['booklists'] = "";
        $data['nav_class'] = "about";
        $data['base_url'] = $this->base_url;
        return view($data['view'], $data );
    }        

	public function search() {

		$form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'boojbooks | Search for book.';    
        $data['view'] = 'home';

        if(!isset($form_data['query']) || empty($form_data['query'])) {
            $form_data['query'] = "";
        }

        if(isset($form_data['query_api']) && !empty($form_data['query_api'])) {
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
                    $book->page_count = $item['pageCount'];
                    $book->description = $item['description'];
                    $book->name = $item['title'];
                    $book->imageurl = $item['imageLinks']['thumbnail'];
                    $book->infourl = $item['infoLink'];
                    $item['external_id'] = $item['book_id'];
                    $item['book_id'] = $book['id'];
                    $book->save();             
                 }
    		} else { 
                $form_data['query'] = "";
            }
        } else {
            $books = Books::where('name', 'like', '%' . $form_data['query'] . '%')
                ->orderBy('name', 'asc')
                ->get();
            $results = $books->toArray();
        }

        $booklists = Booklist::all();
        if($data['view'] == 'lists'){
            $results = $booklists;
        }

        $data['query'] = $form_data['query'];
        $data['search_results'] = $results;
        $data['booklists'] = $booklists;
        $data['base_url'] = $this->base_url;
        $data['nav_class'] = "books";
    	return view($data['view'], $data );
    }     

    public function showbook($book_id = 0) {
        $form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'boojbooks | Book Information.';    
        $data['view'] = 'books';

        $book = Books::find($book_id);
        $booklists = Booklist::all();

        if(isset($form_data['save_book']) && !empty($form_data['save_book'])) {
            if(isset($form_data['delete']) && !empty($form_data['delete'])) {
                Books::destroy($book_id);
                return redirect($this->base_url);
            } else {
                if(!$book || $book_id == 0) {
                    $book = new Books();
                    $book->external_id = "0";
                } else {
                    $book = Books::find($book_id);
                }
            }           

            if(isset($form_data['booklist_id']) && !empty($form_data['booklist_id'])) {
                $book->booklist_id = $form_data['booklist_id'];
            }
            if(isset($form_data['name']) && !empty($form_data['name'])) {
                $book->name = $form_data['name'];
            }
            if(isset($form_data['author']) && !empty($form_data['author'])) {
                $book->author = $form_data['author'];
            }  
            if(isset($form_data['description']) && !empty($form_data['description'])) {
                $book->description = $form_data['description'];
            }                        
            if(isset($form_data['notes']) && !empty($form_data['notes'])) {
                $book->notes = $form_data['notes'];
            } 
            if(isset($form_data['pagenum']) && !empty($form_data['pagenum'])) {
                $book->pagenum = $form_data['pagenum'];
            }                                 
            $book->save();
        }

        $data['book'] = $book;
        $data['query'] = '';
        $data['search_results'] = $results;
        $data['booklists'] = $booklists;
        $data['base_url'] = $this->base_url;
        $data['nav_class'] = "books";
        return view($data['view'], $data );                
    }

    public function booksinlist($booklist_id = 0) {
        $form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'BookLists';    
        $data['view'] = 'home';

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = 0;
        }

        $books = Books::where('booklist_id', '=', $booklist_id)->get();

        $data['query'] = '';
        $data['search_results'] = $books->toArray();
        $data['booklists'] = Booklist::all();
        $data['base_url'] = $this->base_url;
        $data['nav_class'] = "lists";
        return view($data['view'], $data );
    }    

    public function booklists($booklist_id = 0) {
        $form_data = Request::all();   
        $results = [];
        $data = [];
        $data['pagetitle'] = 'BookLists';    
        $data['view'] = 'lists';

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = 0;
        }

        if(isset($form_data['delete']) && !empty($form_data['delete'])) {
            $data['view'] = 'lists';
            $booklist = Booklist::find($booklist_id);
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

        $data['query'] = '';
        $data['search_results'] = $results;
        $data['booklists'] = Booklist::all();
        $data['base_url'] = $this->base_url;
        $data['nav_class'] = "lists";
        return view($data['view'], $data );
    }

}
