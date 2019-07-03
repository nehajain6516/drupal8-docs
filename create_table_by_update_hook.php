/**
 * Create new database table by update hook{custom_table}.
 */
function my_module_update_8206() {

  $database = \Drupal::database();
  $schema = $database->schema();
  $table_name = 'custom_table';

  $table_schema = [
    'description' => 'Use for capturing payment data',
    'fields' => [
      'id' => [
        'description' => 'Id.',
        'type' => 'serial',
        'unsigned' => TRUE,
        'not null' => TRUE,
      ],
      'club_id' => [
        'description' => 'Club id',
        'type' => 'int',
        'unsigned' => TRUE,
        'not null' => TRUE,
        'default' => 0,
      ],
      'month' => [
        'description' => 'Month',
        'type' => 'int',
        'unsigned' => TRUE,
        'not null' => TRUE,
        'default' => 0,
      ],
      'year' => [
        'description' => 'Year',
        'type' => 'int',
        'unsigned' => TRUE,
        'not null' => TRUE,
        'default' => 0,
      ],
     'payment_status' => [         
        'description' => '0 = not paid; 1 = paid ( Payment Status)',
        'type' => 'int',
        'size' => 'tiny',
        'not null' => TRUE,
        'default' => 0,
      ],
      'reason' => [
        'description' => 'Delay Reason',
        'type' => 'text',
        'null' => TRUE,
      ],
         
   ],
    'primary key' => ['id'],
  ];     

 $schema->createTable($table_name, $table_schema);

}
