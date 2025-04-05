<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getData(){
        $dataUser = [
            ['id' => 1, 'nama' => 'Zidan Masadita', 'nim' => 3312401083],
            ['id' => 2, 'nama' => 'Rafi Akhbar Dirgahayuri', 'nim' => 3312401065],
            ['id' => 3, 'nama' => 'Cahya Sifa Nazwa', 'nim' => 3312401080],
            ['id' => 4, 'nama' => 'Dewi Maharani Khairunisa', 'nim' => 3312401063],
        ];

        return $dataUser;
    }

    public function tampilkan(){
        $data = $this->getData();
        return view('list_user', compact('data'));
    }
}
