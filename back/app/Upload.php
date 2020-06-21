<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    private $sellers = [];
    private $clients = [];
    private $sells = [];

    public function ReadFiles()
    {
        $files = Storage::disk('files_input')->files();

        foreach($files as $file){ 
            $content = Storage::disk('files_input')->get($file);
            $rows = explode(PHP_EOL, $content);

            foreach($rows as $row){
                $data = explode('ç', $row);

                switch($data[0]){
                    case 001:
                        $this->sellers[$data[2]] = $this->MountSeller($data);
                        break;
                    case 002:
                        $this->clients[$data[1]] = $this->MountClient($data);
                        break;
                    case 003:
                        $this->sells[$data[4]] = $this->MountSells($data);
                        break;
                    default:
                        break;
                }
            }
        }
        
        $this->PrintReport();

    }

    public function CleanSpace($val)
    {
        return str_replace(' ', '', $val);
    }

    public function MountSeller($val)
    {
        $sellers = [];
            
        $sellers = [
            'cpf' => $val[1], 
            'name' => $val[2], 
            'salary' => $this->CleanSpace($val[3])
        ];

        return $sellers;
    }

    public function MountClient($val)
    {
        $clients = [];
            
        $clients = [
            'cnpj' => $val[1], 
            'name' => $val[2],
            'area' => $val[3],
        ];

        return $clients;
    }

    public function MountSells($val)
    {
        $sells = [];
            
        $sells = [
            'seller_id' => $val[1], 
            'itens' => $this->MountSellItens($val[2]),
            'seller_name' => $val[3],
            'total_price' => 0
        ];

        $total_price = 0;

        foreach($sells['itens'] as $sell)
        {
            $total_price += $sell['total_price'];
        }

        $sells['total_price'] = $total_price; 

        return $sells;
    }

    public function MountSellItens($val)
    {
        $itens = [];
        $data = $this->CleanSpace($val);
        $data = str_replace('[', '', $data);
        $data = str_replace(']', '', $data);
        $data = explode(',', $data);

        foreach($data as $k){
            $item = explode('-', $k);
            $itens[] = [
                'id' => $item[0],
                'quantity' => $item[1], 
                'price' => $item[2],
                'total_price' => $item[1] * $item[2]
            ];
        }

        return $itens;
    }

    public function PrintReport()
    {
        $clientsQuantity = 0;
        $sellersQuantity = 0;
        $highestSell = 0;
        $worstSeller = 0;

        $clientsQuantity = count($this->clients);
        $sellersQuantity = count($this->sellers);

        $sells = [];

        foreach($this->sells as $key => $sell){
            $sells[$key] = [
                'price' => $sell['total_price']
            ];
        }

        $highestSell = array_search(max($sells),$sells);

        $sells = [];

        foreach($this->sells as $key => $sell){
            $name = $sell['seller_name'];
            $sells[$name] = [
                'price' => $sell['total_price']
            ];
        }

        $worstSeller = array_search(min($sells),$sells);
        
        $response = (object)[
            'Quantidade de Clientes: ' => $clientsQuantity,
            'Quantidade de Vendedores: ' => $sellersQuantity,
            'ID da venda mais cara: ' => $highestSell,
            'Pior vendedor: ' => $worstSeller,
        ];

        $response = json_encode($response);

        $fileName = uniqid(); 

        Storage::put('public/data/out/'.$fileName.'.done.dat', $response);
    }
}
