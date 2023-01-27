<div class="table-responsive">
    <table class="table table-striped table-inverse mb-1">
        <tbody>
        @php
            // $array = [];
            // $current_price = 0;
            // $current_from = 0;
            // foreach ($rows as $key => $item){
            //     if($booking->getMeta("booking_type") == "by_day"){
            //         $item['to'] = $item['from'];
            //         $item['to_html'] = $item['from_html'];
            //     }
            //     if(empty($array)){
            //         $current_price = $item['price'];
            //         $current_from = $item['from'];
            //         $array[$item['from']] = $item;
            //         continue;
            //     }
            //     if($current_price == $item['price']){
            //         $array[$current_from]['to'] = $item['to'];
            //         $array[$current_from]['to_html'] = $item['to_html'];
            //     }else{
            //         $current_price = $item['price'];
            //         $current_from = $item['from'];
            //         $array[$item['from']] = $item;
            //     }
            // }
            $rows = array_values($rows);
            $from = $rows[0]['from'];
            $array = [];
            foreach ($rows as $item => $value) {
                if($item==0){
                    $from = $value['from'];
                    $array[$from] = $value;
                }
                if (!empty($rows[($item - 1)]['price']) and $value['price'] == $rows[($item - 1)]['price'] ) {
                    $array[$from]['to'] = $value['from'];
                    $array[$from]['to_html'] = $value['from_html'];
                } elseif(!empty($rows[($item - 1)]['price']) and $value['price'] != $rows[($item - 1)]['price'] ) {
                    $from = $value['from'];
                    $array[$from] = $value;
                    $array[$from]['to'] = $value['from'];
                    $array[$from]['to_html'] = $value['from_html'];
                }else{
                    $array[$from]['to'] = $value['to'];
                    $array[$from]['to_html'] = $value['to_html'];
                }
            }
        @endphp
        @foreach($array as $item=>$value)
            @php
                $days = 0;
                if($booking->getMeta("booking_type") == "by_day"){
                    $days = max(1,floor(($value['to'] - $value['from']) / DAY_IN_SECONDS)+1);
                }
                if($booking->getMeta("booking_type") == "by_night"){
                    $days = max(1,floor(($value['to'] - $value['from']) / DAY_IN_SECONDS));
                }
            @endphp
            <tr>
                <td>{{$value['from_html']}} <i class="fa fa-long-arrow-right"></i> {{$value['to_html']}}</td>
                <td class="text-right">{{$value['price_html']}}*{{$days}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>