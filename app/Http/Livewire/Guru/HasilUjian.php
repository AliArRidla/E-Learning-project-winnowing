<?php

namespace App\Http\Livewire\Guru;

use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HasilUjian extends Component
{
    public $nama_mapel, $nama_kelas, $id_ul, $judul_ulangan, $nav_dmid,$is_poin;
    public $id_soal_essays = [];
    public $poin = [];

    public function mount($nav_dmid, $id_ul)
    {
        $dm = DB::select('select m.nama_mapel, k.nama_kelas 
        from detail_mapels as dm 
        join mapels as m on dm.id_mapel = m.id
        join kelas as k on dm.id_kelas = k.id
        where dm.id = ?', [$nav_dmid]);

        foreach ($dm as $d) {
            $this->nama_mapel = $d->nama_mapel;
            $this->nama_kelas = $d->nama_kelas;
        }

        $dUl = Ulangan::find($id_ul)->get();
        $this->judul_ulangan = $dUl[0]->judul_ulangan;

        $this->id_ul = $id_ul;
        $this->nav_dmid = $nav_dmid;

        // pilih soal essays
        $dSoEs = DB::select('select * from soal_essays where id_ulangan = ?', [$this->id_ul]);
        foreach ($dSoEs as $dE) {
            array_push($this->id_soal_essays, $dE->id);
            if ($this->is_poin == null || $this->is_poin == ' ') {
                array_push($this->poin, $dE->poin);
            }
        }
    }

    public function getSimilarity($id_ul){
        $jawaban = DB::select('select * from soal_essays where id_ulangan = ?', [$this->id_ul]);        
        
        foreach ($jawaban as $item) {                
                
        }

        for ($i=0; $i < count($jawaban) ; $i++) { 
                // var_dump($jawaban[$i]);                
                $jawaban_siswa = DB::select('select * from soal_essays where id = ?', [$this->id_soal_essays[$i]]);
                $jawaban_guru = DB::select('select * from soal_essays where id = ?', [$this->id_soal_essays[$i]]);
                // var_dump($jawaban_siswa[0]);
                // var_dump($jawaban_guru[0]);
                $prima = 7;
                $n = 3;
                $window = 4;
                for ($j=0; $j < count($jawaban_siswa) ; $j++) { 
                        $w = new winnowing($jawaban_siswa[$j]->jawaban_siswa, $jawaban_guru[$j]->jawaban_guru);
                        $w->SetPrimeNumber($prima);
                        $w->SetNGramValue($n);
                        $w->SetNWindowValue($window);
                        $w->process();
                        $result = $w->GetJaccardCoefficient();                        
                }
                $similarity = DB::table('soal_essays')
                        ->where('id',$this->id_soal_essays[$i])
                        ->update([
                        'similarity' => $result,
                        // 'poin' => $this->poin,
                        ]); 

        }

        //     foreach ($jawaban as $item) {
                
        //         $prima = 7;
        //         $n = 3;
        //         $window = 4;
        //         $w = new winnowing($item->jawaban_guru, $item->jawaban_siswa);
        //         $w->SetPrimeNumber($prima);
        //         $w->SetNGramValue($n);
        //         $w->SetNWindowValue($window);
        //         $w->process();

        //         $result = $w->GetJaccardCoefficient();
        //         $similarity = DB::table('soal_essays')
        //         ->where('id',$this->id_soal_essays)
        //         ->update([
        //             'similarity' => $result,
        //             // 'poin' => $this->poin,
        //         ]); 
        //     }
        // dd($jawaban);
        $jawabanUpdate = DB::select('select * from soal_essays where id_ulangan = ?', [$this->id_ul]);
            
        return $jawabanUpdate;
    }

    public function getHasil($id_ul)
    {
        $data = DB::select('select ul.tgl_ulangan, ul.waktu_mulai, 
        ul.waktu_selesai, u.name, nu.nilai, nu.benar, nu.salah,
        nu.created_at as pengumpulan from ulangans as ul
        join nilai_ulangans as nu on nu.id_ulangan = ul.id
        join siswas as s on s.id = nu.id_siswa
        join users as u on u.id = s.user_id
        where ul.id = ?', [$id_ul]);

        return $data;
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        return $data;
    }

    public function getDMap()
    {
        $dMap = DB::select(
            'select dm.id as dmid, u.name, m.nama_mapel, k.nama_kelas 
            from detail_mapels as dm
            join gurus as g on dm.id_guru = g.id
            join users as u on g.user_id = u.id
            join mapels as m on dm.id_mapel = m.id
            join kelas as k on dm.id_kelas = k.id
            where g.user_id = ?
            order by k.nama_kelas asc',
            [Auth::user()->id]
        );

        // foreach ($dMap as $k) {
        //     $this->countDM++;
        // }

        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.hasil-ujian', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataHasil' => $this->getHasil($this->id_ul),
            'dataHasilEssay' => $this->getSimilarity($this->id_ul),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}


class winnowing
{
        private $word1 = '';
        private $word2 = '';

        //input properties
        // private $prime_number = 3;
        // private $n_gram_value = 2;
        // private $n_window_value = 4;

        //output properties
        private $arr_n_gram1;
        private $arr_n_gram2;
        private $arr_rolling_hash1;
        private $arr_rolling_hash2;
        private $arr_window1;
        private $arr_window2;
        private $arr_fingerprints1;
        private $arr_fingerprints2;

        public function SetPrimeNumber($value)
        {
                $this->prime_number = $value;
        }
        public function SetNGramValue($value)
        {
                $this->n_gram_value = $value;
        }
        public function SetNWindowValue($value)
        {
                $this->n_window_value = $value;
        }
        public function GetNGramFirst()
        {
                return $this->arr_n_gram1;
        }
        public function GetNGramSecond()
        {
                return $this->arr_n_gram2;
        }
        public function GetRollingHashFirst()
        {
                return $this->arr_rolling_hash1;
        }
        public function GetRollingHashSecond()
        {
                return $this->arr_rolling_hash2;
        }
        public function GetWindowFirst()
        {
                return $this->arr_window1;
        }
        public function GetWindowSecond()
        {
                return $this->arr_window2;
        }
        public function GetFingerprintsFirst()
        {
                return $this->arr_fingerprints1;
        }
        public function GetFingerprintsSecond()
        {
                return $this->arr_fingerprints2;
        }
        public function GetJaccardCoefficient($prosen = true)
        {
                if ($prosen)
                        return round(($this->jaccard_coefficient * 100), 2);
                else
                        return $this->jaccard_coefficient;
        }

        function __construct($w1, $w2)
        {
                $this->word1 = $w1;
                $this->word2 = $w2;
        }

        public function process()
        {
                if (($this->word1 == '') || ($this->word2 == '')) exit;

                //langkah 1 : buang semua huruf yang bukan kelompok [a-z A-Z 0-9] dan ubah menjadi huruf kecil semua (lowercase)
                $this->word1 = strtolower(str_replace(' ', '', preg_replace("/[^a-zA-Z0-9\s-]/", "", $this->word1)));
                $this->word2 = strtolower(str_replace(' ', '', preg_replace("/[^a-zA-Z0-9\s-]/", "", $this->word2)));

                //langkah 2 : buat N-Gram
                $this->arr_n_gram1 = $this->n_gram($this->word1, $this->n_gram_value);
                $this->arr_n_gram2 = $this->n_gram($this->word2, $this->n_gram_value);

                //langkah 3 : rolling hash untuk masing-masing n gram
                $this->arr_rolling_hash1 = $this->rolling_hash($this->arr_n_gram1);
                $this->arr_rolling_hash2 = $this->rolling_hash($this->arr_n_gram2);

                //langkah 4 : buat windowing untuk masing-masing tabel hash
                $this->arr_window1 = $this->windowing($this->arr_rolling_hash1, $this->n_window_value);
                $this->arr_window2 = $this->windowing($this->arr_rolling_hash2, $this->n_window_value);

                //langkah 5 : cari nilai minimum masing-masing window table (fingerprints)
                $this->arr_fingerprints1 = $this->fingerprints($this->arr_window1);
                $this->arr_fingerprints2 = $this->fingerprints($this->arr_window2);

                //langkah 6 : hitung koefisien plagiarisme memanfaatkan persamaan Jaccard Coefficient
                $this->jaccard_coefficient = $this->jaccard_coefficient($this->arr_fingerprints1, $this->arr_fingerprints2);
        }

        private function n_gram($word, $n)
        { //baru                
                $ngrams = array();
                $panjang = strlen($word);
                for ($i = 0; $i < $panjang; $i++) {
                        if ($i > ($n - 2)) {
                                $ng = '';
                                for ($j = $n-1; $j >= 0; $j--) {
                                        $ng .= $word[$i - $j];
                                }
                                $ngrams[] = $ng;
                        }
                }
                // var_dump($ngrams);
                return $ngrams;
        }


        private function char2hash($string)
        {
                if (strlen($string) == 1) {
                        return ord($string);
                } else {
                        $result = 0;
                        $length = strlen($string);
                        for ($i = 1; $i < $length; $i++) {
                                $result += ord(substr($string, $i, 1)) * pow($this->prime_number, $length - $i);
                                // var_dump($this->prime_number);
                                // var_dump($i);
                                // var_dump($length-$i);
                                // var_dump(pow($this->prime_number, $length - $i));
                        }                        
                        return $result;
                }
        }

        private function rolling_hash($ngram) //baru
        {
                $roll_hash = array();
                foreach ($ngram as $ng) {
                        $roll_hash[] = $this->char2hash($ng);
                }
                return $roll_hash;
        }


        private function windowing($rolling_hash, $n) //mengikuti dari ngram
        {
                // var_dump($rolling_hash);
                // var_dump($n);
                $ngram = array(); //variable baru ngram
                $length = count($rolling_hash); //panjang dari rolling hash
                $x = 0; // variable kosong
                for ($i = 0; $i < $length; $i++) {
                        if ($i > ($n - 2)) { //jika 0 > 1-2(-1)
                                $ngram[$x] = array(); // isi dari array ngram di indeks 0
                                $y = 0; //variable kosong
                                for ($j = $n - 1; $j >= 0; $j--) { //-1-1(-2) jika -2>=0 maka -2 dikurangi 1
                                        $ngram[$x][$y] = $rolling_hash[$i - $j];
                                        $y++;
                                }
                                $x++;
                        }
                }
                
                return $ngram;
        }

        private function fingerprints($window_table)
        {
                $fingers = array();
                for ($i = 0; $i < count($window_table); $i++) {
                        $min = $window_table[$i][0];
                        for ($j = 1; $j < $this->n_window_value; $j++) {
                                if ($min > $window_table[$i][$j])
                                        $min = $window_table[$i][$j];
                        }
                        $fingers[] = $min;
                }
                return $fingers;
        }


        private function jaccard_coefficient($fingerprint1, $fingerprint2)
        {
                // ini_set('memory_limit', '-1');
                $arr_intersect = array_intersect($fingerprint1, $fingerprint2);
                $arr_union = array_merge($fingerprint1, $fingerprint2);

                $count_intersect_fingers = count($arr_intersect);
                $count_union_fingers = count($arr_union);

                $coefficient = $count_intersect_fingers / ($count_union_fingers - $count_intersect_fingers);
                //     var_dump($count_union_fingers);

                return $coefficient;
        }
}
