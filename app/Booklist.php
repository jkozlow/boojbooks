<?php

namespace App;

use App\Books;
use Illuminate\Database\Eloquent\Model;

class Booklist extends Model
{
    //
    static function getforweb() {
    	$booklist = Booklist::where('listname', '!=', '- Reading Queue -')->get();
    	return $booklist->toArray();
    }

    static function reading_queue_listid() {
        $booklist = Booklist::where('listname', '=', '- Reading Queue -')->get();
        if(count($booklist)==0) { 
            $booklist = new Booklist;
            $booklist->listname = "- Reading Queue -";
            $booklist->save();
        } 
        return $booklist[0]['id'];
    }       

    static function reading_queue_list() {
        $booklist = Booklist::where('listname', '=', '- Reading Queue -')->get();
        if(count($booklist)==0) { 
            $booklist = new Booklist;
            $booklist->listname = "- Reading Queue -";
            $booklist->save();
        } 
        return Booklist::find($booklist[0]['id']);
    }      

    static function reading_queue_books() {
        $booklist = Booklist::reading_queue_list();
        if(count($booklist)!==0) { 
            $reading_queue_books = Books::getbybooklist($booklist->id);
        	
            return $reading_queue_books->toArray();
        } else {
            return [];
        }
    }    

    static function reading_queue_books_count() {
        $booklist = Booklist::reading_queue_list();
        if(count($booklist)!==0) { 
            $reading_queue_books = Books::where('booklist_id', '=', $booklist->id)
                ->orderBy('name', 'asc')
                ->get();
        
            return count($reading_queue_books);
        } else {
            return 0;
        }
    }    

    static function reading_queue_books_pages_count() {
        $booklist = Booklist::reading_queue_list();
        if(count($booklist)!==0) { 
            $reading_queue_books = Books::where('booklist_id', '=', $booklist->id)
                ->orderBy('name', 'asc')
                ->get();
        
            return Books::where('booklist_id', '=', $booklist->id)->sum('page_count');
        } else {
            return 0;
        }
    }        

}
