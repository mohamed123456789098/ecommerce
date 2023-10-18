<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $num = 10;
    public $name = 'mohamed';


    public function add(){
         $this->num++;
    }
    public function min(){
         $this->num--;
    }



    public function render()
    {
        return view('livewire.counter');
    }
}
