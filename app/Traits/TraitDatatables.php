<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait TraitDatatables
{
    public function dtable(Request $request, $model, array $properties, array $filters = [], $searchable = true)
    {
        if (empty($filters)) {
            $filters = $properties;
        }
        self::setPagginate($request);
        $order = self::getOrdenation($request);
        if ($searchable AND trim($request->search['value']) != "") {
            $search = strtoupper($request->search['value']);
            $model->where(function ($query) use ($search, $filters) {
                foreach ($filters as $key => $type) {
                    switch ($type) {
                        case 'string':
                            $pos = strpos($search, '*');
                            if ($pos) {
                                $search = str_replace('*', '%', $search);
                            } else {
                                $search = "%{$search}%";
                            }
                            $query->orwhere($key, 'like', "$search");
                            break;
                        case 'integer':
                            if (is_numeric($search)) {
                                $query->orwhere($key, '=', trim($search));
                            }
                            break;
                        case 'date':
                            $query->orwhere($key, '=', trim($search));
                            break;
                        default:
                            if (is_array($type)) {
                                $obj = (object)$type;
                                if (is_array($obj->campo)) {
                                    foreach ($obj->campo as $campo) {
                                        $query->orWhereRelation($obj->relacao, $campo, 'like', "%{$search}%");
                                    }
                                } else {
                                    $query->orWhereRelation($obj->relacao, $obj->campo, 'like', "%{$search}%");
                                }
                            } elseif (is_numeric($search)) {
                                $query->orwhere($key, '=', trim($search));
                            }
                    }
                }
            });
        }
        if (!empty($order['field']) and !empty($order['order'])) {
            $model = $model->orderBy($order['field'], $order['order']);
        }
        if ((int)$request->length > 0) {
            $regs = $model->paginate($request->length);
            $total = $regs->total();
        } else {
            $regs = $model->get();
            $total = 0;
        }
        $response = [
            'draw' => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => []
        ];
        foreach ($regs as $reg) {
            $arr = [];
            foreach ($properties as $key => $type) {
                if (is_array($type)) {
                    $obj = (object)$type;
                    if (!empty($reg->{$obj->relacao}->{$obj->campo})) {
                        $value = $reg->{$obj->relacao}->{$obj->campo};
                        $arr[$key] = self::formatter($value, $obj->type);
                    } else {
                        $arr[$key] = self::formatter ($reg->$key, 'string');
                    }
                } else {
                    $arr[$key] = self::formatter($reg->$key, $type);
                }
            }
            $response['data'][] = $arr;
        }
        return $response;
    }

    protected function setPagginate(Request &$request)
    {
        $page = 1;
        if ($request->start > 0) {
            $page = ($request->start / $request->length) + 1;
        }
        $request->merge([
            'page' => $page
        ]);
    }

    protected function getOrdenation($request)
    {
        return [
            'field' => $request->columns[$request->order[0]['column']]['name'],
            'order' => $request->order[0]['dir']
        ];
    }

    protected function formatter($value, $type)
    {
        if ($value == null AND $value != 0 AND $type != 'datetime') {
            return $value;
        }
        switch ($type) {
            case 'id':
                $value = str_pad($value, 6, 0, STR_PAD_LEFT);
                break;
            case 'integer':
                $value = (int)$value;
                break;
            case 'string':
            case 'boolean':
                break;
            case 'date':
                $value = Carbon::parse($value)->format('d/m/Y');
                break;
            case 'datetime':
                $value = $value != null ? Carbon::parse($value)->format('d/m/Y H:i:s') : '';
                break;
            case 'number':
                $value = number_format($value, 2, '.', '');
                break;
            case 'quant':
                $value = number_format($value, 3, ',', '.');
                break;
            case 'amount':
                $value = number_format($value, 2, ',', '.');
                break;
            case 'money':
                $value = 'R$ '.number_format($value, 2, ',', '.');
                break;
            default:
                throw new \Exception('Tipo não suportado');
        }
        return $value;
    }

    public function dtableEmpty()
    {
        return [
            'draw' => 1,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ];
    }
}
