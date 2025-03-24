<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{

    use WithFileUploads;

    #[Validate('required\min:5')]
    public $title;

    #[Validate('required\min:10')]
    public $description;

    #[Validate('required\numeric')]
    public $price;

    #[Validate('required')]
    public $category;
    public $article;

    public $images=[];
    public $temporary_images;

    protected function cleanForm(){

    $this->title='';
    $this->description='';
    $this->category='';
    $this->price='';
    $this->images=[];
    }



    public function store(){
        $this->validate();
        $this->article=Article::create([
            'title'=>$this->title,
            'description'=>$this->description,
            'price'=>$this->price,
            'category'=>$this->category,
            'user_id'=>Auth::id()

        ]);

        if(count($this->images)>0){
            foreach ($this->images as $image){
                $this->article->images()->create(['path'=>$image->store('images','public')]);
            }
        }
        
        
        session()->flash('success','Articolo creato correttamente');
        $this->cleanForm();
    }

    public function updatedTemporaryImages(){
        if($this->validate([
            'temporary_images.*'=> 'image|max:1024',
            'temporary_images' =>'max:6'
        ])){
            foreach($this->temporary_images as $image){
                $this->images[]=$image;
            }
        }
    }

    public function removeImage($key){
        if(in_array($key, array_keys($this->images))){
            unset($this->images[$key]);
        }
    }

    public function store()
    {
        $this->validate();
        $this->article= Article::create([
            'title'=> $this-> price,
            'description' => $this->description,
            'price'=>$this->price,
            'category_id'=>Auth::id()
        ]);
        if(count($this->images)->0){
            foreach($this->images as $image){
                $newFileName="articles/{$this->article->id)";
                $newImage= $this->article->images()->create(['path' => $image->store($newFileName,'public')]);
                dispatch(new ResizeImage($newImage->path,300,300));
            }
            File::deleteDirectory(storage_path('/app/livewire-tap'));
        }
        session()->flash('success','Articolo creato correttamente');
        $this->cleanForm();

    }

   

    public function render()
    {
        return view('livewire.create-article-form');
    }
}
