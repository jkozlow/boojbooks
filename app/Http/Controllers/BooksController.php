<?php

namespace App\Http\Controllers;

use App\Books;
use App\Booklist;
use Request;

class BooksController extends Controller
{
    private $base_url = '';
    private $data = [];

    public function __construct()
    {
        $this->base_url = env('APP_URL');
        if($this->base_url && substr($this->base_url, strlen($this->base_url) - 1) !== '/') {
            $this->base_url .= '/';
        }

        $this->data['pagetitle'] = 'boojbooks | Welcome to boojbooks.';   
        $this->data['view'] = 'home';
        $this->data['nav_class'] = "home";

        $this->data['search_results'] = [];
        $this->data['base_url'] = $this->base_url;
    }

    public function finalize() {
        $this->data['booklists'] = Booklist::all();
        $books = Books::all();
        $this->data['books_count'] = count($books);
        $this->data['booklists_count'] = count($this->data['booklists']);
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

        $this->finalize();
        return view($this->data['view'], $this->data );
    }       

    public function about() {

        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | About boojbooks.';    
        $this->data['view'] = 'about';
        $this->data['nav_class'] = "about";
        $this->finalize();
        return view($this->data['view'], $this->data );
    }        

	public function search() {

		$form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | Search for book.';    
        $this->data['view'] = 'home';
        $results = "";

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

                    $book = Books::where('external_id', '=', $item['book_id'])->get();

                    if(count($book)==0) { 
                        $book = new Books;
                        $book->booklist_id = 0;
                        $book->notes = "";
                        $book->pagenum = "";
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
                    $book->page_count = ($item['pageCount'] ? $item['pageCount'] : 0);
                    $book->description = ($item['description'] ? $item['description'] : "");
                    $book->name = $item['title'];
                    $book->imageurl = ($item['imageLinks']['thumbnail'] ? $item['imageLinks']['thumbnail'] : "");
                    $book->infourl = $item['infoLink'];
                    $book->category = ($book['category'] ? $book['category']  : "");
                    $book->author = ($book['author'] ? $book['author']  : "");
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
        if($this->data['view'] == 'lists'){
            $results = $booklists;
        }

        $this->data['search_results'] = $results;
        $this->data['nav_class'] = "books";
        $this->finalize();
    	return view($this->data['view'], $this->data );
    }     

    public function showbook($book_id = 0) {
        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | Book Information.';    
        $this->data['view'] = 'books';

        $book = Books::find($book_id);
        $booklists = Booklist::all();

        if(isset($form_data['save_book']) && !empty($form_data['save_book'])) {
            if(isset($form_data['delete']) && !empty($form_data['delete'])) {
                Books::destroy($book_id);
                $this->finalize();
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

        $this->data['book'] = $book;
        $this->data['nav_class'] = "books";
        $this->finalize();
        return view($this->data['view'], $this->data );                
    }

    public function booksinlist($booklist_id = 0) {
        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | BookLists';    
        $this->data['view'] = 'home';

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = 0;
        }

        $books = Books::where('booklist_id', '=', $booklist_id)->get();

        $this->data['search_results'] = $books->toArray();
        $this->data['nav_class'] = "lists";
        $this->finalize();
        return view($this->data['view'], $this->data );
    }    

    public function booklists($booklist_id = 0) {
        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | BookLists';    
        $this->data['view'] = 'lists';

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = 0;
        }

        if(isset($form_data['delete']) && !empty($form_data['delete'])) {
            $this->data['view'] = 'lists';
            $booklist = Booklist::find($booklist_id);
            if($booklist) {
                $booklist->delete();
            }
        }

        if(isset($form_data['newlist']) && !empty($form_data['newlist'])) {
            $this->data['view'] = 'lists';
            $booklist = new Booklist;
            $booklist->listname = $form_data['newlist'];
            $booklist->save();
        }        

        if(isset($form_data['mylists']) && !empty($form_data['mylists'])) {
            $this->data['view'] = 'lists';
        }        

        $booklists = Booklist::all();
        $booklist_script = "<select name='booklist_id'>";
        foreach ( $booklists as $booklist ) {
            $booklist_script .= "<option ". ($form_data['booklist_id'] == $booklist->id ? 'SELECTED' : '') . " value='" . $booklist->id . "'>" . $booklist->listname ."</option>";
        }
        $booklist_script .= "</select>";

        if($this->data['view'] == 'lists'){
            $results = $booklists;
        }

        $this->data['search_results'] = $results;
        $this->data['nav_class'] = "lists";
        $this->finalize();
        return view($this->data['view'], $this->data );
    }

}
