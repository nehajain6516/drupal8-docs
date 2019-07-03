/**
 * Implements  update hook , add new field in existing table
 */
function my_module_update_8201() { 

  $payment_mode_type =  array(
    'description' => 'Payment Mode like Cash.',
    'type' => 'varchar',
    'length' => 50,
    'not null' => FALSE, 
    );

  $installment_details_id = array(
    'description' => 'Hold field collction id',
    'type' => 'varchar',
    'length' => 50,
    'not null' => FALSE,
    );

  $connection = \Drupal\Core\Database\Database::getConnection();
  $schema = $connection->schema();

  
  $schema->addField('existing_table_name', 'payment_mode_type', $payment_mode_type);
  $schema->addField('existing_table_name', 'installment_details_id', $installment_details_id);

  return $schema;
}
