<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikePost extends Component
{
    // public $mensaje = "Hola mundo desde un atrinuto";
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)
    {
        $this->isLiked = $post->checkLikes(Auth::user());
        $this->likes = $post->likes->count();
    }
    public function render()
    {

        return view('livewire.like-post');
    }

    public function like()
    {
        if($this->post->checkLikes(Auth::user())){
            $this->post->likes()->where('user_id', Auth::user()->id)->delete();
            $this->isLiked = false;
            $this->likes --;
        }else {
            $this->post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
            $this->isLiked = true;
            $this->likes ++;
        }
        // return "desde la fn de like";
    }
}
