//In controller

if(isset($_GET['submit'])){
      $from_date = strtotime(trim($_GET['start_date']));
      $to_date = strtotime(trim($_GET['end_date']))+(60*60*24); // adding 24 hour time;
      $payment_type = trim($_GET['payment_type']);
      $current_timestamp = time();
      if($current_timestamp < $from_date){
        drupal_set_message(t('Future date not allowed as From Date.'), 'error');         
      }            

    }

    $currency = "USD";
    $currency_formatter = \Drupal::service('commerce_price.currency_formatter');
    $option = [
      'currency_display' => 'none',
      'rounding_mode' => PHP_ROUND_HALF_DOWN,
    ];
    
    $filter_form = '<div class="container">
        <form class="form-horizontal" action="" method="GET">
          <div class="form-group">
            <label class="control-label col-sm-2" for="start_date">From Date:</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" id="start_date" name="start_date" value="'.$_GET['start_date'].'">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="end_date">To Date:</label>
            <div class="col-sm-4">          
              <input type="date" class="form-control" id="end_date"  name="end_date" value="'.$_GET['end_date'].'">
            </div>
          </div>
          <div class="form-group">
          <label class="control-label col-sm-2" for="end_date">Payment Type:</label>
            <div class="col-sm-4">          
              <select name="payment_type">
                <option value="">All</option>
                <option value="CC" ';
    if($_GET['payment_type'] == 'CC'){
      $filter_form .= "selected='selected'";
    }
    $filter_form .= ' >CC</option>
                <option value="ACHC" ';
    if($_GET['payment_type'] == 'ACHC'){
      $filter_form .= "selected='selected'";
    }
    $filter_form .= ' >ACHC</option>
                <option value="manual_payment_capture" ';
    if($_GET['payment_type'] == 'manual_payment_capture'){
      $filter_form .= "selected='selected'";
    }
    $filter_form .= ' >Manual Payment</option>
              </select>
            </div>
          </div>
          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-4">
              <button type="submit" class="btn btn-default" name="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>';

    $build = array(
      '#type' => 'inline_template',
      '#template' => $filter_form,
    );

    $header = array(
      array('data' => t('Order Date'), 'field' => 'order_date','sort' => 'desc'),
      array('data' => t('Player Name'), 'field' => 'player'),
      array('data' => t('Parent'), 'field' => 'parent'),
      array('data' => t('Total'), 'field' => 'amount'),
      array('data' => t('Payment Method'), 'field' => 'payment_type'),
      array('data' => t('Payment Status'), 'field' => 'pyment_status'),
      array('data' => t('Transaction Id'), 'field' => 'id'),
    );

    $transactions = DemoController::get_transaction_by_date_range($from_date, $to_date,$payment_type);
    $transactions_processed = [];   
    
    $rows = [];     
    if(count($transactions) > 0){

      foreach($transactions as $transaction){

        if (!array_key_exists($transaction->tsys_id, $transactions_processed)) {
          $transactions_processed[$transaction->tsys_id] = $transaction->order_date;
          $player_fname = $transaction->field_first_name_value;
          $player_lname = $transaction->field_las_value;
          $player_name  = $player_fname." ".$player_lname; 

          $parent_fname = $transaction->fn_field_first_name_value;
          $parent_lname = $transaction->field_last_name_value;
          $parents_name = $parent_fname.' '.$parent_lname; 

          if($transaction->payment_methd_type == "manual_payment") {
              $payment_method = 'Mannual Payment';
          }else{
              $payment_method = $transaction->payment_methd_type;
          }          
          $amount =  $currency_formatter->format($transaction->item_amount, 'USD');

          $rows[] = [date("M. d, Y",$transaction->order_date),
                    $player_name,
                    $parents_name,
                    $amount,
                    $payment_method,
                    $transaction->payment_status,
                    $transaction->order_id,
                  ];

        }
        else {
        unset($transactions_processed[$transaction->tsys_id]);
        continue;
        }

      }

    }else{
       $rows[] = ["Sorry , No Records Found.","","","","","",""];
    } 
    
    $build['location_table'] = array(
      '#theme' => 'table', '#header' => $header,'#rows' => $rows      
    );
    
    return $build;   
  }
