<?php

namespace App\Http\Controllers;

use App\Books;
use App\Booklist;
use Session;
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
        $this->data['booklists'] = Booklist::getforweb();
        $this->data['reading_queue_listid'] = Booklist::reading_queue_listid();
        $this->data['reading_queue_books_count'] = Booklist::reading_queue_books_count();
        $this->data['reading_queue_books_pages_count'] = Booklist::reading_queue_books_pages_count();
        $this->data['books_count'] = Books::count();
        $this->data['pages_count'] =  Books::sum('page_count');
        $this->data['booklists_count'] = count($this->data['booklists']);

        if($this->data['books_count'] == 0) {
            Session::flash('message', 'There are no books created, add your favorites today!');
        }        
    }


    public function start() {

        $form_data = Request::all();   

        $this->finalize();
        return view($this->data['view'], $this->data );
    }       

    public function bookplanner() {

        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | My Reading Planner.';    
        $this->data['view'] = 'home';
        $this->data['nav_class'] = "planner";
        // 99999 == Reading Queue, cheap hardcode :/

        $booklist = Booklist::reading_queue_list();
        $books = Books::getbybooklist($booklist->id);
        $results = $books;  
        $this->data['search_results'] = $results;                  
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
    			Books::google_api_search($form_data['query']);
    		} else { 
                $form_data['query'] = "";
            }
        }

        $books = Books::getforweb();
        $results = $books;

        $booklists = Booklist::getforweb();
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
        $booklists = Booklist::getforweb();

        if(isset($form_data['save_book']) && !empty($form_data['save_book'])) {
            if(isset($form_data['delete']) && !empty($form_data['delete'])) {
                Books::destroy($book_id);
                $this->finalize();
                Session::flash('message', 'Book successfully deleted.');
                return redirect($this->base_url);
            } else {
                if(!$book || $book_id == 0) {
                    if(isset($form_data['new']) && !empty($form_data['new'])) {
                        $book = new Books();
                        $book->external_id = "0";
                        $book->booklist_id = -1;
                        $book->name = "";
                        $book->author = "";
                        $book->description = "";
                        $book->notes = "";
                        $book->page_num = 0;
                        $book->page_count = 0;
                        $book->time_to_read = 0;
                        $book->infourl = "";
                        $book->imageurl = "";
                        $book->category = "";
                        $s_message = "New book successfully saved.";
                    }
                } else {
                    $s_message = "Book successfully saved.";
                    $book = Books::find($book_id);
                }
            }           

            if(isset($form_data['add_to_queue']) && !empty($form_data['add_to_queue'])) {
                $book->booklist_id = Booklist::reading_queue_listid();
            } else {
                if(isset($form_data['booklist_id']) && !empty($form_data['booklist_id'])) {
                    $book->booklist_id = $form_data['booklist_id'];
                }
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
            if(isset($form_data['page_num']) && !empty($form_data['page_num'])) {
                $book->page_num = $form_data['page_num'];
            }                                 
            $book->save();
            Session::flash('message', $s_message);
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

        $books = Books::getbybooklist($booklist_id);

        if(count($books) === 0) {
            Session::flash('message', 'Sorry Chap, no books here!  Search for and add some now!');
        }

        $this->data['search_results'] = $books;
        $this->data['nav_class'] = "lists";
        $this->finalize();
        return view($this->data['view'], $this->data );
    }    

    public function booklists($booklist_id = 0) {
        $form_data = Request::all();   
        $this->data['pagetitle'] = 'boojbooks | BookLists';    
        $this->data['view'] = 'lists';

        if(!isset($form_data['booklist_id']) || empty($form_data['booklist_id'])) {
            $form_data['booklist_id'] = -1;
        }

        if(isset($form_data['delete']) && !empty($form_data['delete'])) {
            $this->data['view'] = 'lists';
            $booklist = Booklist::find($booklist_id);
            if($booklist) {
                if($booklist->listname != "- Reading Queue -") {
                    $booklist->delete();
                    Session::flash('message', 'Booklist successfully deleted.');
                }
                return redirect('booklists');
            }
        }

        if(isset($form_data['newlist']) && !empty($form_data['newlist'])) {
            $this->data['view'] = 'lists';
            if($form_data['newlist'] != "- Reading Queue -") {
                $booklist = new Booklist;
                $booklist->listname = $form_data['newlist'];
                $booklist->save();
                Session::flash('message', 'New Booklist successfully saved.');
            }
        }        

        if(isset($form_data['mylists']) && !empty($form_data['mylists'])) {
            $this->data['view'] = 'lists';
        }        

        $booklists = Booklist::getforweb();

        if($this->data['view'] == 'lists'){
            $results = $booklists;
        }

        if(count($booklists) == 0) {
            Session::flash('message', 'There are no booklists created, create one below!');
        }


        $this->data['search_results'] = $results;
        $this->data['nav_class'] = "lists";
        $this->finalize();
        return view($this->data['view'], $this->data );
    }

}
