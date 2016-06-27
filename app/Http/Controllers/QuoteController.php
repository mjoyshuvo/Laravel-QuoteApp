<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Author;

use App\Quote;

use App\Events\QuoteCreated;

use Illuminate\Support\Facades\Event;

class QuoteController extends Controller
{
    public function getIndex($author=null){//To pass the quote in the view, first get the quote
    	if(!is_null($author)){//check if the author is passed
    		//first check if the author of this name exist
    		$quote_author = Author::where('name', $author)->first();
    		if($quote_author){
    			$quotes = $quote_author->quotes()->orderBy('created_at', 'desc')->paginate(6);//if the author exist then show all quotes by the author
    		}
    		}else{
    			$quotes = Quote::orderBy('created_at', 'desc')->paginate(6);
    		}
    	return view('index',['quotes'=>$quotes]);//'quotes' can be any name
    }

    public function postQuote(Request $request){
    	$this->validate($request, [
		'author'=>'required|max:60|alpha',
		'quote'=>'required|max:500',
		'email'=>'required|email'
	]);
    	$authorText = ucfirst($request['author']); // get the author name as text
    	$quoteText = $request['quote']; // get quote as text
    	// --- Check if the auther is already exist----
    	$author = Author::where('name', $authorText)->first();
    	if (!$author) { // if author not exist create new author
    		$author = new Author();
    		$author-> name = $authorText;// author name will be the author text and then save the author
    		$author->save();

    	}

    	$quote = new Quote();//create new quote
    	$quote-> quote = $quoteText;//our quote will be the value of the quote text
    	$author->quotes()->save($quote);//mape your quote with auther

    	//for event handeler
    	//Event::fire(new QuoteCreated($author));

    	return redirect()->route('index')->with([
    		'success' => 'Quote Saved!'
    		]);

    }
    public function getDeleteQuote($quote_id){
    	//To delete a quote first find it
    	$quote= Quote::find($quote_id);
    	$author_deleted=false;
    	//check how many quote my author has
    	if (count($quote->author->quotes)===1) {//check if the author of the quote has only one quote, if true thene delete the author of the quote
    		$quote->author->delete();
    		$author_deleted=true;
    	}
    	$quote->delete();//delete the quote
    	$msg = $author_deleted ? 'Quote and Author deleted' : 'Quote deleted';
    	return redirect()->route('index')->with([
    		'success'=>$msg
    	]);
    }
}
