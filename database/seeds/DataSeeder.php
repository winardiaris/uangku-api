<?php

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $dates = ["2016-01-01","2016-01-01","2016-01-02","2016-01-02","2016-01-03","2016-01-03","2016-01-04","2016-01-04","2015-12-31","2015-12-30","2016-03-01","2016-02-01","2016-06-06","2016-06-06"];
               $type = ["in","out"];
               
         foreach($dates as $date) {
                   $t=$type[rand(0,1)];
                   if($t=='in'){
                               $desc='Pendapatan';
                                       
                   }
                   else{
                               $desc='Pembelian';
                                       
                   }
                           DB::insert("insert into `data` (`users_id`, `date`, `bill`, `type`, `value`, `desc`,`created_at`,`updated_at`) value (:users_id, :date, :bill, :type, :value, :desc, :created_at,:updated_at)",
                             [
                               'users_id' => '1',
                               'date' => $date,
                               'bill' => str_random(12),
                               'type' => $t,
                               'value' => rand(100,800) * 10000,
                               'desc' => $desc." ".str_random(5),
                               'created_at'=>date("Y-m-d H:i:s"),
                               'updated_at'=>date("Y-m-d H:i:s")
                                         
                             ]);
         }
    }
}
