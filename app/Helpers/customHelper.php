<?php

function SF_Goods($sf_uid = NULL, $makeQuery = FALSE, $key = NULL, $data = [], $tableName = 'u_wh_transactions_sf_items')
{
    if($sf_uid == NULL) return "SF Uid is null";
    if($makeQuery === true && $key === NULL) return "Key is empty";
    $sf = dbRequestArray("SELECT uid, goodsitem0, goodstype, brutto FROM u_cc_menus_sub WHERE lnk = '".$sf_uid."' AND del = 0 AND cancelled = ''", "", "1");
    $goods = [];

    for($i = 0; $i < count($sf); $i++)
    {
        if($sf[$i]['goodstype'] == '2')
        {
            if($makeQuery === TRUE && $key !== NULL  && $tableName !== NULL && is_array($data))
            {
                if(!isset($data['user'])) $data['user'] = $ucID;
                if(!isset($data['micros_uid'])) $data['micros_uid'] = NULL;
                DBrequest_push($key, "INSERT INTO ".$tableName." SET
                    uid = '".uniqid()."',
                    tuid = '".$data['tuid']."',
                    type = '".$data['type']."',
                    srcwh = '".$data['srcwh']."',
                    destwh = '".$data['destwh']."',
                    guest_order = '".$data['guest_order']."',
                    goodsuid = '".$sf[$i]['goodsitem0']."',
                    userqty = '".($data['userqty'] * $sf[$i]['brutto'])."',
                    micros_uid = '".$data['micros_uid']."',
                    sub_uid = '".$data['sub_uid']."',
                    crID = '".$data['user']."',
                    ucID = '".$ucID."'
                ");
            }
            else
            {
                array_push($goods, [ 'descr' => DBrequestSingleRowProc("CALL makeGoodsName('".$sf[$i]['goodsitem0']."','".$clang."','0','0')","","1")['descr'], 'qty' => $sf[$i]['brutto'], 'goodsuid' => $sf[$i]['goodsitem0'] ]);
            }
        }
        else
        {
            $goods = array_merge($goods, SF_Goods($sf[$i]['goodsitem0'], $makeQuery, $key, $data, $tableName));
        }

    }
    return $goods;
}

function Menu_Goods($microsCode = NULL, $dishUid = NULL, $makeQuery = FALSE, $key = NULL, $data = [], $tableName = 'u_wh_transactions_sf_items')
{
    if($microsCode != NULL && $dishUid == NULL)
    {
        $menus = dbRequestSingleRow("SELECT uid FROM u_cc_menus WHERE micros LIKE '%".$microsCode."%' AND del = 0 AND cancelled = ''", "", "1");
        $menusLnk = dbRequestArray("SELECT * FROM u_cc_menus_lnk WHERE dishuid = '".$menus['uid']."' AND del = 0 AND cancelled = ''", "", "1");
    }
    elseif($microsCode == NULL && $dishUid != NULL)
    {
        $menusLnk = dbRequestArray("SELECT * FROM u_cc_menus_lnk WHERE dishuid = '".$dishUid."' AND del = 0 AND cancelled = ''", "", "1");
    }
    else
    {
        return "ERROR";
    }
    $goods = [];
    for($i = 0; $i < count($menusLnk); $i++)
    {
        if($menusLnk[$i]['goodstype'] == '2')
        {
            if($makeQuery === TRUE && $key !== NULL  && !empty($tableName) && is_array($data))
            {
                if(!isset($data['user'])) $data['user'] = $ucID;
                DBrequest_push($key, "INSERT INTO ".$tableName." SET
                    uid = '".uniqid()."',
                    tuid = '".$data['tuid']."',
                    type = '".$data['type']."',
                    srcwh = '".$data['srcwh']."',
                    destwh = '".$data['destwh']."',
                    guest_order = '".$data['guest_order']."',
                    goodsuid = '".$menusLnk[$i]['goodsitem']."',
                    userqty = '".($data['userqty'] * $menusLnk[$i]['brutto'])."',
                    sub_uid = '".$data['sub_uid']."',
                    micros_uid = '".$data['micros_uid']."',
                    crID = '".$data['user']."',
                    ucID = '".$ucID."'
                ");
            }
            else
            {
                array_push($goods, [ 'descr' => DBrequestSingleRowProc("CALL makeGoodsName('".$menusLnk[$i]['goodsitem']."','".$clang."','0','0')","","1")['descr'], 'qty' => $menusLnk[$i]['brutto'], 'goodsuid' => $menusLnk[$i]['goodsitem'] ]);
            }

        }
        elseif($menusLnk[$i]['goodstype'] == '1')
        {
            $goods = array_merge($goods, SF_Goods($menusLnk[$i]['goodsitem'], $makeQuery, $key, $data));
        }
        else
        {
            $goods = array_merge($goods, Menu_Goods(NULL, $menusLnk[$i]['goodsitem'], $makeQuery, $key, $data, $tableName));
        }
    }
    return $goods;
}
